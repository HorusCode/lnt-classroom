<?php

namespace App\Events\Filemanager;


class ImageIsDeleting
{
    private $path;

    /**
     * Create a new event instance.
     *
     * @param $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->path;
    }
}
