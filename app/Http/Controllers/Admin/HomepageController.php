<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Category;
use App\Homepage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomepageController extends Controller
{
    public function index()
    {
        $articles = Article::where('publish_date', '!=', null)->get();
        $categories = Category::where('active', 1)->get();
        $spotlights = Homepage::where('type', 'spotlight')->orderBy('priority', 'ASC')->get();
        $highlights = Homepage::where('type', 'highlight')->orderBy('priority', 'ASC')->get();
        $editorpicks = Homepage::where('type', 'editorpick')->orderBy('priority', 'ASC')->get();
        $hp_categories = Homepage::where('type', 'category')->orderBy('priority', 'ASC')->get();

        return view('admin.manage_homepage')
            ->with(['articles' => $articles, 'categories' => $categories, 'spotlights'=>$spotlights, 'highlights'=>$highlights, 'editorpicks'=>$editorpicks, 'hp_categories'=>$hp_categories]);
    }

    public function postEditSpotlight(Request $request)
    {
        $limit = 0;
        $spotlight_count = Homepage::where('type', 'spotlight')->count();
        if($spotlight_count == 3)
        {
            $spotlights = Homepage::where('type', 'spotlight')->orderBy('priority', 'ASC')->get();
            $i = 1;
            foreach($spotlights as $spotlight)
            {
                $spotlight->type = 'spotlight';
                $spotlight->selected_by = Auth::user()->id;
                $spotlight->article_id = $request['spotlight'.$i];
                $spotlight->priority = $i++;

                $spotlight->save();
            }
        }
        else if($spotlight_count < 3)
        {
            if($spotlight_count == 0)
                $limit = 3;
            else if($spotlight_count == 1)
                $limit = 2;
            else if($spotlight_count == 2)
                $limit = 1;

            for($i = $spotlight_count+1; $i <= ($spotlight_count+$limit); $i++)
            {
                $spotlight = new Homepage();
                $spotlight->type = 'spotlight';
                $spotlight->selected_by = Auth::user()->id;
                $spotlight->article_id = $request['spotlight'.$i];
                $spotlight->priority = $i;

                $spotlight->save();
            }
        }
        return back()->with(['message'=>'Successfully submitted!']);
    }

    public function postEditHighlight(Request $request)
    {
        $limit = 0;
        $highlight_count = Homepage::where('type', 'highlight')->count();
        if($highlight_count == 4)
        {
            $highlights = Homepage::where('type', 'highlight')->orderBy('priority', 'ASC')->get();
            $i = 1;
            foreach($highlights as $highlight)
            {
                $highlight->type = 'highlight';
                $highlight->selected_by = Auth::user()->id;
                $highlight->article_id = $request['highlight'.$i];
                $highlight->priority = $i++;

                $highlight->save();
            }
        }
        else if($highlight_count < 4)
        {
            if($highlight_count == 0)
                $limit = 4;
            else if($highlight_count == 1)
                $limit = 3;
            else if($highlight_count == 2)
                $limit = 2;
            else if($highlight_count == 3)
                $limit = 1;

            for($i = $highlight_count+1; $i <= ($highlight_count+$limit); $i++)
            {
                $highlight = new Homepage();
                $highlight->type = 'highlight';
                $highlight->selected_by = Auth::user()->id;
                $highlight->article_id = $request['highlight'.$i];
                $highlight->priority = $i;

                $highlight->save();
            }
        }
        return back()->with(['message'=>'Successfully submitted!']);
    }

    public function postEditeditorpick(Request $request)
    {
        $limit = 0;
        $editorpick_count = Homepage::where('type', 'editorpick')->count();
        if($editorpick_count == 3)
        {
            $editorpicks = Homepage::where('type', 'editorpick')->orderBy('priority', 'ASC')->get();
            $i = 1;
            foreach($editorpicks as $editorpick)
            {
                $editorpick->type = 'editorpick';
                $editorpick->selected_by = Auth::user()->id;
                $editorpick->article_id = $request['editorpick'.$i];
                $editorpick->priority = $i++;

                $editorpick->save();
            }
        }
        else if($editorpick_count < 3)
        {
            if($editorpick_count == 0)
                $limit = 3;
            else if($editorpick_count == 1)
                $limit = 2;
            else if($editorpick_count == 2)
                $limit = 1;

            for($i = $editorpick_count+1; $i <= ($editorpick_count+$limit); $i++)
            {
                $editorpick = new Homepage();
                $editorpick->type = 'editorpick';
                $editorpick->selected_by = Auth::user()->id;
                $editorpick->article_id = $request['editorpick'.$i];
                $editorpick->priority = $i;

                $editorpick->save();
            }
        }
        return back()->with(['message'=>'Successfully submitted!']);
    }

    public function postEditCategory(Request $request)
    {
        $limit = 0;
        $category_count = Homepage::where('type', 'category')->count();
        if($category_count == 4)
        {
            $categories = Homepage::where('type', 'category')->orderBy('priority', 'ASC')->get();
            $i = 1;
            foreach($categories as $category)
            {
                $category->type = 'category';
                $category->selected_by = Auth::user()->id;
                $category->category_id = $request['category'.$i];
                $category->priority = $i++;

                $category->save();
            }
        }
        else if($category_count < 4)
        {
            if($category_count == 0)
                $limit = 4;
            else if($category_count == 1)
                $limit = 3;
            else if($category_count == 2)
                $limit = 2;
            else if($category_count == 3)
                $limit = 1;

            for($i = $category_count+1; $i <= ($category_count+$limit); $i++)
            {
                $category = new Homepage();
                $category->type = 'category';
                $category->selected_by = Auth::user()->id;
                $category->category_id = $request['category'.$i];
                $category->priority = $i;

                $category->save();
            }
        }
        return back()->with(['message'=>'Successfully submitted!']);
    }
}
