@extends('collections::layouts.app')

@section('title', 'Add a New Item')

@section('content')

	<div class="breadcrumb">
		<a href="/collections">Collections</a> /
		<a href="/collections/{{$collection->slug}}">{{$collection->name}}</a> / 
		Add New Item
	</div>

	<h1>Add {{$collection->name}} Item</h1>


	<form method="post" action="/collections/{{$collection->slug}}/items/store">


		<input type="hidden" name="_token" value="{{ csrf_token() }}">

		@foreach($collection->fields as $field)

			<div class="form-group">
				<label for="name">{{ $field->label }}</label>
				{!! $errors->first($field->name,'<div class="alert alert-danger">:message</div>') !!}
				<input type="text" name="{{$field->name}}" class="form-control" value="{{old($field->name)}}">
			</div>

		@endforeach


		<button type="submit" class="btn btn-primary">Add Item</button>
		
		</form>
		

	
@endsection