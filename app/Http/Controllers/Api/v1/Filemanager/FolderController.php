<?php


namespace App\Http\Controllers\Api\v1\Filemanager;


class FolderController extends FilemanagerController
{
    public function getFolders()
    {
        $folder_types = array_filter(['user', 'share'], function ($type) {
            return $this->helper->allowFolderType($type);
        });

        $root_folders = $this->getFoldersOnType($folder_types);

        return response()->json(['data' => $root_folders]);
    }


    public function getAddFolder()
    {
        $folder_name = $this->helper->input('name');
        try {
            if($folder_name === null || $folder_name === "") {
                return $this->helper->error('folder-name');
            } elseif($this->filemanager->setName($folder_name)->exists()) {
                return $this->helper->error('folder-exist');
            } elseif($this->helper->config('alphanumeric_directory') && preg_match('/[^\w-]/i', $folder_name)) {
                return $this->helper->error('folder-alnum');
            } else {
                $this->filemanager->setName($folder_name)->createFolder();
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return parent::$success_response;
    }

}