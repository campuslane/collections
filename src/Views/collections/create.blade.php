@extends('collections::layouts.app')

@section('title', 'Add a New Collection')
 
@section('content')

	<div class="breadcrumb">
		<a href="/collections">Collections</a> / 
		Add New
	</div>

	<h1>Add a New Collection</h1>

	
	<form method="post" action="/collections/store">
	
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
	
			@include('collections::collections.form_fields')
	
		<button type="submit" class="btn btn-primary">Add Collection</button>
	
	</form>
	
	

@endSection


@section('scripts')

	<script>

		function slugify (value) {
		  return value.toLowerCase().replace(/-+/g, '').replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
		};

		$(function(){
			$(document).on('keyup', '#collection-name', function(e){
				$('#collection-slug').val( slugify($(this).val()) );
			});
		});

	</script>

@endsection