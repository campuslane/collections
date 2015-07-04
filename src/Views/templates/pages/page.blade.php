@extends('collections::layouts.clean-blog')


@section('title', $page->title)


@foreach($page->content()->get() as $content)
	
	@section($content->content_area)
		{{$content->content}}
	@endsection

@endforeach