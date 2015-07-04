@extends('collections::layouts.app')


@section('title', 'Collections')

@section('content')

	<div class="breadcrumb">Collections</div>

	<h1>Collections</h1>

	@include('partials.flash_success')

	<hr>
		<div class="clearfix">
			<div class="pull-left">
				{{ count($collections) }} {{ trans_choice('collections::collections.collections', count($collections)) }}
			</div>
			<div class="pull-right">
				<a href="/collections/create"><i class="fa fa-plus-circle"></i> New Collection</a>
			</div>
		</div>
	<hr>

	@if( count($collections) > 0)

		<table class="table table-bordered">

			<tr>
				
				<th>Name</th>
				<th>Actions</th>
			</tr>

			@foreach($collections as $collection)
				<tr>
					<td><a href="/collections/{{$collection->slug}}">{{ $collection->name }}</a></td>
					<td>
						<a href="/collections/edit/{{$collection->slug}}">Edit</a> | 
						<a href="/collections/delete/{{$collection->slug}}">Delete</a>
					</td>
				</tr>
			@endforeach

		</table>

	@else

		No Collections Yet...

	@endif


@endSection