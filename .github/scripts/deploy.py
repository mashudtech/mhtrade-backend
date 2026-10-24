#!/usr/bin/env python3
"""
CI/CD Deployment Script for MH Trade Capital Solutions
Deploys updated files directly to cPanel via secure FTPS (TLS).
"""

import ftplib
import os
import ssl
import subprocess
import sys
import urllib.request
import urllib.parse


def get_changed_files():
    """Detect changed files between current commit and previous commit."""
    # Check if full deploy requested
    if '--full' in sys.argv or os.environ.get('FULL_DEPLOY') == '1':
        print('[INFO] Full deploy requested.')
        return None

    try:
        # Check if HEAD~1 exists
        res = subprocess.run(
            ['git', 'rev-parse', '--verify', 'HEAD~1'],
            stdout=subprocess.PIPE,
            stderr=subprocess.PIPE,
            check=False
        )
        if res.returncode != 0:
            print('[INFO] No previous commit found. Running full sync.')
            return None

        output = subprocess.check_output(
            ['git', 'diff', '--name-only', 'HEAD~1', 'HEAD'],
            text=True
        )
        files = [line.strip() for line in output.splitlines() if line.strip()]
        return files
    except Exception as e:
        print(f'[WARN] Error detecting git diff: {e}. Falling back to full sync.')
        return None


def get_all_deployable_files():
    """Get all deployable files in the repository."""
    deployable = []
    core_dirs = ['app', 'bootstrap', 'config', 'database', 'resources', 'routes', 'public']
    core_files = ['artisan', 'composer.json', 'composer.lock']

    for d in core_dirs:
        if not os.path.exists(d):
            continue
        for root, _, filenames in os.walk(d):
            for f in filenames:
                path = os.path.join(root, f)
                # Ignore .git, tests, build artifacts
                if any(x in path for x in ['/tests/', '.cache', '.phpunit']):
                    continue
                deployable.append(path)

    for cf in core_files:
        if os.path.exists(cf):
            deployable.append(cf)

    return deployable


def map_to_remote(local_path):
    """
    Map local file path to remote server path:
    - public/css/... -> public_html/css/...
    - public/...     -> public_html/...
    - app/..., resources/..., etc. -> laravel/app/..., laravel/resources/..., etc.
    """
    normalized = local_path.replace('\\', '/')
    if normalized.startswith('public/'):
        return 'public_html/' + normalized[len('public/'):]
    
    # Core backend files
    prefixes = ('app/', 'bootstrap/', 'config/', 'database/', 'resources/', 'routes/')
    direct_files = ('artisan', 'composer.json', 'composer.lock')
    
    if normalized.startswith(prefixes) or normalized in direct_files:
        return 'laravel/' + normalized

    return None


def ensure_remote_dir(ftp, remote_dir):
    """Recursively create remote directories if they don't exist."""
    parts = [p for p in remote_dir.split('/') if p]
    current = ''
    for part in parts:
        current = f'{current}/{part}' if current else part
        try:
            ftp.cwd(current)
            ftp.cwd('/')
        except ftplib.error_perm:
            try:
                ftp.mkd(current)
                print(f'  [MKDIR] Created remote directory: {current}')
            except Exception:
                pass


def upload_file(ftp, local_path, remote_path):
    """Upload a single file over FTP."""
    remote_dir = os.path.dirname(remote_path)
    if remote_dir:
        ensure_remote_dir(ftp, remote_dir)

    is_binary = any(local_path.lower().endswith(ext) for ext in [
        '.png', '.jpg', '.jpeg', '.webp', '.ico', '.pdf', '.woff', '.woff2', '.ttf', '.eot', '.zip'
    ])
    
    with open(local_path, 'rb' if is_binary else 'r', encoding=None if is_binary else 'utf-8', errors='ignore') as f:
        if is_binary:
            ftp.storbinary(f'STOR {remote_path}', f)
        else:
            ftp.storlines(f'STOR {remote_path}', open(local_path, 'rb'))
            
    print(f'  [OK] {local_path} -> {remote_path}')


def main():
    host = os.environ.get('FTP_HOST', '190.92.174.37')
    user = os.environ.get('FTP_USER', 'mhtradecap')
    password = os.environ.get('FTP_PASS')
    deploy_secret = os.environ.get('DEPLOY_SECRET')

    if not password:
        print('[ERROR] FTP_PASS environment variable is required.')
        sys.exit(1)

    print(f'[INFO] Connecting to {host} as {user} over FTPS (TLS)...')

    ftp = None
    try:
        ftp = ftplib.FTP_TLS(timeout=30)
        ftp.connect(host, 21)
        ftp.auth()
        ftp.prot_p()
        ftp.login(user, password)
        print('[INFO] Connected successfully over secure FTPS.')
    except Exception as e:
        print(f'[WARN] FTPS TLS failed: {e}. Falling back to standard FTP...')
        ftp = ftplib.FTP(timeout=30)
        ftp.connect(host, 21)
        ftp.login(user, password)
        print('[INFO] Connected via standard FTP.')

    changed = get_changed_files()
    if changed is None:
        files = get_all_deployable_files()
    else:
        files = changed

    to_upload = []
    for f in files:
        if not os.path.exists(f) or os.path.isdir(f):
            continue
        remote = map_to_remote(f)
        if remote:
            to_upload.append((f, remote))

    print(f'[INFO] Found {len(to_upload)} file(s) to deploy.')
    for local_path, remote_path in to_upload:
        try:
            upload_file(ftp, local_path, remote_path)
        except Exception as e:
            print(f'  [FAIL] Failed to upload {local_path}: {e}')
            sys.exit(1)

    ftp.quit()
    print('[INFO] All files deployed successfully.')

    # Trigger live migration and application cache refresh via secure deploy webhook
    token = deploy_secret or 'mhtrade_secure_deploy_2026'
    print('[INFO] Triggering live migration & cache clear webhook...')
    url = f'https://mhtradecap.com/api/deploy-cache-clear?token={urllib.parse.quote(token)}'
    ctx = ssl.create_default_context()
    ctx.check_hostname = False
    ctx.verify_mode = ssl.CERT_NONE
    req = urllib.request.Request(url, headers={'User-Agent': 'GitHub-Actions-Deployer/1.0'})
    try:
        with urllib.request.urlopen(req, context=ctx, timeout=30) as resp:
            print('[INFO] Webhook response:', resp.read().decode('utf-8'))
    except Exception as e:
        print(f'[WARN] Webhook notice: {e}')


if __name__ == '__main__':
    main()
