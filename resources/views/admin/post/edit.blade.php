@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Blog</h1>

         {!! Form::open(['route' => ['posts.update', $data->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                {{Form::label('title', 'Title')}}
                {{Form::text('title', $data->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
            </div>
             <div class="form-group">
                {{ Form::select('category_id', $categories->pluck('name', 'id'),$data->category_id , ['class' => 'form-control w-100','placeholder' => 'category...' ])}}
            </div>
           <div class="form-group">
                {{Form::label('body', 'Body')}}
                {{Form::textarea('body', $data->body, ['id' => 'wysiwyg-editor', 'class' => 'form-control ckeditor ', 'placeholder' => 'Body Text'])}}
            </div>
            <div class="form-group">
                {{Form::file('cover_img')}}
            </div>
            {{Form::hidden('_method','PUT')}}
            {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}



</div>


@endsection
