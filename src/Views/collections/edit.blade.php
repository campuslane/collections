@extends('collections::layouts.app')

@section('title', 'Edit ' . $collection->name . ' Collection')
 
@section('content')

	<div class="breadcrumb">
		<a href="/collections">Collections</a> / 
		Edit
	</div>

	<h1>Edit {{$collection->name }} Collection</h1>

	
	<form method="post" action="/collections/update/{{$collection->slug}}">
	
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
	
			@include('collections::collections.form_fields')
	
		<button type="submit" class="btn btn-primary">Update Collection</button>
	
	</form>
	
	

@endSection


