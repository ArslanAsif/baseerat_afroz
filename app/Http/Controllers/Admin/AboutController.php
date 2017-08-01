<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Cache;

use App\About;
use App\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function getAboutUs()
    {
        $aboutus = About::where('type','aboutus')->first();
        return view('admin.edit_about',['aboutus'=>$aboutus,'check'=>'aboutus']);
    }

    public function postAboutUs(Request $request)
    {
        $aboutus = About::where('type', 'aboutus');
        if($aboutus->count() > 0)
        {
            $aboutus = $aboutus->first();
            $aboutus->descr_eng = $request['descr'];
            $aboutus->update();
        }
        else
        {
            $aboutus = new About();
            $aboutus->type = 'aboutus';
            $aboutus->descr_eng = $request['descr'];
            $aboutus->save();
        }

        return redirect()->back()->with('message', 'Successfully Submitted!');
    }

    public function getContactUs()
    {
        $contact = About::where('type', 'contact')->first();
        return view('admin.edit_about',['aboutus'=>$contact,'check'=>'contact']);
    }

    public function postContactUs(Request $request)
    {
        $contact = About::where('type', 'contact');
        if($contact->count() > 0)
        {
            $contact = $contact->first();
            $contact->descr_eng = $request['descr'];
            $contact->update();
        }
        else
        {
            $contact = new About();
            $contact->type = 'contact';
            $contact->descr_eng = $request['descr'];
            $contact->save();
        }

        return redirect()->back()->with('message', 'Successfully Submitted!');
    }

    public function getTerms()
    {

       $terms = About::where('type', 'terms')->first();
        return view('admin.edit_about',['aboutus'=>$terms,'check'=>'terms']);
    }

    public function postTerms(Request $request)
    {
        $terms = About::where('type', 'terms');
        if($terms->count() > 0)
        {
            $terms = $terms->first();
            $terms->descr_eng = $request['descr'];
            $terms->update();
        }
        else
        {
            $terms = new About();
            $terms->type = 'terms';
            $terms->descr_eng = $request['descr'];
            $terms->save();
        }

        return redirect()->back()->with('message', 'Successfully Submitted!');
    }
}
