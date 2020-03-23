<?php


namespace App\Http\Controllers\Api\v1\Filemanager;


class FolderController extends FilemanagerController
{
    public function getFolders()
    {
        $folder_types = array_filter(['user', 'share'], function ($type) {
            return $this->helper->allowFolderType($type);
        });

        $root_folders = $this->getFolldersOnType($folder_types);

        return response()->json(['root_folders' => $root_folders]);
    }


}