<?php

namespace App\Http\Controllers\Admin;

use App\Advertisement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AdvertisementController extends Controller
{
    public function index()
    {
        $advertisement=Advertisement::get();
        return view('admin.manage_advertisements',['advertisement'=>$advertisement]);
    }

    public function getAddAdvertisement()
    {
        return view('admin.create_advertisement');
    }

    public function postAddAdvertisement(Request $request)
    {
        $this->validate(
            $request, 
            [
                'title' => 'required',
                'url' => 'required',
                'duration'=>'required|numeric',
                'image-data'=>'required'
            ],
            [
                'title.required'=>'Title is required',
                'url.required'=>'URL is required',
                'duration.required'=>'Duration is required',
                'image-data.required'=>'Image is required'
            ]
        );

        $advertisement=new Advertisement();
        $advertisement->title=$request['title'];
        $advertisement->validity=$request['duration'];
        $advertisement->url=$request['url'];
        $advertisement->detail=$request['detail'];

        if(isset($request['publish']))
            $advertisement->published_on = Carbon::now();
        else
            $advertisement->published_on = null;

        //image save
        $img = $request['image-data'];
        //decode the url, because we want to use decoded characters to use explode
        $decoded = urldecode($img);

        //get image extension
        $ext = explode(';', $decoded);
        $ext = explode(':', $ext[0]);
        $ext = array_pop($ext);
        $ext = explode('/', $ext);
        $ext = array_pop($ext);

        //save image in file
        $img_name = "advert-".time().".".$ext;
        $path = public_path() . "/images/advertisement/" . $img_name;
        $img = substr($img, strpos($img, ",")+1);
        $data = base64_decode($img);
        $success = file_put_contents($path, $data);

        $error = '';
        $success ? $advertisement->image = $img_name : $error = 'Unable to save cover image';


        if($advertisement->save()){
            return redirect()->back()->with('message', 'Successful');
        }
        else
        {
            return redirect()->back()->with('message', 'Failed');
        }

    }

    public function getEditAdvertisement($id)
    {
        $advertisement = Advertisement::where('id',$id)->first();
        return view('admin.create_advertisement')->with('advertisement', $advertisement);
    }

    public function postEditAdvertisement(Request $request)
    {
        $advertisement = Advertisement::where('id', $request['id'])->first();
        $advertisement->title = $request['title'];
        $advertisement->url = 'http://'.$request['url'];
        $advertisement->detail = $request['detail'];

        if($request['publish'] != '')
            $advertisement->published_on = Carbon::now();
        else
            $advertisement->published_on = null;

        //image save
        $img = $request['image-data'];
        //decode the url, because we want to use decoded characters to use explode
        $decoded = urldecode($img);

        //get image extension
        $ext = explode(';', $decoded);
        $ext = explode(':', $ext[0]);
        $ext = array_pop($ext);
        $ext = explode('/', $ext);
        $ext = array_pop($ext);

        //save image in file
        $img_name = "advert-".time().".".$ext;
        $path = public_path() . "/images/advertisement/" . $img_name;
        $img = substr($img, strpos($img, ",")+1);
        $data = base64_decode($img);
        $success = file_put_contents($path, $data);

        $error = '';
        $success ? $advertisement->image = $img_name : $error = 'Unable to save cover image';

        if($advertisement->update()){
            return redirect()->back();
        }
        else
        {
            return redirect()->back();
        }
        return view('admin.create_advertisement');
    }

    public function getDeleteAdvertisement($id)
    {
        $advertisement = Advertisement::find($id);
        if($advertisement){
            $advertisement->delete();
            return redirect()->back();
        }
        else
        {
            return redirect()->back();
        }
    }
}
