<?php


namespace App\Http\Controllers\Api\v1\Filemanager;


use App\Events\Filemanager\FolderIsRenaming;
use App\Events\Filemanager\ImageIsRenaming;

class RenameController extends FilemanagerController
{
    public function getRaname()
    {
        $old_name = $this->helper->input('file');
        $new_name = $this->helper->input('new_name');

        $old_file = $this->filemanager->pretty($old_name);

        $is_directory = $old_name->isDirectory();

        if(empty($new_name)) {
            if($is_directory) {
                return parent::error('folder-name');
            } else {
                return parent::error('file-name');
            }
        }

        if($this->helper->config('alphanumeric_directory') && preg_match('/[^\w-]/i', $new_name)) {
            return parent::error('folder-alnum');
        } elseif($this->filemanager->setName($new_name)->exists()) {
            return parent::error('rename');
        }

        if(!$is_directory) {
            $extension = $old_file->extension();
            if($extension) {
                $new_name = str_replace('.'.$extension, '', $new_name).'.'.$extension;
            }
        }

        $new_file = $this->filemanager->setName($new_name)->path('absolute');
        if($is_directory) {
            event(new FolderIsRenaming($old_file->path(), $new_file));
        } else {
            event(new ImageIsRenaming($old_file->path(), $new_file));
        }

        return parent::$success_response;
    }
}