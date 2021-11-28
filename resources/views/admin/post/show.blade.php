@extends('layouts.app')

@section('content')
<a href="/posts" class="btn btn-secondary btn-sm">◀️ Go Back</a>
<br/>
<br/>
<div class="jumbotron ">
    <img  class="card-img-top" src="/storage/cover_img/{{$data->cover_img}}" alt="Card image cap">
    <h3 class="display-4">{{strtoupper($data->title)}}</h3>
    <p class="lead">{!!$data->body!!}</p>
    <hr class="my-4">
    <p>published at {{$data->created_at}}</p>
    <small class="badge badge-primary">👁️‍🗨️ {{$data->views}}</small>
    <br/>
   @if (!Auth::guest())
        @if(Auth::user()->id == $data->user_id)
                <p class=" form-inline mb-2">
                    <a class=" btn btn-secondary btn-sm" href="/posts/{{$data->id}}/edit" role="button">Edit</a>
                    <form method="POST" action="{{route('posts.destroy', $data->id)}}">

                    <input type="hidden" name="_method" value="DELETE">
                    @csrf
                    <button type="submit" name="delete" class=" btn btn-danger btn-sm" >Delete</button>
                    </form>
                </p>
        @endif
   @endif
  </div>
@endsection
