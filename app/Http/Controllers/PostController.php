<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Models\Category;
class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if(!\Auth::user()->hasRole('admin') && !\Auth::user()->hasRole('manager') && !\Auth::user()->hasRole('content-editor') ){
            $posts = Post::where('user_id', \Auth::user()->id)->orderBy('id', 'desc')
            ->get();
            $category = Category::all();
            if($request->has('q')){
                $q=$request->q;
                $posts=Post::where('category_id','like','%'.$q.'%')->orderBy('created_at')->get();
            }else{
                $posts = Post::orderBy('created_at')->get();
            }
        }else{
            $category = Category::all();
            if($request->has('q')){
                $q=$request->q;
                $posts=Post::where('category_id','like','%'.$q.'%')->orderBy('created_at')->get();
            }else{
                $posts = Post::orderBy('created_at')->get();
            }
        }



        return view('admin.post.index')->with([
            'data' => $posts,
            'category' => $category
        ]);

        // $data = Post::orderBy('created_at','desc')->paginate(10);
        // // $category =Category::where('id',$data->category_id);
        //   $category='kd';
        // return view('posts.index')->with(compact('data','category'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Post::class);
        $categories =Category::all();
        $posts = Post::all();
       return view('admin.post.create')->with(compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $this->validate($request,[
           'title'=>'required',
           'body'=>'required',
           'cover_image' => 'image|nullable|max:1999',
           'category_id' => 'required|integer',
           'views'=>'integer|nullable'
       ]);


        // Handle File Upload
        if($request->hasFile('cover_img')){
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_img')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_img')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('cover_img')->storeAs('public/cover_img', $fileNameToStore);

        } else {
            $fileNameToStore = 'noimage.png';
        }

        // Create Post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->category_id = $request->input('category_id');
        $post->cover_img = $fileNameToStore;
        $post->views=0;
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
        $post->increment('views');
        return view('admin.post.show')->with('data', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('edit', $post);
        $post = Post::find($post->id);

        //Check if post exists before deleting
        if (!isset($post)){
            return redirect('/posts')->with('error', 'No Post Found');
        }

        // Check for correct user
        if(auth()->user()->id !==$post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }

        $categories = Category::all();
        return view('admin.post.edit')->with(['data'=> $post,'categories'=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required|integer'
        ]);
		$post = Post::find($post->id);
         // Handle File Upload
        if($request->hasFile('cover_img')){
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_img')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_img')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('cover_img')->storeAs('public/cover_img', $fileNameToStore);
            // Delete file if exists
            Storage::delete('public/cover_img/'.$post->cover_img);

	//    //Make thumbnails
	//     $thumbStore = 'thumb.'.$filename.'_'.time().'.'.$extension;
    //         $thumb = Image::make($request->file('cover_image')->getRealPath());
    //         $thumb->resize(80, 80);
    //         $thumb->save('storage/cover_images/'.$thumbStore);

        }

        // Update Post
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->category_id =$request->input('category_id');
        if($request->hasFile('cover_img')){
            $post->cover_img = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');

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
        // $this->authorize('delete', $post);
        //Check if post exists before deleting
        if (!isset($post)){
            return redirect('/posts')->with('error', 'No Post Found');
        }

        // Check for correct user
        if(auth()->user()->id !==$post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }

        if($post->cover_img != 'noimage.png'){
            // Delete Image
            Storage::delete('public/cover_img/'.$post->cover_img);
        }

        $post->delete();
        return redirect('/posts')->with('success', 'Post Removed');
    }
}
