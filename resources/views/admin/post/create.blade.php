@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create a new post</h1>
    {!! Form::open(['route' => 'posts.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>
        <div class="form-group">
            {{ Form::select('category_id', $categories->pluck('name', 'id'), null, ['class' => 'form-control w-100','placeholder' => 'categorys...' ])}}
        </div>
        <div class="form-group">
            {{Form::label('body', 'Body')}}
            {{Form::textarea('body', '', ['id' => 'wysiwyg-editor', 'class' => 'form-control ckeditor ', 'placeholder' => 'Body Text'])}}
        </div>
        <div class="form-group">
            {{Form::file('cover_img')}}
        </div>
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}


</div>

@endsection
