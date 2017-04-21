@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col- col-md-offset-1">
            @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session('success') }}
            </div>
            @endif
        </div>

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                <div class="row">
                    <div class="col-md-8"><h2>All posts</h2></div>
                    <div class="col-md-4">
                        <span class="pull-right">
                            <a href="{{ route('post.create') }}" class="btn btn-warning">Create Post</a>
                        </span>
                    </div>                    
                </div>                    
                </div>
                <div class="panel-body" style="background-color: #d9ffb3">
                <form action="/post/searchpost" method="GET">
<!--                 <form id="searchform" name="searchform" action="{{ route('post.search') }}" method="post" class="form-horizontal"> -->
                    {{ csrf_field() }}
                
                <div class="row">
                    <!-- <div class="col-md-6">
                        <input type="text" name="searchtext" class="form-control" placeholder="search">
                    </div>
                    <div class="col-md-4">
                        <select name="searchopt" class="form-control">
                            <option value="id">ID</option>
                            <option value="title">Title</option>
                            <option value="story">Story</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <span class="input-group-button">
                            <button class="btn btn-success" style="border-radius: 10px" type="submit">go!</button>
                        </span>
                    </div> -->

                    <div class="row">
                        <div class="col-sm-3">
                            <label>Title</label>
                            <input type="text" value="{{Request::get('searchtext')}}" name="searchtext" class="form-control" placeholder="search title . .">
                        </div>
                        <div class="col-sm-3">
                            <label>Story</label>
                            <input type="text" value="{{Request::get('searchstory')}}" name="searchstory" class="form-control" placeholder="search story . .">
                        </div>
                        <div class="col-sm-3">
                            <label>Id</label>
                            <input type="text" value="{{Request::get('searchId')}}"  name="searchId" class="form-control" placeholder="search id . .">
                        </div>
                        <span class="input-group-button col-sm-3">
                            <button class="btn btn-success" style="border-radius: 10px" type="submit">go!</button>
                        </span>

                    </div>

                </div>
                </form><!-- 
                <div class="row">
                    <label></label>
                    <div class="col-sm-3">
                        
                    </div>
                    <div class="col-sm-3">
                        
                    </div>
                    <div class="col-sm-3">
                        
                    </div>
                </div>
 -->                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Title</th>
                        <th>Story</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                    @foreach ($postview as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->user->name}}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->story }}</td>
                            <td>{{ $post->created_at }}</td>
                            <td>{{ $post->updated_at }}</td>
                            <td><div class="btn-group">
                                <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-default" style="background-color: yellow"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
                                <a href="{{ route('post.delete',$post->id) }}" class="btn btn-sm btn-default" style="background-color: red"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
                                
                            </div></td>
                        </tr>
                    @endforeach
                    </tbody>                    
                </table>
                <div>
                    {{ $postview->appends(Request::except('page'))->links()}}
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
