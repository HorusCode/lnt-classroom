<?php


namespace App\Http\Controllers\Api\v1\Filemanager;


use App\Events\Filemanager\ImageIsDeleting;
use App\Events\Filemanager\ImageWasDeleted;

class DeleteController extends FilemanagerController
{
    public function getDelete()
    {
        $item_names = request('items');
        $errors = [];

        foreach ($item_names as $item_name) {
            $file_to_delete = $this->filemanager->pretty($item_name);
            $file_path = $file_to_delete->path();

            event(new ImageIsDeleting($file_path));


            if(is_null($item_name)) {
                array_push($errors, parent::error('folder-name'));
                continue;
            }

            if(!$this->filemanager->setName($item_name)->exists()) {
                array_push($errors, parent::error('folder_not_found', ['folder' => $file_path]));
                continue;
            }

            if($this->filemanager->setName($item_name)->isDirectory()) {
                if(!$this->filemanager->setName($item_name)->directoryIsEmpty()) {
                    array_push($errors, parent::error('delete_folder'));
                    continue;
                }
            } else {
                if($item_name->isImage()) {
                    $this->filemanager->setName($item_name)->thumb()->delete();
                }
            }

            $this->filemanager->setName($item_name)->delete();

            event(new ImageWasDeleted($file_path));
        }
        if(count($errors) > 0) {
            return $errors;
        }

        return parent::$success_response;
    }
}