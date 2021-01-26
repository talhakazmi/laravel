<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\FileManager\FileManagerInterface;

class FileManagerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\FileManager\FileManagerInterface', '\App\Services\FileManager\DigitalOceanFileManager');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(FileManagerInterface $fileManager)
    {
        View::share('fileManager', $fileManager);
    }
}
