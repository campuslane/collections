@extends('collections::layouts.app')

@section('title', 'Delete ' . $collection->name . ' Collection')
 
@section('content')

	<div class="breadcrumb">
		<a href="/collections">Collections</a> / 
		Delete
	</div>

	<h1>Delete {{$collection->name }} Collection</h1>

	
	<form method="post" action="/collections/delete/{{$collection->id}}">
	
		<input type="hidden" name="_token" value="{{ csrf_token() }}">


			<p>Are you sure?</p>
	
		<button type="submit" class="btn btn-danger">Yes, Delete</button> 
		<a href="#" class="btn btn-default">Cancel</a>
	
	</form>
	
	

@endSection


