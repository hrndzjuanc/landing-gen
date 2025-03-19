<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Handles image upload operations
 */
class ImageUploadController extends Controller
{
    /**
     * Upload an image to a dynamic landing folder
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadToLanding(Request $request)
    {
        $request->validate([
            'files' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $landing_id = $request->id;

        $image_path = $request->file('files')->store("/landings/{$landing_id}", 'public');
        
        return response()->json([
            'success' => true,
            'path' => url(Storage::url($image_path))
        ], 201);
    }
} 