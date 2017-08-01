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
use Illuminate\Support\Facades\Session;

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
                    $query->where('active', 1);
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

    function get_ip() {
        //Just get the headers if we can or else use the SERVER global
        if ( function_exists( 'apache_request_headers' ) ) {
            $headers = apache_request_headers();
        } else {
            $headers = $_SERVER;
        }
        //Get the forwarded IP if it exists
        if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {
            $the_ip = $headers['X-Forwarded-For'];
        } elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )
        ) {
            $the_ip = $headers['HTTP_X_FORWARDED_FOR'];
        } else {

            $the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );
        }
        return $the_ip;
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

        if(Session::has('ip'))
        {
            if(Session::has('s_articles'))
            {
                $array = explode(',', Session::get('articles'));
                foreach ($array as $element)
                {
                    if($element == $article->id)
                    {
                        break;
                    }
                    else
                    {
                        $s_articles = Session::get('articles');
                        Session::put('articles', $s_articles.",".$article->id);

                        $article->view_count = $article->view_count + 1;
                        $article->update();
                    }
                }
            }
            else
            {
                Session::put('articles', $article->id);

                $article->view_count = $article->view_count + 1;
                $article->update();
            }
        }
        else
        {
            Session::put('ip', $this->get_ip());
            Session::put('articles', $article->id);

            $article->view_count = $article->view_count + 1;
            $article->update();
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
        $this->validate(
            $request, [
                'subscribe-email' => 'required'
            ]
        );

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

    public function getHeadlines()
    {
        if(Auth::guest())
        {
            $articles = Article::where('publish_date', '!=', null)->where('del', 0)->where('public_approve', '1')->where('headline', 1)->orderBy('publish_date', 'DESC')->paginate(12);
            $popular_articles = Article::where('publish_date', '!=', null)->where('del', 0)->where('public_approve', '1')->orderBy('view_count', 'DESC')->take(5)->get();
            $archive_by_date = Article::where('publish_date', '!=', null)->where('del', 0)->where('public_approve', '1')->orderBy('publish_date', 'DESC')->get()->groupBy(function($date) {
                return Carbon::parse($date->publish_date)->format('M Y');
            })->take(12);
        }
        else
        {
            $articles = Article::where('publish_date', '!=', null)->where('del', 0)->where('headline', 1)->orderBy('publish_date', 'DESC')->paginate(12);
            $popular_articles = Article::where('publish_date', '!=', null)->where('del', 0)->orderBy('view_count', 'DESC')->take(5)->get();
            $archive_by_date = Article::where('publish_date', '!=', null)->where('del', 0)->orderBy('publish_date', 'DESC')->get()->groupBy(function($date) {
                return Carbon::parse($date->publish_date)->format('M Y');
            })->take(12);
        }

        return view('category')->with(['title'=>'Headlines', 'articles' => $articles, 'popular_articles' => $popular_articles, 'archive_by_date'=>$archive_by_date]);
    }
}
