<?php


namespace App\Http\Controllers\Api\v1\Filemanager;


class DownloadController extends FilemanagerController
{

    public function getDownload()
    {
        dd(request('file'));
        return response()->download($this->filemanager->setName(request('file'))->path('absolute'));
    }

}