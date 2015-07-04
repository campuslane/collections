@extends('collections::layouts.app')


@section('page_title', 'Add a New Page')


@section('content')

	<div class="breadcrumb">
		<a href="{{route('dashboard')}}">Dashboard</a> / 
		<a href="{{route('pages')}}">Pages</a> / 
		Add a New page
	</div>

	<h1>Add a New Page</h1>

	<hr>

	<form method="post" action="{{route('pages.store')}}">
	
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
	
	
		<!-- Title -->
		<div class="form-group">
			<label for="title">Page Title</label>
			{!! $errors->first('title','<div class="alert alert-danger">:message</div>') !!}
			<input type="text" name="title" class="form-control" value="{{old('title', $page->title)}}">
		</div>


		<!-- Slug -->
		<div class="form-group">
			<label for="slug">URL Slug</label>
			{!! $errors->first('slug','<div class="alert alert-danger">:message</div>') !!}
			<input type="text" name="slug" class="form-control" value="{{old('slug', $page->slug)}}">
		</div>


		<!-- Template -->
		<div class="form-group">
			<label for="template">Template</label>
			{!! $errors->first('template','<div class="alert alert-danger">:message</div>') !!}
			<input type="text" name="template" class="form-control" value="{{old('template, $page->template')}}">
		</div>


		<!-- Content -->
		<div class="form-group">
			<label for="content">Content</label>
			{!! $errors->first('content','<div class="alert alert-danger">:message</div>') !!}
			<textarea style="min-height:200px" name="content" class="form-control">{{old('content', $page->content)}}</textarea>
		</div>
	

		<button type="submit" class="btn btn-primary">Add New Page</button>
		
	</form>
		

@endsection