<?php


namespace App\Http\Controllers\Filemanager;


use App\Http\Repositories\FilemanagerRepository;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class Filemanager
 * @package App\Http\Controllers\Filemanager
 */
class Filemanager
{
    /**
     *
     */
    const DS = '/';

    /**
     * @var Config
     */
    protected $config;
    /**
     * @var Request
     */
    protected $request;

    /**
     * Filemanager constructor.
     * @param Config|null $config
     * @param Request|null $request
     */
    public function  __construct(Config $config = null, Request $request = null)
    {
        $this->config = $config;
        $this->request = $request;
    }

    /**
     * @param $storage_path
     * @return FilemanagerRepository
     */
    public function getStorage($storage_path)
    {
        return new FilemanagerRepository($storage_path, $this);
    }

    /**
     * @param $key
     * @return bool|false|string
     */
    public function input($key)
    {
        return $this->translateFromUtf8($this->request->input($key));
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function config($key, $default = null)
    {
        return $this->config->get('filemanager.'.$key, $default);
    }

    /**
     * @param $path
     * @return string|string[]
     */
    public function getNameFromPath($path)
    {
        return pathinfo($path, PATHINFO_BASENAME);
    }

    /**
     * @param $type
     * @return bool
     */
    public function allowFolderType($type)
    {
        if($type == 'user') {
            return $this->allowMultiUser();
        } else {
            return $this->allowShareFolder();
        }
    }

    /**
     * @return mixed
     */
    public function getCategoryName()
    {
        $type = $this->currentFilemanagerType();
        return $this->config('folder_categories.'.$type.'.folder_name', 'files');
    }

    /**
     * @return string
     */
    public function currentFilemanagerType()
    {
        $filemanager_type = 'file';

        $request_type = lcfirst(Str::singular($this->input('type') ?: ''));
        $available_types = array_keys($this->config('folder_categories') ?: []);

        if(in_array($request_type, $available_types)) {
            $filemanager_type = $request_type;
        }
        return $filemanager_type;
    }

    /**
     * @return mixed|string
     */
    public function getDisplayMode()
    {
        $type_key = $this->currentFilemanagerType();
        $startup_view = $this->config('folder_categories.'.$type_key.'.startup_view');

        $view_type = 'grid';
        $target_display_type = $this->input('show_list') ?: $startup_view;

        if(in_array($target_display_type, ['list', 'grid'])) {
            $view_type = $target_display_type;
        }

        return $view_type;
    }

    /**
     * @return mixed|string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getUserSlug()
    {
        $config = $this->config('private_folder_name');

        if(is_callable($config)) {
            return call_user_func($config);
        }

        if(class_exists($config)) {
            return app()->make($config)->userField();
        }

        return empty(auth()->user()) ? "" : auth()->user()->$config;
    }


    /**
     * @param null $type
     * @return string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getRootFolder($type = null)
    {
        if(is_null($type)) {
            $type = 'share';
            if($this->allowFolderType('user')) {
                $type = 'user';
            }
        }

        if($type === 'user') {
            $folder = $this->getUserSlug();
        } else {
            $folder = $this->config('shared_folder_name');
        }

        return '/'.$folder;

    }

    /**
     * @return mixed
     */
    public function getThumbFolderName()
    {
        return $this->config('thumb_folder_name');
    }

    /**
     * @param $ext
     * @return mixed
     */
    public function getFileType($ext)
    {
        return $this->config('file_type_array'.$ext, 'File');
    }

    /**
     * @return mixed
     */
    public function availableMimeTypes()
    {
        return $this->config('folder_categories.'.$this->currentFilemanagerType().'.valid_mime');
    }

    /**
     * @return mixed
     */
    public function maxUploadSize()
    {
        return $this->config('folder_categories.'.$this->currentFilemanagerType().'.max_size');
    }

    /**
     * @return bool
     */
    public function allowMultiUser()
    {
        return $this->config('allow_private_folder') === true;
    }

    /**
     * @return bool
     */
    public function allowShareFolder()
    {
        if(!$this->allowMultiUser()) {
            return true;
        }
        return $this->config('allow_shared_folder') === true;
    }

    /**
     * @param $input
     * @return bool|false|string
     */
    public function translateFromUtf8($input)
    {
        if($this->isRunningOnWindows())
        {
            $input = iconv('UTF-8',mb_detect_encoding($input), $input);
        }

        return $input;
    }

    /**
     * @return string
     */
    public function ds()
    {
        $ds = Filemanager::DS;
        if($this->isRunningOnWindows())
        {
            $ds = '\\';
        }
        return $ds;
    }

    /**
     * @return bool
     */
    public function isRunningOnWindows()
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }

    /**
     * @param $error_type
     * @param $variables
     * @throws \Exception
     */
    public function error($error_type, $variables)
    {
        throw new \Exception(trans('filemanager.error-'.$error_type, $variables));
    }

}