<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Article;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user=User::where('id', '!=', Auth::user()->id)->get();
        return view('admin.manage_users',['user'=>$user]);
    }

    public function getEditUser($id)
    {
        $user = User::find($id);

        return view('admin.user', ['user'=>$user]);
    }

    public function postEditUser($id, Request $request)
    {
        $user = User::find($id);
        
        $user->type = $request['type'];
        $user->editor_descr = $request['editor_descr'];
        $user->update();

        return back()->with('message', 'Successfully submitted!');
    }

    public function getBanUser($id)
    {
        $ban = 0;
        $user = User::where('id', $id)->first();
        if($user->ban == 1)
            $ban = 0;
        else
            $ban = 1;

        $user->ban = $ban;
        $user->update();

        return redirect()->back()->with('message', '');
    }

    public function getSettings()
    {
        $user = Auth::user();
        return view('admin.settings')->with('user', $user);
    }

    public function postChangePassword(Request $request)
    {
        $this->validate($request, [
            'curr-pass' => 'required',
            'new-pass' => 'required|min:6|confirmed',
        ]);

        $id = Auth::User()->id;

        $user = User::find($id);

        if(Hash::check($request['curr-pass'], $user->password))
        {
            $user->password = bcrypt($request['new-pass']);
            $user->save();

            return redirect()->back()->with('message', 'Password successfully changed!');
        }
        else
        {
            return redirect()->back()->with('error', 'Current password is incorrect!');
        }
    }

    public function postEditAboutMe(Request $request)
    {
        $user = Auth::user();

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
            $path = public_path() . "/images/users/" . $img_name;
            $img = substr($img, strpos($img, ",")+1);
            $data = base64_decode($img);
            $success = file_put_contents($path, $data);

            $error = '';
            $success ? $user->avatar = $img_name : $error = 'Unable to save image';
        }

        $user->user_descr = $request['user_descr'];
        $user->update();

        return back()->with('message', 'Successfully submitted!');
    }

    function getActiveUsers()
    {
        $fromDate = Carbon::parse('6/12/1990');
        $toDate = Carbon::parse('4/31/2017');

        $posts = Article::select('user_id', DB::raw('count(*) as total'))->whereBetween('created_at', [$fromDate, $toDate])->groupBy('user_id')->get();

        return $posts;

        return view('admin.manage_users',['user'=>$user]);
    }

    function getInactiveUsers()
    {
        $fromDate = date('Y-m-d' . ' 00:00:00', time()); 
        $toDate = date('Y-m-d' . ' 22:00:40', time());

        $posts=Article::select('user_id')->whereBetween('created_at', [$fromDate, $toDate])->groupBy('user_id')->get();

        return $posts;

        return view('admin.manage_users',['user'=>$user]);
    }
}
