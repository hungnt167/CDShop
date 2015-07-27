<?php

namespace App\Http\Controllers;

use App\Artist;
use App\Http\Requests\CreatArtistRequest;
use App\Http\Requests\DestroyArtistRequest;
use App\Http\Requests\UpdateArtistRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use UploadImage;

class ArtistController extends Controller
{

//================================================= CREATE A ARTIST ==================================================//
    public function create(CreatArtistRequest $request)
    {
        $data   = $request->all();
        $upload = new UploadImage();
        $model  = new Artist();
        if (isset($data['image'])) {
            if (!is_null($data['image']) && !empty($data['image'])) {
                $image = Input::file('image');
                $upload->upload($image);
                $model->avatar = $upload->name;
            }
        } else {
            $model->avatar = url() . 'person.png';
        }
        $model->name        = $data['name'];
        $model->description = $data['description'];
        $model->talent      = $data['talent'];
        $model->save();
        return redirect()->back()->with('success', "Added!");
    }

//================================================= UPDATE A INFO ARTIST ==============================================//
    public function update(UpdateArtistRequest $request)
    {
        $dataRequest = $request->all();
        $model       = Artist::where('id', $dataRequest['id'])->first()->toArray();

        if (!is_null(Input::file('image'))) {
            $upload = new UploadImage();
            $image  = Input::file('image');
            //Check has Avt
            if ($upload->_upload($model['avatar'], $image)) {
                $dataRequest['avatar'] = $upload->name;
                return redirect_errors('Error Update Image!');
            }
        }
        Artist::where('id', $dataRequest['id'])->update($dataRequest);
        return redirect()->back()->with('success', "Update!");
    }

//================================================= HIDE ARTIST =======================================================//
    public function destroy(DestroyArtistRequest $request)
    {
        $id    = Input::get('id');
        $model = Artist::where('id', $id)->first()->toArray();
        if (Artist::where('id', $id)->delete()) {
            //check avatar
            UploadImage::removeImage($model['avatar']);
            return redirect()->back()->with('success', "Hided!");
        }
    }

//================================================= GET DATA FOR TABLE USING AJAX =====================================//
    public function getDataAjax(Request $request)
    {
        $dataRequest = $request->all();
        $model       = new Artist();
//        dd($model);
        $result = $model->getDataForPagination($dataRequest);
        return (json_encode($result));
    }

//================================================= GET DATA A ARTIST USING AJAX =====================================//
    public function getDataArtist(DestroyArtistRequest $request)
    {
        $id     = Input::get('id');
        $result = [];
        $model  = new Artist();
        $data   = $model->where('id', $id)->first()->toArray();
        foreach ($data as $k => $aData) {
            $result[$k] = $aData;
        }
        $nameFileAvatar   = $result['avatar'];
        $result['avatar'] = $nameFileAvatar;
        return json_encode($result);
    }
}