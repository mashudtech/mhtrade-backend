<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    /**
     * Upload an image via AJAX (used by Summernote editor and general image pickers).
     */
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'file'  => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
        ]);

        $file = $request->file('image') ?? $request->file('file');

        if (!$file) {
            return response()->json(['success' => false, 'message' => 'No image file uploaded.'], 422);
        }

        $destinationPath = public_path('images/uploads');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move($destinationPath, $filename);

        $url = asset('images/uploads/' . $filename);

        return response()->json([
            'success'  => true,
            'url'      => $url,
            'path'     => 'images/uploads/' . $filename,
            'filename' => $filename,
        ]);
    }
}
