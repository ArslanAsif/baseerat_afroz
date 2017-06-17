<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Article;
use App\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $users_count = User::where('type', '!=', 'admin')->count();
        
        $users = User::where('type', '!=', 'admin')->get();
        $users_count_today = 0;
        foreach ($users as $user) {
            $created_at= Carbon::parse($user->created_at);
            $dt = Carbon::now();

            if($dt->diffInDays($created_at) == 0)
                $users_count_today++;
        }

        $submissions_count = Article::count();

        $submissions = Article::all();
        $submissions_count_today = 0;
        foreach ($submissions as $article) {
            $created_at= Carbon::parse($article->created_at);
            $dt = Carbon::now();

            if($dt->diffInDays($created_at) == 0)
                $submissions_count_today++;
        }

        return view('admin.dashboard')->with(['users_count'=>$users_count, 'users_count_today'=>$users_count_today, 'submissions_count'=>$submissions_count, 'submissions_count_today'=>$submissions_count_today]);
    }
}
