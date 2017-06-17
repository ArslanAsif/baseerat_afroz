<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Article;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ArticleController extends Controller
{
    public function index()
    {
        $news = Article::where('publish_date', '!=', null)->where('active', 1)->get();

        return view('admin.manage_article')->with('news', $news);
    }

    public function getUnpublished()
    {
        $news = Article::where('publish_date', null)->where('active', 1)->get();
        return view('admin.manage_article_submissions')->with(['news' => $news, 'type' => 'unpublished']);
    }

    public function getMySubmission()
    {
        $news = Article::where('user_id', Auth::user()->id)->get();
        return view('admin.my_submissions')->with('news', $news);
    }


    public function getUserSubmission()
    {
        $news = Article::where('active', 0)->get();
        return view('admin.manage_article_submissions')->with(['news'=>$news, 'type' => 'submission']);
    }

    public function postApproveNews($id)
    {
        $news = Article::where('id', $id)->first();
        $news->publish_date = Carbon::now();
        $news->active = 1;
        $news->update();

        return redirect()->back();
    }

    public function postPublishNews($id)
    {
        $news = Article::find($id);
        $news->publish_date = Carbon::now();
        $news->update();

        return redirect()->back();
    }

    public function postUnpublishNews($id)
    {
        $news = Article::find($id);
        $news->publish_date = null;
        $news->update();

        return redirect()->back();
    }

    public function getAddNews()
    {
        $categories = Category::where('active', 1)->orderBy('title_eng', 'asc')->get();
        return view('admin.create_article')->with('categories', $categories);
    }
    
    public function postAddNews(Request $request)
    {

        $this->validate(
            $request,
            [
                'title'=>'required',
                'category'=>'required',
                'summary'=>'required',
                'descr'=>'required',
                // 'image-data'=>'required_unless:category,Opinion',
            ], 
            [
                'category.required'=>'Category is required',
                'descr.required'=>'Description is required', 
                'image-data.required_unless'=>'Image is required for selected category'
            ]
        );

        //return $request->all();
        $news = new Article();
        $news->user_id = Auth::user()->id;
        $news->title = $request['title'];
        // $news->type = $request['type'];
        $news->category_id = $request['category'];
        
        $news->summary = $request['summary'];
        $news->description = $request['descr'];

        if(Auth::user()->type == 'admin')
        {
            $news->priority = $request['priority'];

            if(isset($request['homepage']) && isset($request['headline']) && isset($request['spotlight']))
            {
                $checking = Article::where('homepage', 1)->where('spotlight', 1)->where('headline', 1)->get();
                foreach($checking as $check)
                {
                    $check->spotlight = 0;
                    $check->update();
                }
            }

            if(isset($request['headline']))
            {
                $news->headline = 1;
            }
            else $news->headline = 0;

            if(isset($request['homepage']))
            {
                $news->homepage = 1;
            }
            else $news->homepage = 0;

            if(isset($request['spotlight']))
            {

                $news->spotlight = 1;
            }
            else $news->spotlight = 0;

            if(isset($request['featured']))
            {

                $news->featured = 1;
            }
            else $news->featured = 0;

            if(isset($request['public_appr']))
            {

                $news->public_appr = 1;
            }
            else $news->public_appr = 0;

            if(isset($request['community_appr']))
            {

                $news->community_appr = 1;
            }
            else $news->community_appr = 0;

            if(isset($request['publish']))
            {
                $news->publish_date = Carbon::now();
            }
            else $news->publish_date = null;
        }
        else
        {
            $news->active = 0;
            $news->duration = 0;
            $news->publish_date = null;
        }

        

        //decode the url, because we want to use decoded characters to use explode
        if(isset($request['image-data']))
        {
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
            $img_name = "perfil-".time().".".$ext;
            $path = public_path() . "/images/articles/" . $img_name;
            $img = substr($img, strpos($img, ",")+1);
            $data = base64_decode($img);
            $success = file_put_contents($path, $data);

            $error = '';
            $success ? $news->picture = $img_name : $error = 'Unable to save cover image';
        }

        $news->save();

        $tags = explode(',', $request['tags']);
        foreach($tags as $tag)
        {
            $tag_id = Tag::where('title', $tag)->first();
            if(!isset($tag_id->id))
            {
                $tag_id = new Tag();
                $tag_id->title = $tag;
                $tag_id->save();
            }
            $news->tags()->attach($tag_id);
        }

        return redirect()->back()->with(['message' => 'Successfully Submitted', 'error' => $error]);
    }

    public function getEditNews($id)
    {
        $news = Article::where('id', $id)->with('tags')->first();

        $categories = Category::where('active', 1)->orderBy('title_eng', 'asc')->get();

        $array = '';
        foreach($news->tags as $tag)
        {
            if($array != '')
            {
                $array = $array.", ".$tag->title;
            }
            else
            {
                $array = $array.$tag->title;
            }
        }

        return view('admin.create_article')->with(['news' => $news, 'categories' => $categories, 'tags' => $array]);
    }

    public function postEditNews($id, Request $request)
    {

        $this->validate(
            $request,
            [
                'title'=>'required',
                'category'=>'required',
                'summary'=>'required',
                'descr'=>'required',
                // 'image-data'=>'required_unless:category,Opinion',
            ], 
            [
                'category.required'=>'Category is required',
                'descr.required'=>'Description is required', 
                'image-data.required_unless'=>'Image is required for selected category'
            ]
        );
        
//        return $request->all();

        $news = Article::find($id);

        $news->user_id = $request->user()->id;
        $news->title = $request['title'];
        // $news->type = $request['type'];
        $news->category_id = $request['category'];
        
        $news->summary = $request['summary'];
        $news->description = $request['descr'];
        $news->priority = $request['priority'];

        if(isset($request['headline']))
        {
            $news->headline = 1;
        }
        else $news->headline = 0;

        if(isset($request['homepage']))
        {
            $news->homepage = 1;
        }
        else $news->homepage = 0;

        if(isset($request['spotlight']))
        {

            $news->spotlight = 1;
        }
        else $news->spotlight = 0;

        if(isset($request['featured']))
        {

            $news->featured = 1;
        }
        else $news->featured = 0;

        if(isset($request['public_appr']))
        {

            $news->public_appr = 1;
        }
        else $news->public_appr = 0;

        if(isset($request['community_appr']))
        {

            $news->community_appr = 1;
        }
        else $news->community_appr = 0;

        if(isset($request['publish']))
        {
            $news->publish_date = Carbon::now();
        }
        else $news->publish_date = null;

        if(isset($request['image-data']))
        {
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
            $img_name = "perfil-".time().".".$ext;
            $path = public_path() . "/images/articles/" . $img_name;
            $img = substr($img, strpos($img, ",")+1);
            $data = base64_decode($img);
            $success = file_put_contents($path, $data);

            $error = '';
            $success ? $news->picture = $img_name : $error = 'Unable to save cover image';
        }

        $news->update();

        $tags = explode(',', $request['tags']);
        $news->tags()->detach();

        foreach($tags as $tag)
        {
            $tag_id = Tag::where('title', $tag)->first();
            if(!isset($tag_id->id))
            {
                $tag_id = new Tag();
                $tag_id->title = $tag;
                $tag_id->save();
            }

            $news->tags()->attach($tag_id);
        }

        return redirect()->back()->with('message', 'Successfully Edited!');
    }

    public function getDeleteNews($id)
    {
        $news = Article::find($id);
        $news->delete();
        return back();
    }

    public function getTrash()
    {
        $articles = Article::where('active', 1)->get();

        return view('admin.manage_article_submissions')->with(['news'=>$articles, 'type' => 'trash']);
    }
}
