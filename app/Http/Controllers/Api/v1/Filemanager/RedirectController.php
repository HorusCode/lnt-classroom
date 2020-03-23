<?php


namespace App\Http\Controllers\Api\v1\Filemanager;


use Storage;

class RedirectController extends FilemanagerController
{
    public function showFile($file_path)
    {
        $storage = Storage::disk($this->helper->config('disk'));
        if (!$storage->exists($file_path)) {
            abort(404);
        }

        return response($storage->get($file_path))->header('Content-Type', $storage->mimeType($file_path));
    }
}