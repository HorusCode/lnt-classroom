<?php


namespace App\Filemanager;


class FilemanagerItem
{
    private $filemanager;
    private $helper;

    private $columns = ['name','url','time','icon','is_file','is_image','thumb_url'];
    public $attributes = [];

    public function __construct(FilemanagerPath $filemanager, Filemanager $helper)
    {
        $this->filemanager = $filemanager;
        $this->helper = $helper;
    }

}