<?php

namespace App\Events\Filemanager;



class FileWasMoving
{
    private $old_path;
    private $new_path;

    /**
     * Create a new event instance.
     *
     * @param $old_path
     * @param $new_path
     */
    public function __construct($old_path, $new_path)
    {
        $this->old_path = $old_path;
        $this->new_path = $new_path;
    }

    /**
     * @return string
     */
    public function oldPath()
    {
        return $this->old_path;
    }

    public function newPath()
    {
        return $this->new_path;
    }
}
