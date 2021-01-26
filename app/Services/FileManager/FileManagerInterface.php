<?php

namespace App\Services\FileManager;

interface FileManagerInterface
{
    /**
     * @param $path string
     * @return string
     */
    public function getUrl($path);

    /**
     * @param Request $file
     * @param string $path
     * @return string
     */
    public function storeImage($file, $path);

    /**
     * @param string $path
     * @return void
     */
    public function delete($path);
}
