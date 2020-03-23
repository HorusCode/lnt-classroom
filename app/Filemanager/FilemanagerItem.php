<?php


namespace App\Filemanager;


use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Str;

/**
 * Class FilemanagerItem
 * @package App\Filemanager
 */
class FilemanagerItem
{
    /**
     * @var FilemanagerPath
     */
    private $filemanager;
    /**
     * @var Filemanager
     */
    private $helper;

    /**
     * @var array
     */
    private $columns = ['name', 'url', 'time', 'icon', 'is_file', 'is_image', 'thumb_url'];
    /**
     * @var array
     */
    public $attributes = [];

    /**
     * FilemanagerItem constructor.
     * @param FilemanagerPath $filemanager
     * @param Filemanager $helper
     */
    public function __construct(FilemanagerPath $filemanager, Filemanager $helper)
    {
        $this->filemanager = $filemanager->thumb(false);
        $this->helper = $helper;
    }

    /**
     * @param $var_name
     * @return mixed
     */
    public function __get($var_name)
    {
        if (!array_key_exists($var_name, $this->attributes)) {
            $func_name = Str::camel($var_name);
            $this->attributes[$var_name] = $this->$func_name;
        }

        return $this->attributes[$var_name];
    }

    /**
     * @return $this
     */
    public function fill()
    {
        foreach ($this->columns as $column) {
            $this->__get($column);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function name()
    {
        return $this->filemanager->getName();
    }

    /**
     * @param string $type
     * @return string|string[]
     * @throws BindingResolutionException
     */
    public function path($type = 'absolute')
    {
        return $this->filemanager->path($type);
    }

    /**
     * @return bool
     */
    public function isDirectory()
    {
        return $this->filemanager->isDirectory();
    }

    /**
     * @return bool
     */
    public function isFile()
    {
        return !$this->isDirectory();
    }

    /**
     * @return bool
     */
    public function isImage()
    {
        if ($this->isFile()) {
            return Str::startsWith($this->mimeType(), 'image');
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function mimeType()
    {
        return $this->filemanager->mimeType();
    }

    /**
     * @return mixed
     */
    public function extension()
    {
        return $this->filemanager->extension();
    }

    /**
     * @return mixed|string|string[]
     */
    public function url()
    {
        if ($this->isDirectory()) {
            return $this->filemanager->path('working_dir');
        }

        return $this->filemanager->url();
    }

    /**
     * @return string
     */
    public function size()
    {
        return $this->isFile() ? $this->humanFilesize($this->filemanager->size()) : '';
    }

    /**
     * @return bool
     */
    public function time()
    {
        if ($this->isFile()) {
            return $this->filemanager->lastModified();
        }

        return false;
    }

    /**
     * @return mixed|string|null
     */
    public function thumbUrl()
    {
        if ($this->isDirectory()) {
            return asset('vendor/img/folder.png');
        }

        if ($this->isImage()) {
            return $this->filemanager->thumb($this->hasThumb())->url(true);
        }

        return null;
    }

    /**
     * @return mixed|string
     */
    public function icon()
    {
        if ($this->isDirectory()) {
            return 'mdi-folder';
        }

        if ($this->isImage()) {
            return 'mdi-image';
        }
        return $this->extension();
    }

    /**
     * @return array|\Illuminate\Contracts\Translation\Translator|mixed|string|null
     */
    public function type()
    {
        if ($this->isDirectory()) {
            return trans('filemanager.typ-folder');
        }

        if ($this->isImage()) {
            return $this->mimeType();
        }

        return $this->helper->getFileType($this->extension());
    }

    /**
     * @return bool
     */
    public function hasThumb()
    {
        if (!$this->isImage()) {
            return false;
        }

        if ($this->filemanager->thumb()->exists()) {
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    public function shouldCreateThumb()
    {
        if (!$this->helper->config('should_create_thumbnails')) {
            return false;
        }

        if (!$this->isImage()) {
            return false;
        }

        if (in_array($this->mimeType(), ['image/gif', 'image/svg+xml'])) {
            return false;
        }

        return true;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->filemanager->get();
    }

    /**
     * @param $bytes
     * @param int $decimals
     * @return string
     */
    public function humanFilesize($bytes, $decimals = 2)
    {
        $size = ['B', 'KB', 'MB', 'GB', 'TB'];
        $factor = floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f %s", $bytes / pow(1024, $factor), @$size[$factor]);
    }


}