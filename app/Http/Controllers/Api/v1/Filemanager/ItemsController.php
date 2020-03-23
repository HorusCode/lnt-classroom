<?php


namespace App\Http\Controllers\Api\v1\Filemanager;


use App\Events\Filemanager\FileIsMoving;
use App\Events\Filemanager\FileWasMoving;
use App\Events\Filemanager\FolderIsMoving;
use App\Events\Filemanager\FolderWasMoving;

class ItemsController extends FilemanagerController
{

    public function getItems()
    {
        return [
            'items' => array_map(function ($item) {
                return $item->fill()->attributes;
            }, array_merge($this->filemanager->folders(), $this->filemanager->files())),
            'display' => $this->helper->getDisplayMode(),
            'working_dir' => $this->filemanager->path('working_dir'),
        ];
    }

    public function move()
    {
        $items = request('items');
        $folder_types = array_filter(['user', 'share'], function ($type) {
            return $this->helper->allowFolderType($type);
        });
        $root_folders = $this->getFolldersOnType($folder_types);
        return response()->json([
            'root_folders' => $root_folders,
            'items' => $items,
        ]);
    }

    public function domove()
    {
        $target = $this->helper->input('goToFolder');
        $items = $this->helper->input('items');

        foreach ($items as $item) {
            $old_file = $this->filemanager->pretty($item);
            $is_directory = $old_file->isDirectory();
            if ($old_file->hasThumb()) {
                $new_file = $this->filemanager->setName($item)->thumb()->dir($target);
                if ($is_directory) {
                    event(new FolderIsMoving($old_file->path(), $new_file->path()));
                } else {
                    event(new FileIsMoving($old_file->path(), $new_file->path()));
                }
                $this->filemanager->setName($item)->thumb()->move($new_file);
            }
            $new_file = $this->filemanager->setName($item)->dir($target);
            $this->filemanager->setName($item)->move($new_file);
            if ($is_directory) {
                event(new FolderWasMoving($old_file->path(), $new_file->path()));
            } else {
                event(new FileWasMoving($old_file->path(), $new_file->path()));
            }

        };
        return parent::$success_response;
    }


}