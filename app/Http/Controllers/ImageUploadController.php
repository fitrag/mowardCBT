<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|max:2048'
        ]);

        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = 'question_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('questions', $filename, 'public');
            $url = asset('public/storage/' . $path);

            return response()->json([
                'url' => $url
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
