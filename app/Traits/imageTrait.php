<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

trait ImageTrait{
    public function convertImage(){

    }

    public function uploadAndInsertImage($request, $columnName, $model)
    {
        $imagePath = $request->file('image')->getPathname();
        $base64Image = base64_encode(File::get($imagePath));

        $imageModel = new $model();
        $imageModel->$columnName = $base64Image;
        $imageModel->save();

        return $imageModel;
    }
}
