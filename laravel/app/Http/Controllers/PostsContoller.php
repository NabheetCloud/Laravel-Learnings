<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use DB;
use App\User;
class PostsContoller extends Controller
{
    
    
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //test1211
        //$posts = DB::select('select * from posts');
        //$posts = Post::all();
        // return  Post::where('title','Post Two')->get();
        //$posts = Post::orderBy('title','desc')->take(1)->get();
        //$posts = Post::orderBy('title','desc')->get();
        $posts = Post::orderBy('created_at','desc')->paginate(10);
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,['title'=>'required','body'=>'required',
        "cover_image"=>'image|nullable|max:1999'
        ]);
         // file upload

         if ($request->hasFile('cover_image')){
             //get file name with ext
             $fileNameWithExt = $request->file('cover_image')->getClientOriginalImage();

             // gert just file name

            $fileName = pathinfo($fileNameWithExt,PATHINFO_FILENAME);
             //get just extension
            $extension = $request->file('cover_image')->getOriginalClientExtension();
            
            //file name to store
            $fileNameToStore
        
        }else{

            $fileNameToStore = 'noimage.jpg';
         }
        //create post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->save();
        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        //check for correct user
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error','Unauthorize page');
        }
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
              //
              $this->validate($request,['title'=>'required','body'=>'required'
              ]);
          
              //create post
              $post = Post::find($id);
              $post->title = $request->input('title');
              $post->body = $request->input('body');
              $post->save();
              return redirect('/posts')->with('success', 'Post updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        //check for correct user
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error','Unauthorize page');
        }
        $post->delete();
        return redirect('/posts')->with('success', 'Post Deleted');
    }
}
