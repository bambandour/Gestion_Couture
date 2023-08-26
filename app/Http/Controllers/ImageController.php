<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageRequest;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function uploadImage(ImageRequest $request){
        $imageUpload=time().'.'.$request->image->extension();
        $request->image->move(public_path('images'),$imageUpload);
        return $imageUpload;
    }

    
}
