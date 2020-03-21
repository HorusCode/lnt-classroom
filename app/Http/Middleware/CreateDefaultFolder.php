<?php

namespace App\Http\Middleware;

use App\Filemanager\Filemanager;
use App\Filemanager\FilemanagerPath;
use Closure;

class CreateDefaultFolder
{

    private $filemanager;
    private $helper;

    public function __construct()
    {
        $this->filemanager = app(FilemanagerPath::class);
        $this->helper = app(Filemanager::class);
    }



    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->checkDefaultFolderExists('user');
        $this->checkDefaultFolderExists('share');

        return $next($request);
    }

    private function checkDefaultFolderExists($type = 'share')
    {
        if(!$this->helper->allowFolderType($type)) {
            return;
        }
        $this->filemanager->dir($this->helper->getRootFolder($type))->createFolder();
    }
}
