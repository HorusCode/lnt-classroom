<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\File\File;;

class ImageRequest extends FormRequest
{


    public function rules()
    {
        return [
            'files' => 'required|array',
            'files.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ];
    }

    public function validationData()
    {
        $data = parent::validationData();
        if(!empty($data['files'])) {
            foreach ($data['files'] as $key => $file) {
                $data['files'][$key] = is_string($file) ? $this->convertToFile($file) : $file;
            }
        }
        return $data;
    }

    private function convertToFile($value)
    {
        if(strpos($value, ';base64') !== false) {
            [, $value] = explode(';', $value);
            [, $value] = explode(',', $value);
        }
        $binaryData = base64_decode($value);
        $tmpFile = tempnam(storage_path('app/tmp'), 'base64');
        file_put_contents($tmpFile, $binaryData);
        return new File($tmpFile);
    }
}
