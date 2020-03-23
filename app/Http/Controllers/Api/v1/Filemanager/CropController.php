<?php


namespace App\Http\Controllers\Api\v1\Filemanager;


use App\Events\Filemanager\ImageIsCropping;
use App\Events\Filemanager\ImageWasCropped;
use Image;

class CropController extends FilemanagerController
{
    public function getCropimage($overWtire = true)
    {
        $image_name = request('img');
        $image_path = $this->filemanager->setName($image_name)->path('absolute');
        $crop_path = $image_path;

        if(!$overWtire) {
            $fileParts = explode('.', $image_name);
            $fileParts[count($fileParts) - 2] = $fileParts[count($fileParts) - 2].'_cropped_'.time();
            $crop_path = $this->filemanager->setName(implode('.',$fileParts))->path('absolute');
        }

        event(new ImageIsCropping($image_path));

        $crop_info = request()->only('dataWidth', 'dataHeight','dataX','dataY');


        Image::make($image_path)
            ->crop(...array_values($crop_info))
            ->save($crop_path);

        $this->filemanager->makeThumbnail($image_name);

        event(new ImageWasCropped($image_path));
    }

    public function getNewCropimage()
    {
        $this->getCropimage(false);
    }

}