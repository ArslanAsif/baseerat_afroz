<?php

namespace App\Http\Controllers;

use App\About;
use App\Article;
use App\Category;
use App\Homepage;
use App\Mail\SubscribeMailer;
use App\Subscriber;
use App\Tag;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

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
        if(Auth::guest())
        {
            $headlines = Article::where('publish_date', '!=', null)->where('del', 0)->where('public_approve', '1')->where('headline', 1)->orderBy('publish_date', 'DESC')->get();
            $recent_articles = Article::where('publish_date', '!=', null)->where('del', 0)->where('public_approve', '1')->orderBy('publish_date', 'DESC')->take(3)->get();
            $popular_articles = Article::where('publish_date', '!=', null)->where('del', 0)->where('public_approve', '1')->orderBy('view_count', 'DESC')->take(5)->get();

            $archive_by_date = Article::where('publish_date', '!=', null)->where('del', 0)->where('public_approve', '1')->orderBy('publish_date', 'DESC')->get()->groupBy(function($date) {
                return Carbon::parse($date->publish_date)->format('M Y');
            })->take(12);

            $spotlights = Homepage::join('articles', 'homepages.article_id', '=', 'articles.id')->where('articles.publish_date', '!=', null)->where('articles.del', 0)->where('articles.public_approve', 1)->where('homepages.type', 'spotlight')->orderBy('homepages.priority', 'ASC')->get();
            $highlights = Homepage::join('articles', 'homepages.article_id', '=', 'articles.id')->where('articles.publish_date', '!=', null)->where('articles.del', 0)->where('articles.public_approve', 1)->where('homepages.type', 'highlight')->orderBy('homepages.priority', 'ASC')->get();
            $editorpicks = Homepage::join('articles', 'homepages.article_id', '=', 'articles.id')->where('articles.publish_date', '!=', null)->where('articles.del', 0)->where('articles.public_approve', 1)->where('homepages.type', 'editorpick')->orderBy('homepages.priority', 'ASC')->get();
            //$hp_categories = Homepage::where('type', 'category')->orderBy('priority', 'ASC')->get();

            $hp_categories = Homepage::where('type', 'category')->orderBy('priority', 'ASC')->with([
                'category' =>function ($query) {
                    $query->where('category.active', 1);
                },
                'category.articles' => function ($query) {
                    $query->where('articles.publish_date', '!=', null)->where('articles.del', 0)->where('articles.public_approve', 1);
                }
            ])->get();
        }
        else
        {
            $headlines = Article::where('publish_date', '!=', null)->where('del', 0)->where('headline', 1)->orderBy('publish_date', 'DESC')->get();
            $recent_articles = Article::where('publish_date', '!=', null)->where('del', 0)->orderBy('publish_date', 'DESC')->take(3)->get();
            $popular_articles = Article::where('publish_date', '!=', null)->where('del', 0)->orderBy('view_count', 'DESC')->take(5)->get();

            $archive_by_date = Article::where('publish_date', '!=', null)->where('del', 0)->orderBy('publish_date', 'DESC')->get()->groupBy(function($date) {
                return Carbon::parse($date->publish_date)->format('M Y');
            })->take(12);

            $spotlights = Homepage::join('articles', 'homepages.article_id', '=', 'articles.id')->where('articles.publish_date', '!=', null)->where('articles.del', 0)->where('homepages.type', 'spotlight')->orderBy('homepages.priority', 'ASC')->get();
            $highlights = Homepage::join('articles', 'homepages.article_id', '=', 'articles.id')->where('articles.publish_date', '!=', null)->where('articles.del', 0)->where('homepages.type', 'highlight')->orderBy('homepages.priority', 'ASC')->get();
            $editorpicks = Homepage::join('articles', 'homepages.article_id', '=', 'articles.id')->where('articles.publish_date', '!=', null)->where('articles.del', 0)->where('homepages.type', 'editorpick')->orderBy('homepages.priority', 'ASC')->get();

            $hp_categories = Homepage::where('type', 'category')->orderBy('priority', 'ASC')->with([
                'category' ,
                'category.articles' => function ($query) {
                    $query->where('articles.publish_date', '!=', null)->where('articles.del', 0);
                }
            ])->get();
        }

        return view('welcome')->with(['headlines'=>$headlines,  'recent_articles' => $recent_articles, 'popular_articles' => $popular_articles, 'spotlights'=>$spotlights, 'highlights'=>$highlights, 'editorpicks'=>$editorpicks, 'hp_categories'=>$hp_categories, 'archive_by_date'=>$archive_by_date]);
    }

    public function getCategory($category)
    {
        $this_category = Category::where('id', $category)->first();

        if(Auth::guest())
        {
            $articles = Article::where('publish_date', '!=', null)->where('del', 0)->where('public_approve', '1')->where('category_id', $category)->orderBy('publish_date', 'DESC')->paginate(12);
            $popular_articles = Article::where('publish_date', '!=', null)->where('del', 0)->where('public_approve', '1')->where('category_id', $category)->orderBy('view_count', 'DESC')->take(5)->get();
            $archive_by_date = Article::where('publish_date', '!=', null)->where('del', 0)->where('public_approve', '1')->orderBy('publish_date', 'DESC')->get()->groupBy(function($date) {
                return Carbon::parse($date->publish_date)->format('M Y');
            })->take(12);
        }
        else
        {
            $articles = Article::where('publish_date', '!=', null)->where('del', 0)->where('category_id', $category)->orderBy('publish_date', 'DESC')->paginate(12);
            $popular_articles = Article::where('publish_date', '!=', null)->where('del', 0)->where('category_id', $category)->orderBy('view_count', 'DESC')->take(5)->get();
            $archive_by_date = Article::where('publish_date', '!=', null)->where('del', 0)->orderBy('publish_date', 'DESC')->get()->groupBy(function($date) {
                return Carbon::parse($date->publish_date)->format('M Y');
            })->take(12);
        }


        return view('category')->with(['category'=>$this_category , 'articles' => $articles, 'popular_articles' => $popular_articles, 'archive_by_date'=>$archive_by_date]);
    }

    public function getArticle($article)
    {
        if(Auth::guest())
        {
            $article = Article::where('id', $article)->where('del', 0)->where('public_approve', '1')->first();
            $recent_articles = Article::where('publish_date', '!=', null)->where('del', 0)->where('public_approve', '1')->where('category_id', $article->category->id)->orderBy('publish_date', 'DESC')->take(10)->get();
            $popular_articles = Article::where('publish_date', '!=', null)->where('del', 0)->where('public_approve', '1')->where('category_id', $article->category->id)->orderBy('view_count', 'DESC')->take(10)->get();

        }
        else
        {
            $article = Article::where('id', $article)->where('del', 0)->first();
            $recent_articles = Article::where('publish_date', '!=', null)->where('del', 0)->where('category_id', $article->category->id)->orderBy('publish_date', 'DESC')->take(10)->get();
            $popular_articles = Article::where('publish_date', '!=', null)->where('del', 0)->where('category_id', $article->category->id)->orderBy('view_count', 'DESC')->take(10)->get();
        }

        return view('article')->with(['this_article' => $article, 'recent_articles' => $recent_articles, 'popular_articles' => $popular_articles]);
    }

    public function postSearch(Request $request)
    {
        if(Auth::guest())
        {
            $articles = Article::where('publish_date', '!=', null)->where('del', 0)->where('public_approve', '1')->Where('title', 'like', '%' . $request['search'] . '%')->orderBy('publish_date', 'DESC')->paginate(12);
        }
        else
        {
            $articles = Article::where('publish_date', '!=', null)->where('del', 0)->Where('title', 'like', '%' . $request['search'] . '%')->orderBy('publish_date', 'DESC')->paginate(12);
        }

        return view('category')->with(['search'=>$request['search'] , 'articles' => $articles]);
    }

    public function getArchive($date)
    {
        $new_date = Carbon::parse($date)->format('Y-m');

        if(Auth::guest())
        {
            $articles = Article::where('publish_date', '!=', null)->where('del', 0)->where('public_approve', '1')->where('publish_date', 'like', $new_date.'%')->orderBy('publish_date', 'DESC')->paginate(12);
            $popular_articles = Article::where('publish_date', '!=', null)->where('del', 0)->where('public_approve', '1')->orderBy('view_count', 'DESC')->take(5)->get();
            $archive_by_date = Article::where('publish_date', '!=', null)->where('del', 0)->where('public_approve', '1')->orderBy('publish_date', 'DESC')->get()->groupBy(function($date) {
                return Carbon::parse($date->publish_date)->format('M Y');
            })->take(12);
        }
        else
        {
            $articles = Article::where('publish_date', '!=', null)->where('del', 0)->where('publish_date', 'like', $new_date.'%')->orderBy('publish_date', 'DESC')->paginate(12);
            $popular_articles = Article::where('publish_date', '!=', null)->where('del', 0)->orderBy('view_count', 'DESC')->take(5)->get();
            $archive_by_date = Article::where('publish_date', '!=', null)->where('del', 0)->orderBy('publish_date', 'DESC')->get()->groupBy(function($date) {
                return Carbon::parse($date->publish_date)->format('M Y');
            })->take(12);
        }

        return view('category')->with(['title'=>'Archive of "'.$date.'"', 'articles' => $articles, 'popular_articles' => $popular_articles, 'archive_by_date'=>$archive_by_date]);
    }

    public function getUserArticle($user)
    {
        $this_user = User::where('id', $user)->first();

        if(Auth::guest())
        {
            $articles = Article::where('publish_date', '!=', null)->where('del', 0)->where('public_approve', '1')->where('user_id', $user)->orderBy('publish_date', 'DESC')->paginate(12);
            $popular_articles = Article::where('publish_date', '!=', null)->where('del', 0)->where('public_approve', '1')->where('user_id', $user)->orderBy('view_count', 'DESC')->take(5)->get();
            $archive_by_date = Article::where('publish_date', '!=', null)->where('del', 0)->where('public_approve', '1')->orderBy('publish_date', 'DESC')->get()->groupBy(function($date) {
                return Carbon::parse($date->publish_date)->format('M Y');
            })->take(12);
        }
        else
        {
            $articles = Article::where('publish_date', '!=', null)->where('del', 0)->where('user_id', $user)->orderBy('publish_date', 'DESC')->paginate(12);
            $popular_articles = Article::where('publish_date', '!=', null)->where('del', 0)->where('user_id', $user)->orderBy('view_count', 'DESC')->take(5)->get();
            $archive_by_date = Article::where('publish_date', '!=', null)->where('del', 0)->orderBy('publish_date', 'DESC')->get()->groupBy(function($date) {
                return Carbon::parse($date->publish_date)->format('M Y');
            })->take(12);
        }

        return view('category')->with(['user'=>$this_user, 'articles' => $articles, 'popular_articles' => $popular_articles, 'archive_by_date'=>$archive_by_date]);
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

            return redirect('/')->with('message', 'Successfully Subscribed to GCC Connect Newsletter!');
        }
        return redirect('/')->with('message', 'Not subscribed, try again!');
    }

    public function postAddSubscriber(Request $request)
    {
        if(Subscriber::where('email', $request['subscribe-email'])->count())
        {
            return redirect()->back()->with('message', 'Already Subscribed');
        }

        $token = str_random(50);
        $subscriber = new Subscriber();
        $subscriber->email = $request['subscribe-email'];
        $subscriber->token = $token;

        Mail::to($request['subscribe-email'])->send(new SubscribeMailer($request['subscribe-email'], $token));
        $subscriber->save();

        return redirect()->back()->with('message', 'Successfully Added! Please check your email to confirm');
    }

    public function postUnsubscribe(Request $request)
    {

    }
}
