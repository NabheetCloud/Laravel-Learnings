@extends('layouts.app')
@section('content')
<a href="/posts" class="btn btn-primary">Go Back</a>
<div class="well">
        <h3>{{$post->title}}</h3>
               
        </div>
        <div>
            {!!$post->body!!}
        </div>
        <hr>
        <small>Written on {{$post->created_at}}</small>
      @if(!Auth::guest())
      @if(Auth::user()->id == $post->user_id)
        <a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>
    {!!Form::open(['action' =>['PostsContoller@destroy', $post->id],"method"=>"POST","class"=>"pull-right"])!!}
        {{Form::hidden('_method','DELETE')}}
        {{Form::submit('Delete',["class"=>"btn btn-danger"])}}
    {!!Form::close()!!}
    @endif
    @endif
@endsection 