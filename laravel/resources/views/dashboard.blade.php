@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        <div class="panel-body">
                           
                                <a href="/posts/create" class="btn btn-primary">Create Post</a>
                                <h3> Your Blog posts</h3>
                                @if(count($posts)>0)
                                <table class="table table-striped">
                                    <tr>
                                        <th>Title</th>
                                        <th>Body</th>
                                        <th></th>
                                    </tr>
                                    @foreach($posts as $post)
                                    <tr>
                                    <td>{{$post->title}} by {{$post->user->name}}</td>
                                    <td><a href="/posts/{{$post->id}}/edit" class="btn btn-default" >Edit</a></td>
                                    <td>
                                            {!!Form::open(['action' =>['PostsContoller@destroy', $post->id],"method"=>"POST","class"=>"pull-right"])!!}
                                            {{Form::hidden('_method','DELETE')}}
                                            {{Form::submit('Delete',["class"=>"btn btn-danger"])}}
                                        {!!Form::close()!!}

                                    </td>
                                        </tr>
                                    @endforeach
                                </table>   
                                @else
                                <p>You have no Posts</p>
                                @endif
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection