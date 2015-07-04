<!-- Name -->
<div class="form-group">
	<label for="name">Name</label>
	{!! $errors->first('name','<div class="alert alert-danger">:message</div>') !!}
	<input type="text" id="collection-name" name="name" class="form-control" value="{{old('name', $collection->name)}}">
</div>


<!-- Slug -->
<div class="form-group">
	<label for="slug">Slug</label>
	{!! $errors->first('slug','<div class="alert alert-danger">:message</div>') !!}
	<input type="text" id="collection-slug" name="slug" class="form-control" value="{{old('slug', $collection->slug)}}">
</div>