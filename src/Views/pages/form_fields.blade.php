<div class="row">

	<div class="col-lg-12 col-md-12 col-sm-12">
		<!-- Title -->
		<div class="form-group">
			
			{!! $errors->first('title','<div class="alert alert-danger">:message</div>') !!}
			<input type="text" name="title" class="form-control input-lg" value="{{old('title', $page->title)}}">
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8">

		
	

		<!-- Content -->
		<div class="form-group">
			
			{!! $errors->first('content','<div class="alert alert-danger">:message</div>') !!}
			<textarea style="min-height:360px" name="content" class="form-control">{{old('content', $page->content)}}</textarea>
		</div>
	</div>

	<div class="col-lg-4 col-md-4 col-sm-4">
		<div class="well" style="min-height:360px;">
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
			<input type="text" name="template" class="form-control" value="{{old('template', $page->template)}}">
		</div>
			<br>
			<button class="btn btn-primary">Publish</button>
			<br>
		</div>
	</div>
</div>



