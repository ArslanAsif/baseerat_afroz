<?php

namespace App\Http\Controllers;

use App\About;
use App\Article;
use App\Category;
use App\Homepage;
use App\Subscriber;
use App\Tag;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $recent_articles = Article::where('publish_date', '!=', null)->orderBy('publish_date', 'DESC')->take(3)->get();
        $popular_articles = Article::where('publish_date', '!=', null)->orderBy('view_count', 'DESC')->take(5)->get();

        $spotlights = Homepage::where('type', 'spotlight')->orderBy('priority', 'ASC')->get();
        $highlights = Homepage::where('type', 'highlight')->orderBy('priority', 'ASC')->get();
        $editorpicks = Homepage::where('type', 'editorpick')->orderBy('priority', 'ASC')->get();

        $hp_categories = Homepage::where('type', 'category')->orderBy('priority', 'ASC')->get();

        $archive_by_date = Article::where('publish_date', '!=', null)->orderBy('publish_date', 'DESC')->get()->groupBy(function($date) {
            return Carbon::parse($date->publish_date)->format('M Y');
        })->take(12);

        return view('welcome')->with(['recent_articles' => $recent_articles, 'popular_articles' => $popular_articles, 'spotlights'=>$spotlights, 'highlights'=>$highlights, 'editorpicks'=>$editorpicks, 'hp_categories'=>$hp_categories, 'archive_by_date'=>$archive_by_date]);
    }

    public function getCategory($category)
    {
        $this_category = Category::where('id', $category)->first();

        $articles = Article::where('publish_date', '!=', null)->where('category_id', $category)->orderBy('publish_date', 'DESC')->paginate(12);

        $popular_articles = Article::where('publish_date', '!=', null)->where('category_id', $category)->orderBy('view_count', 'DESC')->take(5)->get();

        $archive_by_date = Article::where('publish_date', '!=', null)->orderBy('publish_date', 'DESC')->get()->groupBy(function($date) {
            return Carbon::parse($date->publish_date)->format('M Y');
        })->take(12);

        return view('category')->with(['category'=>$this_category , 'articles' => $articles, 'popular_articles' => $popular_articles, 'archive_by_date'=>$archive_by_date]);
    }

    public function getArticle($article)
    {
        $article = Article::where('id', $article)->first();

        $recent_articles = Article::where('publish_date', '!=', null)->where('category_id', $article->category->id)->orderBy('publish_date', 'DESC')->take(10)->get();
        $popular_articles = Article::where('publish_date', '!=', null)->where('category_id', $article->category->id)->orderBy('view_count', 'DESC')->take(10)->get();

        return view('article')->with(['this_article' => $article, 'recent_articles' => $recent_articles, 'popular_articles' => $popular_articles]);
    }

    public function postSearch(Request $request)
    {
        $articles = Article::where('publish_date', '!=', null)->Where('title', 'like', '%' . $request['search'] . '%')->orderBy('publish_date', 'DESC')->paginate(12);

        return view('category')->with(['search'=>$request['search'] , 'articles' => $articles]);
    }

    public function getArchive($date)
    {
        $new_date = Carbon::parse($date)->format('Y-m');

        $articles = Article::where('publish_date', '!=', null)->where('publish_date', 'like', $new_date.'%')->orderBy('publish_date', 'DESC')->paginate(12);

        $popular_articles = Article::where('publish_date', '!=', null)->orderBy('view_count', 'DESC')->take(5)->get();

        $archive_by_date = Article::where('publish_date', '!=', null)->orderBy('publish_date', 'DESC')->get()->groupBy(function($date) {
            return Carbon::parse($date->publish_date)->format('M Y');
        })->take(12);

        return view('category')->with(['title'=>'Archive of "'.$date.'"', 'articles' => $articles, 'popular_articles' => $popular_articles, 'archive_by_date'=>$archive_by_date]);
    }

    public function getUserArticle($user)
    {
        $this_user = User::where('id', $user)->first();

        $articles = Article::where('publish_date', '!=', null)->where('user_id', $user)->orderBy('publish_date', 'DESC')->paginate(12);

        $popular_articles = Article::where('publish_date', '!=', null)->where('user_id', $user)->orderBy('view_count', 'DESC')->take(5)->get();

        $archive_by_date = Article::where('publish_date', '!=', null)->orderBy('publish_date', 'DESC')->get()->groupBy(function($date) {
            return Carbon::parse($date->publish_date)->format('M Y');
        })->take(12);

        return view('category')->with(['title'=>'Articles by "'.$this_user->name.'"' , 'articles' => $articles, 'popular_articles' => $popular_articles, 'archive_by_date'=>$archive_by_date]);
    }

    public function getAbout()
    {
        $about = About::where('type', 'aboutus')->first();
        $contact = About::where('type', 'contact')->first();
        return view('about')->with(['about'=>$about, 'contact'=>$contact]);
    }

    public function getAddSubscriber($email, $token)
    {
        $subscriber = Subscriber::where('email', $email)->where('token', $token);
        $subscriber_count =  $subscriber->count();
        $subscriber = $subscriber->first();
        if($subscriber_count)
        {
            $subscriber->confirmed = 1;
            $subscriber->update();

            return view('confirmation')->with('message', 'Successfully Subscribed to GCC Connect Newsletter!');
        }
        return view('confirmation')->with('message', 'Not subscribed, try again!');
    }

    public function postAddSubscriber(Request $request)
    {
        if(Subscriber::where('email', $request['email'])->count())
        {
            return redirect()->back()->with('message', 'Already Subscribed');
        }

        $token = str_random(50);
        $subscriber = new Subscriber();
        $subscriber->email = $request['email'];
        $subscriber->token = $token;

        Mail::to($request['email'])->send(new SubscribeMailer($request['email'], $token));
        $subscriber->save();

        return redirect()->back()->with('message', 'Successfully Added! Please check your email to confirm');
    }
}
