<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;
use Auth;

class PostController extends Controller
{
    //
    public function showAllPosts() {
    	// $varpost=Post::all();
    	$varpost=Post::where([['user_id','=',Auth::user()->id]])->get();

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

    	return redirect()->route('post.index')->withSuccess('Post Created');
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

	    	return redirect()->route('post.index')->withSuccess('Post Created');
    	}
    	else {
    		return redirect()->route('post.index')->withSuccess('Cannot update');
    	}
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
