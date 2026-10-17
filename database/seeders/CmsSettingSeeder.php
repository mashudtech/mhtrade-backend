<?php

namespace Database\Seeders;

use App\Models\CmsSetting;
use Illuminate\Database\Seeder;

class CmsSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Contact settings
            ['key' => 'whatsapp',         'value' => '+971565837969',                   'label' => 'WhatsApp Number',      'group' => 'contact'],
            ['key' => 'whatsapp_link',    'value' => 'https://wa.me/971565837969',       'label' => 'WhatsApp Link',        'group' => 'contact'],
            ['key' => 'email',            'value' => 'contact@mhtradecap.com',           'label' => 'Contact Email',        'group' => 'contact'],
            ['key' => 'phone',            'value' => '+971 56 583 7969',                 'label' => 'Phone Number',         'group' => 'contact'],
            ['key' => 'office_address',   'value' => 'Dubai, United Arab Emirates',      'label' => 'Office Address',       'group' => 'contact'],

            // Social settings
            ['key' => 'linkedin',         'value' => 'https://www.linkedin.com/in/rezwan-shamim-5a5023418/', 'label' => 'LinkedIn URL', 'group' => 'social'],
            ['key' => 'facebook',         'value' => '',                                 'label' => 'Facebook URL',         'group' => 'social'],

            // General settings
            ['key' => 'site_name',        'value' => 'MH Trade Capital Solutions',       'label' => 'Site Name',            'group' => 'general'],
            ['key' => 'admin_email',      'value' => 'contact@mhtradecap.com',           'label' => 'Admin Notification Email', 'group' => 'general'],

            // SMTP settings (managed from admin panel)
            ['key' => 'smtp_host',        'value' => '',                                 'label' => 'SMTP Host',            'group' => 'smtp'],
            ['key' => 'smtp_port',        'value' => '587',                              'label' => 'SMTP Port',            'group' => 'smtp'],
            ['key' => 'smtp_username',    'value' => '',                                 'label' => 'SMTP Username',        'group' => 'smtp'],
            ['key' => 'smtp_password',    'value' => '',                                 'label' => 'SMTP Password',        'group' => 'smtp'],
            ['key' => 'smtp_encryption',  'value' => 'tls',                              'label' => 'Encryption (tls/ssl)', 'group' => 'smtp'],
            ['key' => 'smtp_from_name',   'value' => 'MH Trade Capital Solutions',       'label' => 'From Name',            'group' => 'smtp'],
            ['key' => 'smtp_from_email',  'value' => 'contact@mhtradecap.com',           'label' => 'From Email Address',   'group' => 'smtp'],
        ];

        foreach ($settings as $setting) {
            CmsSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        $this->command->info('✅ CMS settings seeded successfully.');
    }
}
