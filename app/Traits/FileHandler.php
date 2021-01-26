<?php

namespace App\Traits;

use App\Services\FileManager\FileManagerInterface;


trait FileHandler
{
    public $fileManager;

    public function setFileManager(FileManagerInterface $fileManager) {
        $this->fileManager = $fileManager;
    }

    /**
     * Does very basic image validity checking and stores it. Redirects back if somethings wrong.
     * @Notice: This is not an alternative to the model validation for this field.
     *
     * @param Request $file
     * @param string $directory
     * @return string
     */
    public function verifyAndStoreImage($file, $directory = 'public/' ) {

        if(is_string($file)) {
            $fileExt = pathinfo($file, PATHINFO_EXTENSION);
        }else {
            $fileExt = $file->getClientOriginalExtension();
        }
        $fileNameNew = uniqid() . time() . '.' . $fileExt;
        $filePath = $directory . $fileNameNew;
        $this->fileManager->storeImage($file, $filePath);

        return $fileNameNew;
    }

}