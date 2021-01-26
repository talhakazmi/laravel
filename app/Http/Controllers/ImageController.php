<?php

namespace App\Http\Controllers;

use App\Services\FileManager\FileManagerInterface;
use App\Traits\FileHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use  \Illuminate\Support\Facades\File;
class ImageController extends Controller
{
    use FileHandler;

    public function __construct(FileManagerInterface $fileManager)
    {
        $this->setFileManager($fileManager);
    }

    public function store(Request $request, $imageFor)
    {
        $this->validate($request,[
            'image' => 'mimes:jpeg,png,jpg,gif,svg'
        ]);
        $image = $request->file('image');
        $extension = $image->getClientOriginalExtension();
        $fileNameNew    =   $this->verifyAndStoreImage($image, 'images/');
        /*Storage::disk('public')
            ->put('images/' . $imageFor . '/' . $image->getFilename().'.'.$extension, File::get($image));*/
        return response()->json([
            'name' => $this->fileManager->getUrl('images/' . $fileNameNew)
        ]);
    }
}
