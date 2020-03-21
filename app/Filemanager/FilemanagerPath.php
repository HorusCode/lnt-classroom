<?php


namespace App\Filemanager;


use App\Events\Filemanager\ImageIsUploading;
use App\Events\Filemanager\ImageWasUploaded;
use Dotenv\Exception\ValidationException;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class FilemanagerPath
{
    private $working_dir;
    private $item_name;
    private $is_thumb = false;

    private $helper;

    public function __construct(Filemanager $filemanager = null)
    {
        $this->helper = $filemanager;
    }

    public function __get($name)
    {
        if($name === 'storage') {
            return $this->helper->getStorage($this->path('url'));
        }
    }

    public function __call($func_name, $arguments)
    {
        return $this->storage->$func_name(...$arguments);
    }

    public function dir($working_dir)
    {
        $this->working_dir = $working_dir;
        return $this;
    }


    public function thumb($is_thumb = true)
    {
        $this->is_thumb = $is_thumb;
        return $this;
    }


    public function setName($item_name)
    {
        $this->item_name = $item_name;
        return $this;
    }

    public function getName()
    {
        return $this->item_name;
    }

    public function path($type = 'storage')
    {
        switch ($type) {
            case 'working_dir':
                return $this->translateToFilemanagerPath($this->normalizeWorkingDir());
                break;
            case 'url':
                return $this->helper->getCategoryName().$this->path('working_dir');
                break;
            case 'storage':
                return $this->translateToOSPath($this->path('url'));
                break;
            default:
                return $this->storage->rootPath().$this->path('storage');
        }
    }

    public function translateToFilemanagerPath($path)
    {
        return str_replace($this->helper->ds(), Filemanager::DS, $path);
    }


    public function translateToOSPath($path)
    {
        return str_replace(Filemanager::DS, $this->helper->ds(), $path);
    }

    public function url()
    {
        return $this->storage->url($this->path('url'));
    }


    public function folders()
    {
        $all_folders = array_map(function ($dir_path) {
            return $this->pretty($dir_path);
        }, $this->storage->directories());

        $folders = array_filter($all_folders, function($dir) {
            return $dir->name !== $this->helper->getThumbFolderName();
        });

        return $this->sortByColumn($folders);
    }

    public function files()
    {
        $files = array_map(function ($file_path) {
            return $this->pretty($file_path);
        }, $this->storage->files());

        return $this->sortByColumn($files);
    }

    public function pretty($item_path)
    {
        return Container::getInstance()->makeWith(FilemanagerItem::class, [
            'filemanager' => (clone $this)->setName($this->helper->getNameFromPath($item_path)),
            'helper' => $this-$this->helper
        ]);
    }

    public function delete()
    {
        if($this->isDirectory()) {
            return $this->storage->deleteDirectory();
        } else {
            return $this->storage->delete();
        }
    }

    public function createFolder()
    {
        if($this->storage->exists($this)) {
            return false;
        }

        $this->storage->makeDirectory(0777, true, true);
    }

    public function isDirectory()
    {
        $working_dir = $this->path('working_dir');
        $parent_dir = substr($working_dir, 0, strrpos($working_dir, '/'));

        $parent_dirs = array_map(function($dir_path) {
            return app(static::class)->translateToFilemanagerPath($dir_path);
        }, app(static::class)->dir($parent_dir)->directories());

        return in_array($this->path('url'), $parent_dirs);
    }

    public function directoryIsEmpty()
    {
        return count($this->storage->allFiles()) === 0;
    }

    public function normalizeWorkingDir()
    {
        $path = $this->working_dir
            ?: $this->helper->input('working_dir')
            ?: $this->helper->getRootFolder();

        if($this->is_thumb)
        {
            $path = rtrim($path, Filemanager::DS).Filemanager::DS.$this->helper->getThumbFolderName();
        }

        if($this->getName())
        {
            $path = rtrim($path, Filemanager::DS).Filemanager::DS.$this->getName();
        }

        return $path;
    }

    public function sortByColumn($arr_items)
    {
        $sort_by = $this->helper->input('sort_type');
        if(in_array($sort_by, ['name','time'])) {
            $key_to_sort = $sort_by;
        } else {
            $key_to_sort = 'name';
        }

        uasort($arr_items, function ($a, $b) use ($key_to_sort) {
            return strcmp($a->{$key_to_sort}, $b->{$key_to_sort});
        });

        return $arr_items;
    }

    public function error($error_type, $variables)
    {
        return $this->helper->error($error_type, $variables);
    }

    public function upload($file)
    {
        $this->uploadValidator($file);
        $new_file_name = $this->getNewName($file);
        $new_file_path = $this->setName($new_file_name)->path('absolute');
        event(new ImageIsUploading($new_file_path));

        try {
            $new_file_name = $this->saveFile($file, $new_file_name);
        } catch (\Exception $exception) {
            \Log::info($exception);
             $this->error('invalid');
        }

        event(new ImageWasUploaded($new_file_path));

        return $new_file_name;
    }

    public function uploadValidator($file)
    {
        $arr['file'] = $file;

        if($this->helper->config('should_validate_size', false)) {
            $max_size = $this->helper->maxUploadSize();
        } else {
            $max_size = ini_get('upload_max_filesize');
        }

        if($this->helper->config('should_validate_mime', false)) {
            $mimes = "|mimes:".implode(",", $this->helper->availableMimeTypes());
        } else {
            $mimes = "";
        }

        $validator = Validator::make($arr, [
            'file' => "required|max:{$max_size}".$mimes,
        ]);

        if($validator->fails()) {
            throw new ValidationException($validator);
        }

        return 'pass';
    }


    private function getNewName($file)
    {
        $new_file_name = $this->helper
            ->translateFromUtf8(trim(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)));
        if($this->helper->config('rename_file') === true) {
            $new_file_name = uniqid();
        } else if($this->helper->config('alphanumeric_filename') === true) {
            $new_file_name = preg_replace('/[^A-Za-z0-9\-\']/', '_', $new_file_name);
        }

        $extension = $file->getClientOriginalExtenstion();
        if($extension) {
            $new_file_name .= '.' . $extension;
        }

        return $new_file_name;
    }

    private function saveFile($file, $new_file_name)
    {
        $this->setName($new_file_name)->storage->save($file);

        $this->makeThumbnail($new_file_name);

        return $new_file_name;
    }

    public function makeThumbnail($file_name)
    {
        $original_image = $this->pretty($file_name);

        if (!$original_image->shouldCreateThumb()) {
            return;
        }

        // create folder for thumbnails
        $this->setName(null)->thumb(true)->createFolder();
        // generate cropped image content
        $this->setName($file_name)->thumb(true);
        $image = Image::make($original_image->get())
            ->fit(
                $this->helper->config('thumb_img_width', 200),
                $this->helper->config('thumb_img_height', 200)
            );

        $this->storage->put($image->stream()->detach());
    }

}