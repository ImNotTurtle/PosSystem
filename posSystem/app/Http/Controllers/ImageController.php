<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
    //
    protected $model;
    public function __construct(){

    }

    //upload the file to public/assets
    public static function uploadImage($file, $folderName, $fileName)
    {
        if($file != NULL){
            //replace the white space in file name to _
            $fileName = str_replace(" ","_",$fileName);
            //replace \ character to /
            $folderName = str_replace("\\", "/", $folderName);
            $fileName = str_replace("\\", "/", $fileName);

            //folderName is sub directory to store in public/assets
            $extension = $file->extension();
            $relativePath = 'assets/'.$folderName;
            $fullPath = storage_path("app/public/".$relativePath);//where to store the image
            // Sử dụng timestamp để tránh trùng lặp
            $newAvatarName = time() . '_' . $fileName. "." . $extension;
            // Tạo thư mục nếu nó chưa tồn tại
            File::makeDirectory($fullPath, $mode = 0777, true, true);
            // Di chuyển tệp ảnh vào thư mục mong muốn
            $file->move($fullPath, $newAvatarName);

            return $folderName."/".$newAvatarName;
        }
        return "";
    }
}
