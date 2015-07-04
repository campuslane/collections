@extends('collections::layouts.app')


@section('page_title', 'Add a New Page')


@section('content')

	<div class="breadcrumb">
		<a href="{{route('dashboard')}}">Dashboard</a> / 
		Pages
	</div>

	<h1>Pages</h1>

	<hr>
		<div class="list-header clearfix">
			<div class="pull-left">
				<strong>All ({{ count($pages) }})</strong> 
				@if($trashCount > 0)
					&nbsp; | &nbsp;  <a href="{{route('pages.trash.index')}}">Trash ({{$trashCount}})</a>
				@endif
			</div>

			<div class="pull-right">
				<a href="{{route('pages.create')}}"><i class="fa fa-plus-circle"></i> New Page</a>
			</div>
		</div>
	<hr>

	@if( Session::get('trashed'))
		<div class="alert alert-success">{!! Session::get('trashed') !!}</div>
	@endif
	

	@if(count($pages) > 0)
		<table class="table table-bordered">
			<tr>
				<th>Page</th>
				<th>Actions</th>
			</tr>

			@foreach($pages as $page)
				<tr>
					<td>{{$page->title}}</td>
					<td>
						<a href="{{route('pages.edit', $page->id)}}">Edit</a> | 
						<a href="{{route('pages.trash', $page->id)}}">Trash</a> | 
						<a href="/{{$page->slug}}">View <i class="fa fa-external-link"></i></a>
						</td>
				</tr>
			@endforeach
			
		</table>
	@else
		No Active Pages (but you have 2 in trash)
	@endif

@endsection



