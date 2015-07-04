<?php 

namespace Cornernote\Collections\Controllers;

use App;
use Illuminate\Http\Request;
use Cornernote\Collections\Models\Collection;
use Cornernote\Collections\Jobs\CreateCollection;
use Cornernote\Collections\Events\CollectionDeleted;

class ItemController extends Controller {

	/**
	 * Form to Create a New Collection Item
	 * @param  Request $request
	 * @return view response
	 */
	public function create($collectionSlug)
	{
		$collection = Collection::with('model', 'fields')->whereSlug($collectionSlug)->first();

		$items = App::make($collection->model->class_with_namespace)->orderBy('created_at', 'desc')->get();

		return view('collections::items.create', compact('collection', 'items'));
	}

	/**
	 * Save the New Collection Item
	 * Why yes we are validating in the controller, thanks for asking.
	 * @param  Request $request
	 * @return redirect response
	 */
	public function store(Request $request, $collectionSlug)
	{
		$collection = Collection::with('model')->whereSlug($collectionSlug)->first();

		$model = $collection->model->class_with_namespace;

		$this->validate($request, $model::$rules);

		App::make($model)->create($request->all());

		return redirect()->to('/collections/'.$collection->slug)->with('status', 'Added New Item');
	}


	/**
	 * Edit a Collection Item
	 * @param  string $collectionSlug
	 * @param  integer $itemId
	 * @return view response
	 */
	public function edit($collectionSlug, $itemId)
	{
		$collection = Collection::with('model', 'fields')->whereSlug($collectionSlug)->first();

		$item = App::make($collection->model->class_with_namespace)->find($itemId);

		return view('collections::items.edit', compact('collection', 'item'));
	}

	/**
	 * Update the Collection Item
	 * @param  Request $request        
	 * @param  string  $collectionSlug
	 * @param  integer  $itemId
	 * @return redirect response                
	 */
	public function update(Request $request, $collectionSlug, $itemId)
	{
		$collection = Collection::with('model', 'fields')->whereSlug($collectionSlug)->first();

		$model = App::make($collection->model->class_with_namespace);

		$this->validate($request, $model::$rules);

		$item = $model->find($itemId)->update($request->all());

		return redirect()->to('/collections/'.$collection->slug)->with('status', 'Updated Item'); 
	}

	public function show($id) 
	{
		return 'show item';
	}

	public function deleteConfirm($id)
	{
		return 'form to confirm delete';
	}

	public function delete($id)
	{
		return 'delete item';
	}


}