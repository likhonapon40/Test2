<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MyHelperProvider extends ServiceProvider
{
    static public function slugify($text){
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // transliterate
        //$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, '-');
        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        // lowercase
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

    static public function photoUpload($photoData,$folderName,$width=null,$height=null){
        $photoOrgName=self::slugify($photoData->getClientOriginalName());
        $photoType=$photoData->getClientOriginalExtension();

        //$fileType = $photoData->getClientOriginalName();
        $fileName =substr($photoOrgName,0,-4).date('d-m-YH-i-s').'.'.$photoType;
        $path2 = $folderName. date('Y/m/d');
        //return $path2;
        if (!is_dir($path2)) {
            mkdir("$path2", 0777, true);
        }
        if ($width!=null && $height!=null){ // width & height mention-------------------
            $img = \Image::make($photoData);
            $img->resize($width, $height);
            $img->save($folderName. date('Y/m/d/') . $fileName);
            return $photoUploadedPath=$folderName . date('Y/m/d/') . $fileName;
        }elseif ($width!=null){ // only width mention-------------------
            $img = \Image::make($photoData);
            $img->resize($width,null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($folderName. date('Y/m/d/') . $fileName);
            return $photoUploadedPath=$folderName . date('Y/m/d/') . $fileName;
        }else{
            $img = \Image::make($photoData);
            $img->save($folderName. date('Y/m/d/') . $fileName);
            return $photoUploadedPath=$folderName . date('Y/m/d/') . $fileName;
        }


    }

    static public function fileUpload($filedata,$folderName){

        $fileType = $filedata->getClientOriginalExtension();
        $fileName = rand(1, 1000) . date('dmyhis') . "." . $fileType;
        $path2 = $folderName. date('Y/m/d');
        //return $path2;
        if (!is_dir($path2)) {
            mkdir("$path2", 0777, true);
        }
        $img =move(public_path($filedata) . $folderName);
        //$img->resize(400, 330);
        $img->save($folderName. date('Y/m/d/') . $fileName);
        return $photoUploadedPath=$folderName . date('Y/m/d/') . $fileName;

    }

}
