@extends('collections::layouts.app')


@section('page_title', 'Edit Page')


@section('content')

	<div class="breadcrumb">
		<a href="{{route('dashboard')}}">Dashboard</a> / 
		<a href="{{route('pages')}}">Pages</a> / 
		Edit Page
	</div>

	<h1>Edit Page</h1>

	<hr>

	<form method="post" action="{{route('pages.update', $page->id)}}">
	
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
	
	
			@include('collections::pages.form_fields')
	

		<button type="submit" class="btn btn-primary">Update Page</button>
		
	</form>
		

@endsection