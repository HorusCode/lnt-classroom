<?php


namespace App\Http\Controllers\Api\v1\Filemanager;


use Log;

class UploadController extends FilemanagerController
{
    protected $errors;

    public function __construct()
    {
        parent::__construct();
        $this->errors = [];
    }

    public function upload()
    {
        $uploaded_files = request()->file('upload');
        $error_bag = [];
        $new_filename = null;

        foreach (is_array($uploaded_files) ? $uploaded_files : [$uploaded_files] as $file) {
            try {
                $new_filename = $this->filemanager->upload();
            } catch (\Exception $exception) {
                Log::error($exception->getMessage(), [
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTraceAsString()
                ]);
                array_push($error_bag, $exception->getMessage());
            }
        }

        if(is_array($uploaded_files)) {
            $response = count($error_bag) > 0 ? $error_bag : [parent::$success_response];
        } else {
            if(is_null($new_filename)) {
                $response = $error_bag[0];
            } else {
                $response = $this->filemanager->setName($new_filename)->url();
            }
        }

        return response()->json(['data' => $response]);
    }
}