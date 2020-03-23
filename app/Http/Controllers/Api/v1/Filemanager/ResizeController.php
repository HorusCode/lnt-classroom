<?php


namespace App\Http\Controllers\Api\v1\Filemanager;

use App\Events\Filemanager\ImageIsResizing;
use App\Events\Filemanager\ImageWasResized;
use Image;

class ResizeController extends FilemanagerController
{

    public function getResize()
    {
        $ratio = 1.0;
        $image = request('img');

        $original_image = Image::make($this->filemanager->setName($image)->path('absolute'));
        $original_width = $original_image->width();
        $original_height = $original_image->height();

        $scaled = false;

        //TODO: Fix size should be configurable
        if($original_width > 600) {
            $ratio = 600 / $original_width;
            $width = $original_width * $ratio;
            $height = $original_height * $ratio;
            $scaled = true;
        } else {
            $width = $original_width;
            $height = $original_height;
        }

        if ($height > 400) {
            $ratio = 400 / $original_height;
            $width = $original_width * $ratio;
            $height = $original_height * $ratio;
            $scaled = true;
        }

        return response()->json([
            'img' => $this->filemanager->pretty($image),
            'height' => number_format($height, 0),
            'width' => $width,
            'original_height' => $original_height,
            'original_width' => $original_width,
            'scaled' => $scaled,
            'ratio' => $ratio
        ]);
    }

    public function performResize()
    {
        $image_path = $this->filemanager->setName(request('img'))->path('absolute');

        event(new ImageIsResizing($image_path));
        Image::make($image_path)->resize(request('dataWidht'), request('dataHeight'))->save();
        event(new ImageWasResized($image_path));

        return parent::$success_response;
    }
}