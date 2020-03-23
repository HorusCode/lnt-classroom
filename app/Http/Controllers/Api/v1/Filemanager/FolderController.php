<?php


namespace App\Http\Controllers\Api\v1\Filemanager;


class FolderController extends FilemanagerController
{
    public function getFolders()
    {
        $folder_types = array_filter(['user', 'share'], function ($type) {
            return $this->helper->allowFolderType($type);
        });

        $root_folders = array_map(function ($type) use ($folder_types) {
            $path = $this->filemanager->dir($this->helper->getRootFolder($type));
            return (object)[
                'name' => trans('filemanager.title-' . $type),
                'url' => $path->path('working_dir'),
                'children' => $path->folders(),
                'has_next' => !($type == end($folder_types)),
            ];
        }, $folder_types);

        return response()->json(['root_folders' => $root_folders]);
    }


}