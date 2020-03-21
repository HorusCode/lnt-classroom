<?php

namespace App\Http\Middleware;

use App\Filemanager\Filemanager;
use Closure;
use Illuminate\Support\Str;

/**
 * Class MultiUser
 * @package App\Http\Middleware
 */
class MultiUser
{

    /**
     * @var Filemanager|\Illuminate\Contracts\Foundation\Application|mixed
     */
    private $helper;

    /**
     * MultiUser constructor.
     */
    public function __construct()
    {
        $this->helper = app(Filemanager::class);
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle($request, Closure $next)
    {
        if ($this->helper->allowFolderType('user')) {
            $previous_dir = $request->input('working_dir');
            $working_dir = $this->helper->getRootFolder('user');

            if ($previous_dir == null) {
                $request->merge(compact('working_dir'));
            } elseif (!$this->validDir($previous_dir)) {
                $request->replace(compact('working_dir'));
            }

        }

        return $next($request);
    }


    /**
     * @param $previous_dir
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function validDir($previous_dir)
    {
        if (Str::startsWith($previous_dir, $this->helper->getRootFolder('share'))) {
            return true;
        }

        if (Str::startsWith($previous_dir, $this->helper->getRootFolder('user'))) {
            return true;
        }

        return false;
    }

}
