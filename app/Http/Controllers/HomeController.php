<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Post;
class HomeController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        if (Auth::user()->role == 'member') {
            // $most = DB::select(DB::raw('SELECT title FROM mostvisited WHERE updated_at >= NOW() - INTERVAL 1 day ORDER BY view DESC'));
            DB::table('mostvisited')
                ->where('updated_at','<','NOW() - INTERVAL 3 day')
                ->delete();
            // $most = DB::table('mostvisited')
            //     ->select('title', 'view')
            //     ->where('updated_at','>=','NOW() - INTERVAL 1 day')
            //     ->orderBy('view', 'desc')
            //     ->get();
            // return $most;
            $popPost = DB::table('mostvisited')
                ->join('users','mostvisited.user_id','=','users.id')
                ->join('comunities','mostvisited.comunity_id','=','comunities.id')
                ->select('mostvisited.id as post_id','mostvisited.content','mostvisited.title','mostvisited.vote','mostvisited.media','comunities.name','users.username','mostvisited.user_id','mostvisited.updated_at','mostvisited.view')
                ->where('mostvisited.updated_at','>=','NOW() - INTERVAL 3 day')
                ->orWhere('mostvisited.view','>',500)->orderBy('mostvisited.view','desc')
                ->distinct()->get();
            $newPost = DB::table('posts')
                ->join('users','posts.user_id','=','users.id')
                ->join('comunities','posts.comunity_id','=','comunities.id')
                ->select('posts.id as post_id','posts.content','posts.title','posts.vote','posts.media','comunities.name','users.username','posts.user_id','posts.updated_at')
                ->orderBy('posts.updated_at', 'desc')->distinct()->get();
            $user_id = Auth::id();
            $post = DB::table('users')->join('usercomunity', 'users.id', '=', 'usercomunity.user_id')
                ->join('comunities','usercomunity.comunity_id', '=', 'comunities.id')
                ->join('mostvisited','comunities.id', '=', 'mostvisited.comunity_id')
                ->select('mostvisited.id as post_id','mostvisited.content','mostvisited.title','mostvisited.vote','mostvisited.media','mostvisited.view','comunities.name','mostvisited.updated_at','mostvisited.user_id','mostvisited.updated_at')
                ->where('users.id', $user_id)
                ->where('mostvisited.updated_at','>=','NOW() - INTERVAL 3 day')
                ->orderBy('mostvisited.view', 'desc')->distinct()->get();
            if (!empty($request->q)) {
                $post = DB::table('users')->join('usercomunity', 'users.id', '=', 'usercomunity.user_id')
                    ->join('comunities','usercomunity.comunity_id', '=', 'comunities.id')
                    ->join('posts','comunities.id', '=', 'posts.comunity_id')
                    ->select('posts.id as post_id','posts.content','posts.title','posts.vote','posts.media','posts.view','comunities.name','posts.updated_at','posts.user_id','posts.updated_at')
                    ->where('title','LIKE',"%{$request->q}%")
                    ->orderBy('posts.updated_at', 'desc')->distinct()->get();
            }
            return view('home', compact('post','newPost'))->with(['popular'=>$popPost]);
        }else {
            return redirect()->route('admin.index');
        }
    }

    public function newPost(Request $request) {
        if (Auth::user()->role == 'member') {
            $popPost = DB::table('mostvisited')
                ->join('users','mostvisited.user_id','=','users.id')
                ->join('comunities','mostvisited.comunity_id','=','comunities.id')
                ->select('mostvisited.id as post_id','mostvisited.content','mostvisited.title','mostvisited.vote','mostvisited.media','comunities.name','users.username','mostvisited.user_id','mostvisited.updated_at','mostvisited.view')
                ->where('mostvisited.updated_at','>=','NOW() - INTERVAL 3 day')
                ->orWhere('mostvisited.view','>',500)->orderBy('mostvisited.view','desc')
                ->distinct()->get();
            $newPost = DB::table('posts')
                ->join('users','posts.user_id','=','users.id')
                ->join('comunities','posts.comunity_id','=','comunities.id')
                ->select('posts.id as post_id','posts.content','posts.title','posts.vote','posts.media','comunities.name','users.username','posts.user_id','posts.updated_at')
                ->orderBy('posts.updated_at', 'desc')->distinct()->get();
            $user_id = Auth::id();
            $post = DB::table('users')->join('usercomunity', 'users.id', '=', 'usercomunity.user_id')
                ->join('comunities','usercomunity.comunity_id', '=', 'comunities.id')
                ->join('posts','comunities.id', '=', 'posts.comunity_id')
                ->select('posts.id as post_id','posts.content','posts.title','posts.vote','posts.media','posts.view','comunities.name','posts.updated_at','posts.user_id','posts.updated_at')
                ->where('users.id', $user_id)->orderBy('posts.updated_at', 'desc')
                ->distinct()->get();
            if (!empty($request->q)) {
                $post = DB::table('users')->join('usercomunity', 'users.id', '=', 'usercomunity.user_id')
                    ->join('comunities','usercomunity.comunity_id', '=', 'comunities.id')
                    ->join('posts','comunities.id', '=', 'posts.comunity_id')
                    ->select('posts.id as post_id','posts.content','posts.title','posts.vote','posts.media','posts.view','comunities.name','posts.updated_at','posts.user_id','posts.updated_at')
                    ->where('title','LIKE',"%{$request->q}%")
                    ->orderBy('posts.updated_at', 'desc')->distinct()->get();
            }
            // return $post;
            return view('home', compact('post','newPost'))->with(['popular'=>$popPost]);
        } else {
            return redirect()->route('admin.index');
        }
    }

}










     

    // public function actOnPost(Request $request, $id)
    // {
    //     $action = $request->get('action');
    //     switch ($action) {
    //         case 'Like':
    //             Post::where('id', $id)->increment('vote');
    //             break;
    //         case 'Unlike':
    //             Post::where('id', $id)->decrement('vote');
    //             break;
    //     }
    //     event(new PostAction($id, $action));
    //     return '';
    // }

    // public function addVote($title, $vote){
    //     $newVote = $vote += 1;
    //     $update_post = Post::findOrFail($title);
    //     $update_post->vote = $newVote;
    //     $update_post->save();
    //     return redirect()->route('home')->with('status','User succesfully updated');
    // }

    // public function removeVote($title, $vote){
    //     $newVote = $vote -= 1;
    //     $update_post = Post::findOrFail($title);
    //     $update_post->vote = $newVote;
    //     $update_post->save();
    //     return redirect()->route('home')->with('status','User succesfully updated');
    // }

    // public function posts() {
    //     $posts = Post::get();
    //     return view('posts', compact('posts'));
    // }
// }