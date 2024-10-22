<?php

namespace App\Traits;

use Illuminate\Http\Request;
use File;

trait FileUploadTrait {

    function uploadImage(Request $request, $inputName,$oldPath =NULL, $path = "/uploads"){
            if($request->hasFile($inputName)){
                $image = $request->{$inputName}; /**folosesc curly braces to wrap it pt ca este dynamic nu static */
                $ext = $image->getClientOriginalExtension();
                $imageName = 'media_'.uniqid().'.'.$ext; //image.ext
                $image->move(public_path($path), $imageName);

                //sterg imaginea de dinainte daca exista
                if($oldPath && File::exists(public_path($oldPath)))
                {
                    File::delete(public_path($oldPath));

                }
                return $path.'/'.$imageName;
            }
            return NULL;
    }
    /**
     * Remove file
     */
    function removeImage(string $path) : void {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
