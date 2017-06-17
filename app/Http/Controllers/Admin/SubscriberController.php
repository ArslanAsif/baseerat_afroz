<?php

namespace App\Http\Controllers\Admin;

use App\Newsletter;
use App\Article;
use App\Mail\NewsletterMailer;
use App\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SubscriberController extends Controller
{
    public function index()
    {
        $subcribe=Subscriber::where ('confirmed','1')->get();
        return view('admin.subscribers',['subcribe'=>$subcribe]);
    }
    public function deleteSubscriber($id)
    {
        $subcribe = Subscriber::where('id', $id)->first();
        if($subcribe){
            $subcribe->delete();
            return redirect()->back();
        }
        else
        {
            return redirect()->back();
        }
    }

    public function getNewsletter()
    {
        return view('admin.newsletter');
    }

    public function getNewsletterToday()
    {
        $news = Article::all();
        $content = '<div style="text-align: center">
                        <img height=100px src="'.url('images/gccc.png').'">
                        <h1 style="margin-top: 15px; margin-bottom: 30px;">
                            <span style="padding: 10px 15px; border: 1px solid grey;">Latest in GCC Connect</span>
                        </h1>
                        <hr>';

        foreach ($news as $this_news) {
            
            if(Carbon::parse($this_news->publish_date)->diffInDays() == 0)
            {
                $content .= "<a href='".url('/article/'.$this_news->id)."'><h2>".$this_news->title."</h2><img src=".url('images/news/'.$this_news->picture)."></a><br><hr>";
            }
        }
        $content .= "<h2>For any questions or query - VISIT</h2>";
        $content .= "<a href='http://gccconnect.com/about' >http://gccconnect.com/about</a><br><br>";
        $content .= "<a href='http://fb.com/gccinfo/' ><img height=50px src='".url('images/fb-like.jpg')."'></a>";

        // $content .= "<p><br>To Stop receiving GCC Connect Updates - <a href='http://gccconnect.com/unsubscribe/''>Unsubscribe</a></p>";
        $content .= "</div>";

        return view('admin.newsletter')->with('content', $content);
    }

    public function getNewsletterFromArticle($id)
    {
        $news = Article::find($id);
        $content = "<h1>".$news->title."<h1>";

        if(isset($news->picture))
        {
            $content .= "<img src=".url('images/news/'.$news->picture)."><br>";
        }
        
        $content .= $news->description;
        return view('admin.newsletter')->with('content', $content);
    }

    public function postNewsletter(Request $request)
    {
        if(Newsletter::count())
        {
            $newsletter = Newsletter::first();
            $newsletter->content = $request['content'];
            $newsletter->update();

            $subscribers = Subscriber::where('confirmed', 1)->get();

            foreach ($subscribers as $subscriber) {
                Mail::to($subscriber->email)->send(new NewsletterMailer());
            }
            return redirect()->back();
        }
        else
        {
            $newsletter = new Newsletter();
            $newsletter->content = $request['content'];
            $newsletter->save();

            $subscribers = Subscriber::where('confirmed', 1)->get();

            foreach ($subscribers as $subscriber) {
                Mail::to($subscriber->email)->send(new NewsletterMailer());
            }
            return redirect()->back();
        }
        return redirect()->back();
    }

    // public function getSendNewsletter()
    // {
    //     $subscribers = Subscriber::where('confirmed', 1)->get();

    //     foreach ($subscribers as $subscriber) {
    //         Mail::to($subscriber->email)->send(new NewsletterMailer());
    //     }
    //     return redirect()->back();
        
    // }
}
