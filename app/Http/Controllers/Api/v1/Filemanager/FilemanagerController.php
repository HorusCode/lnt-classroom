<?php


namespace App\Http\Controllers\Api\v1\Filemanager;


use App\Filemanager\Filemanager;
use App\Filemanager\FilemanagerPath;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;

/**
 * Class FilemanagerController
 * @package App\Http\Controllers\Api\v1\Filemanager
 */
class FilemanagerController extends Controller
{
    /**
     * @var string
     */
    protected static $success_response = 'OK';


    /**
     * FilemanagerController constructor.
     */
    public function __construct()
    {
        $this->applyIniOverrides();
    }

    /**
     * @param $name
     * @return Application|mixed
     */
    public function __get($name)
    {
        if ($name === 'filemanager') {
            return app(FilemanagerPath::class);
        } else if ($name === "helper") {
            return app(Filemanager::class);
        }
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        $arr_errors = [];

        if (!extension_loaded('gd') && !extension_loaded('imagick')) {
            array_push($arr_errors, trans('filemanager.message-extension_not_found'));
        }

        if (!extension_loaded('exif')) {
            array_push($arr_errors, 'EXIF extension not found');
        }

        if (!extension_loaded('fileinfo')) {
            array_push($arr_errors, 'Fileinfo extension not found');
        }

        $mine_config_key = 'filemanager.folder_categories.'
            . $this->helper->currentFilemanagerType()
            . '.valid_mime';

        if (!is_array(config($mine_config_key))) {
            array_push($arr_errors, 'Config: ' . $mine_config_key . '.is not a valid array');
        }

        return $arr_errors;
    }

    /**
     * @param $error_type
     * @param array $variables
     * @throws \Exception
     */
    public function error($error_type, $variables = [])
    {
        $this->helper->error($error_type, $variables);
    }

    public function applyIniOverrides()
    {
        $overrides = $this->helper->config('php_ini_overrides');

        if ($overrides && is_array($overrides) && count($overrides) === 0) {
            return;
        }

        foreach ($overrides as $key => $override) {
            if ($override && $override != 'false') {
                ini_set($key, $override);
            }
        }
    }

    public function getFoldersOnType($folder_types)
    {
        return array_map(function ($type) use ($folder_types) {
            $path = $this->filemanager->dir($this->helper->getRootFolder($type));
            return (object)[
                'name' => trans('filemanager.title-' . $type),
                'url' => $path->path('working_dir'),
                'children' => $path->folders(),
                'has_next' => !($type == end($folder_types)),
            ];
        }, $folder_types);

    }


}