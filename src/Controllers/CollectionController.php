<?php 

namespace Cornernote\Collections\Controllers;

use App;
use Illuminate\Http\Request;
use Cornernote\Collections\Models\Collection;
use Cornernote\Collections\Jobs\CreateCollection;
use Cornernote\Collections\Events\CollectionDeleted;

class CollectionController extends Controller {


	/**
	 * Index Listing of Collections
	 * @return view response
	 */
	public function index()
	{
		$collections = Collection::orderBy('updated_at', 'desc')->get();

		return view('collections::collections.index', compact('collections'));
	}

	/**
	 * Form to Create a New Collection
	 * @param  Request $request
	 * @return view response
	 */
	public function create()
	{
		$collection = new Collection;

		return view('collections::collections.create', compact('collection'));
	}

	/**
	 * Save the New Collection
	 * Why yes we are validating in the controller, thanks for asking.
	 * @param  Request $request
	 * @return redirect response
	 */
	public function store(Request $request)
	{
		$this->validate($request, Collection::getRules());

		$collection = $this->dispatchFrom(CreateCollection::class, $request);

		return redirect()->to('/collections')->with('status', 'Added New Collection');
	}

	/**
	 * Collection Show
	 * @param  string $slug
	 * @return view response
	 */
	public function show($slug)
	{
		$collection = Collection::with('model')->whereSlug($slug)->first();

		$class = $collection->model->class_with_namespace;

		$items = $class::orderBy('updated_at', 'desc')->get();

		return view('collections::collections.show', compact('collection', 'items'));

	}

	/**
	 * Show the Collection Edit Form
	 * @param  string $slug
	 * @return view response
	 */
	public function edit($slug)
	{
		$collection = Collection::whereSlug($slug)->first();

		return view('collections::collections.edit', compact('collection'));
		
	}

	/**
	 * Update the Collection
	 * @param  Request $request
	 * @param  string  $slug
	 * @return redirect response
	 */
	public function update(Request $request, $slug)
	{
		$collection = Collection::whereSlug($slug)->first();

		$this->validate($request, Collection::getRules($collection));

		$collection->update(['name'=>$request['name'], 'slug'=>$request['slug']]);

		return redirect()->to('/collections')->with('status', 'Collection was Updated');

	}

	/**
	 * Confirm Before Deleting a Collection
	 * @param  string $slug
	 * @return redirect response | exception
	 */
	public function deleteConfirm($slug)
	{
		$collection = Collection::whereSlug($slug)->first();

		return view('collections::collections.delete', compact('collection'));
	}

	/**
	 * Delete the Collection
	 * Also fire event to remove the model file, collection table, etc.
	 * @param  integer $id
	 * @return response redirect
	 */
	public function delete($id)
	{
		$collection = Collection::findOrFail($id);

		if (! $collection->delete()) {
			die("oops did not delete the collection: $id");
		}

		event(new CollectionDeleted($id));

		return redirect()->to('/collections')->with('status', 'Collection Deleted');
	}


}