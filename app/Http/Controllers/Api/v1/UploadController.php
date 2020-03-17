<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use Illuminate\Http\Request;
use Storage;

class UploadController extends Controller
{
    public function image(ImageRequest $request)
    {
        $images = $request->file('files');
        $paths = [];

        foreach ($images as $image) {
            $filename = $image->getClientOriginalName();
            $path = Storage::disk('public')->put('testing', $image);
            $paths[] = asset('storage/'.$path);
        }
        return response()->json(['data' => $paths]);
    }


    public function deleteFile($type, $name) {
        $image_path = Storage::disk('public')->path($type.'/'.$name);
        if (file_exists($image_path)) {
            @unlink($image_path);
        }
        return response()->json(['message' => 'Success delete']);
    }
}
