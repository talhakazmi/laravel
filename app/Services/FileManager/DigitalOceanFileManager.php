<?php

namespace App\Services\FileManager;

use Illuminate\Support\Facades\Storage;

class DigitalOceanFileManager implements FileManagerInterface
{
    private function getSpaceName()
    {
        return 'do_spaces';
    }

    private function getDisk()
    {
        return Storage::disk($this->getSpaceName());
    }

    private function getPath($path)
    {
        return 'public/' . $path;
    }


    public function getUrl($path)
    {
        return $this->getDisk()->url($this->getPath($path));
    }

    public function storeImage($file, $path)
    {
        $this->getDisk()->put($this->getPath($path), file_get_contents($file), 'public');
    }

    public function delete($path)
    {
        if ($this->getDisk()->exists($this->getPath($path))) {
            $this->getDisk()->delete($this->getPath($path));
        }
    }
}