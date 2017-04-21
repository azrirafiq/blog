<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;
use Auth;

class PostController extends Controller
{
    //
    public function showAllPosts(Request $request) {

        // dd($request->searchtext);
    	// $varpost=Post::all();

    	// $varpost=Post::where([['user_id','=',Auth::user()->id]]);
        $varpost= new Post;
        
        // $varpost = Post::where ('id','>','0');
// kalau ada search title, filter post by title
        if (!empty($request->searchtext)) {
            $varpost = $varpost->whereTitle($request->searchtext);
        }
        if (!empty($request->searchstory)) {
            $varpost = $varpost->where('story','LIKE',"%$request->searchstory%");
        }
        if (!empty($request->searchId)) {
            $varpost = $varpost->whereId($request->searchId);
        }


        $varpost = $varpost->paginate(10);

    	return view('posts')->with('postview',$varpost);
    	//return view('posts')->withPostview($varpost);
    }
    public function createPost() {
    	return view('postsform');
    }
    public function savePost(Request $request) {
    	$this->validate($request, [
    		'title' => 'required|max:60',
    		'story' => 'required|max:100',
    		]);
    	$varpost=new Post;
    	$varpost->user_id=Auth::user()->id;
    	$varpost->title=$request->input('title');
    	$varpost->story=$request->input('story');

    	$varpost->save();

    	return redirect()->route('post.index')->withSuccess('Post Succesfully Create');
    }
    public function editPost($id) {
    	$varpost=Post::where([
    		['id','=',$id],
    		['user_id','=',Auth::user()->id]
    		])->first();

    	return view('editform')->withId($id)->withPost($varpost);
    }
    public function updatePost(Request $request, $id) {
    	$this->validate($request, [
    		'title' => 'required|max:60',
    		'story' => 'required|max:100',
    		]);

    	$varpost=Post::where([
    		['id','=',$id],
    		['user_id','=',Auth::user()->id]
    		])->first();

    	if ($varpost) {
	    	$varpost->title=$request->input('title');
	    	$varpost->story=$request->input('story');
	    	$varpost->save();

	    	return redirect()->route('post.index')->withSuccess('Post Succesfully Update');
    	}
    	else {
    		return redirect()->route('post.index')->withSuccess('Cannot update');
    	}
    }

    public function searchPosts(Request $request) {
        $searchtext=$request->input('searchtext');
        $searchopt=$request->input('searchopt');

        if (!empty($searchtext)) {
            switch ($searchopt) {
                case 'id' :
                    $res=post::where([['id','=',$searchtext]])->get();
                    break;
                case 'title':
                    $searchtext='%'.$searchtext.'%';
                    $res=post::where([['title','like',$searchtext]])->get();
                    break;
                case 'story';
                    $searchtext='%'.$searchtext.'%';
                    $res=post::where([['story','like',$searchtext]])->get();
                    break;
                default:
                    $res=post::where([['id','=',$searchtext]])->get();
                    break;
            }
        }
        else {
            $res=Post::all();
        }
        return view('posts')->withPostview($res);
    }

    public function deletePost($id) {
    	$varpost=Post::find($id);
    	// $varpost=Post::where([['id', '=', $id],['user_id','=',Auth::user()->id]])->first();

    	if ($varpost) {
    		$varpost->delete();
    		return redirect()->route('post.index')->withSuccess('Post Succesfully Delete');
    	}
    	else {
    		return redirect()->route('post.index')->withSuccess('Cannot Delete');
    	}
    }
}
