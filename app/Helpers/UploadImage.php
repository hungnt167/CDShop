<?php
/**
 * Created by PhpStorm.
 * User: VS9 X64Bit
 * Date: 7/14/2015
 * Time: 9:16 AM
 */

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class UploadImage
{
    var $name = '';

    public function upload($image)
    {
        // getting all of the post data
        $file = array('image' => $image);
        // setting up rules
        $rules = array('image' => 'max:5000|mimes:jpeg,bmp,png'); //mimes:jpeg,bmp,png and for max size max:5000
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($file, $rules);
        if ($validator->fails()) {
            // send back to the page with the input data and errors
            return false;
        } else {
            // checking file is valid.
//            dd($image);
            if ($image->isValid()) {
                $destinationPath = 'uploads/'; // upload path
                $extension = $image->getClientOriginalExtension(); // getting image extension
                $fileName = time() . '.' . $extension; // renameing image
                $fileNameThumb = 'thumb' . time() . '.' . $extension; // renameing image
                $path = public_path($destinationPath . $fileName);
                $pathThumb = public_path($destinationPath . $fileNameThumb);

                Image::make($image->getRealPath())->resize(200, 200)->save($path);
                Image::make($image->getRealPath())->resize(50, 50)->save($pathThumb);
                // uploading file to given path
                $this->name = $fileName;
                return true;
            } else {
                return false;
            }
        }
    }

    public function _upload($oldName, $image)
    {
        // getting all of the post data
        $file = array('image' => $image);
        // setting up rules
        $rules = array('image' => 'max:5000|mimes:jpeg,bmp,png',); //mimes:jpeg,bmp,png and for max size max:5000
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($file, $rules);


        if ($validator->fails()) {
            // send back to the page with the input data and errors
            return false;
        } else {

            // checking file is valid.
            if ($image->isValid()) {

                $destinationPath = 'uploads/'; // upload path
                $extension = $image->getClientOriginalExtension(); // getting image extension
                $fileName = time() . '.' . $extension; // renameing image
                $fileNameThumb = 'thumb' . time() . '.' . $extension; // renameing image
                $path = public_path($destinationPath . $fileName);
                $pathThumb = public_path($destinationPath . $fileNameThumb);

                Image::make($image->getRealPath())->resize(150, 200)->save($path);
                Image::make($image->getRealPath())->resize(40, 50)->save($pathThumb);
                // uploading file to given path
                // sending back with message
                Session::flash('success', 'Upload successfully');
//                dd($fileName);
                //check name
                if ($oldName != '' && $oldName!='person.png') {
                    $path= __DIR__ . "/../../public/uploads/" ;
                    if (File::delete($path.$oldName) && File::delete($path.'thumb'.$oldName)) {
                        return true;
                    } else return false;
                }
                $this->name = $fileName;
                return true;
            } else {
                // sending back with error message.
                Session::flash('error', 'uploaded file is not valid');
                return false;
            }
        }
    }

    public function multiple_upload($files)
    {
        // Making counting of uploaded images
        $file_count = count($files);
        // start count how many uploaded
        $uploadcount = 0;
        foreach ($files as $file) {
            $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
            $validator = Validator::make(array('file' => $file), $rules);
            if ($validator->passes()) {
                $destinationPath = 'uploads/'; // upload path
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $fileName = time() . '.' . $extension; // renameing image
                $fileNameThumb = 'thumb' . time() . '.' . $extension; // renameing image
                $path = public_path($destinationPath . $fileName);
                $pathThumb = public_path($destinationPath . $fileNameThumb);

                Image::make($file->getRealPath())->resize(200, 200)->save($path);
                Image::make($file->getRealPath())->resize(50, 50)->save($pathThumb);
                // uploading file to given path

                $this->name .= $fileName . ',';
                $uploadcount++;
            }
        }
        if ($uploadcount == $file_count) {
            $this->name = substr($this->name, 0, -1);
            Session::flash('success', 'Upload successfully');
            return true;
        } else {
            return false;
        }
    }

    public static function  removeImage($name)
    {
        //check name
        if ($name != '') {
            $path= __DIR__ . "/../../public/uploads/" ;
            if (File::delete($path.$name) && File::delete($path.'thumb'.$name)) {
                return true;
            } else return false;
        } else return true;

    }
}