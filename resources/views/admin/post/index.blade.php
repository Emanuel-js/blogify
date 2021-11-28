@extends('layouts.app')

@section('content')

<div class="container">

    <h1>Posts</h1>


<div class=" my-5 py-3">
    <h5>Search for Posts</h5>
     <form action="{{ route('posts.index') }}" method="GET" role="search">
                <div class="input-group">
                     <select class="form-control" name="q">
                         <option value="" >category</option>
                        @foreach($category as $cateogry)
                        <option value="{{$cateogry->id}}">{{$cateogry->name}}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                    <button class="btn btn-secondary" type="submit"">Search</button>
                    </div>
                </div>
    </form>

    </div>


        <div class="container row">

    @forelse ($data as $post)
    <div class="card col-sm mr-5" style="width: 18rem;">
        <a href="/posts/{{$post->id}}">
             <img class="card-img-top"style="width: 100%; height:18rem" src="/storage/cover_img/{{$post->cover_img}}" alt="Card image cap">
        </a>

            <div class="card-body">
          <h5 class="card-title">{{strtoupper($post->title)}}</h5>
          <small class="badge badge-primary">published at {{$post->created_at}}</small>
          <small class="badge badge-secondary">published by {{$post->user->name}}</small>


          <small class="badge badge-info" style="color:white">
            @for ($i = 0; $i < $category->count(); $i++)
                @if ($category[$i]->id == $post->category_id)
                {{$category[$i]->name}}
                @endif
            @endfor
           </small>
          <br/>
          <br/>
        </div>
      </div>


    @empty
    <div class="card card-body m-1">
        <h4>No Blog is here</h4>
    </div>
    @endforelse

</div>

</div>

@endsection
