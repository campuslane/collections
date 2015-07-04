@extends('collections::layouts.app')


@section('title', 'Collection: ' . $collection->name)

@section('content')

	<div class="breadcrumb">
		<a href="/collections">Collections</a> / 
		{{$collection->name}}
	</div>

	<h1>{{$collection->name}}</h1>

	@include('partials.flash_success')

	<hr>
		<div class="clearfix">
			<div class="pull-left">
				{{ count($items) }} {{ trans_choice('collections::collections.items', count($items)) }}
			</div>
			<div class="pull-right">
				<a href="/collections/{{$collection->slug}}/items/new"><i class="fa fa-plus-circle"></i> New Item</a>
			</div>
		</div>
	<hr>

	@if( count($items) > 0)

		<table class="table table-bordered">

			<tr>
				
				<th>Name</th>
				<th>Actions</th>
			</tr>

			@foreach($items as $item)
				<tr>
					<td><a href="/collections/{{$collection->slug}}/items/edit/{{$item->id}}">{{ $item->name }}</a></td>
					<td>
						<a href="/collections/{{$collection->slug}}/items/edit/{{$item->id}}">Edit</a> |
						<a href="/collections/{{$collection->slug}}/items/show/{{$item->id}}">Show</a> |
						<a href="/collections/{{$collection->slug}}/items/delete/{{$item->id}}">Delete</a>
						
					</td>
				</tr>
			@endforeach

		</table>

	@else

		{{ trans('collections::items.no_items', ['name' => $collection->name]) }}

	@endif


@endSection