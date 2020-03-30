<?php


namespace App\Http\Repositories;


use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;
use Storage;
use League\Flysystem\Cached\CachedAdapter;
/**
 * Class FilemanagerRepository
 * @package App\Http\Repositories
 */
class FilemanagerRepository
{
    /**
     * @var Filesystem|FilesystemAdapter
     */
    private $disk;
    /**
     * @var
     */
    private $path;
    /**
     * @var
     */
    private $helper;

    /**
     * FilemanagerRepository constructor.
     * @param $storage_path
     * @param $helper
     */
    public function __construct($storage_path, $helper)
    {
        $this->helper = $helper;
        $this->disk = Storage::disk($this->helper->config('disk'));
        $this->path = $storage_path;
    }


    /**
     * @param $func_name
     * @param $arguments
     * @return mixed
     */
    public function __call($func_name, $arguments)
    {
        if (method_exists($this->disk, $func_name)) {
            return $this->disk->$func_name($this->path, ...$arguments);
        }
    }

    /**
     * @return mixed
     */
    public function rootPath()
    {
        $adapter = $this->disk->getDriver()->getAdapter();
        if ($adapter instanceof CachedAdapter) {
            $adapter = $adapter->getAdapter();
        }

        return $adapter->getPathPrefix();
    }

    /**
     * @param $new_filemanager_path
     * @return bool
     */
    public function move($new_filemanager_path)
    {
        return $this->disk->move($this->path, $new_filemanager_path->path('storage'));
    }

    /**
     * @param $file
     */
    public function save($file)
    {
        $nameint = strripos($this->path, '/');
        $nameclean = substr($this->path, $nameint + 1);
        $pathclean = substr_replace($this->path, "", $nameint);
        $this->disk->putFileAs($pathclean, $file, $nameclean, 'public');
    }

    /**
     * @param $path
     * @return string
     */
    public function url($path)
    {
        return $this->disk->url($path);
    }

    /**
     *
     */
    public function makeDirectory()
    {
        $this->disk->makeDirectory($this->path, ...func_get_args());

        if ($this->disk->has($this->path)) {
            $this->disk->setVisibility($this->path, 'public');
        }
    }

    /**
     * @return string|string[]
     */
    public function extension()
    {
        return pathinfo($this->path, PATHINFO_EXTENSION);
    }


}