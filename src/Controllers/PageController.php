<?php 

namespace Cornernote\Collections\Controllers;

use App;
use Illuminate\Http\Request;
use Cornernote\Collections\Models\Page;
use Cornernote\Collections\Models\PageContent;
use Cornernote\Collections\Models\PageTemplate;

class PageController extends Controller {

	/**
	 * Pages Index
	 * @return view response
	 */
	public function index($type='')
	{
		$pages = Page::with('content')->get();

		$trashCount = Page::onlyTrashed()->count();

		return view('collections::pages.index', compact('pages', 'trashCount'));
	}

	/**
	 * Pages in Trash Index
	 * @return view response
	 */
	public function trashIndex()
	{
		$pages = Page::with('content')->onlyTrashed()->orderBy('deleted_at', 'desc')->get();
		$allCount = count(Page::get());

		return view('collections::pages.trash', compact('pages', 'allCount'));
	}


	/**
	 * Show the Page (front end)
	 * @param  string $slug
	 * @return view response 
	 */
	public function show($slug)
	{
		$page = Page::with('content')->whereSlug($slug)->first();

		if (!$page) {
			abort(404);
		}

		return view('collections::templates.pages.' . $page->template, compact('page'));
	}

	/**
	 * Create the Page Form
	 * @return view response
	 */
	public function create()
	{
		$page = new Page;

		return view('collections::pages.create', compact('page'));
	}

	/**
	 * Store the New Page in Db
	 * @param  Request $request
	 * @return redirect response
	 */
	public function store(Request $request)
	{
		$rules = ['title'=>'required', 'slug'=>'required'];

		$this->validate($request, $rules);

		$page = Page::createWithContent($request);

		return redirect()->route('pages')->with('status', 'Page Added');
	}

	/**
	 * Edit Page Form
	 * @param  integer $id
	 * @return view response     
	 */
	public function edit($id)
	{
		$page = Page::with('content')->findOrFail($id);

		$page->content = $page->content()->first()->content;

		return view('collections::pages.edit', compact('page'));
	}

	/**
	 * Update Page in DB
	 * @param  Request $request
	 * @param  integer  $id
	 * @return redirect response
	 */
	public function update(Request $request, $id)
	{
		$rules = ['title'=>'required', 'slug'=>'required'];

		$this->validate($request, $rules);

		$page = Page::with('content')->findOrFail($id);

		$page = $page->updateWithContent($request);

		return redirect()->route('pages')->with('status', 'Page Updated');
	}

	/**
	 * Put Page in Trash
	 * @param  integer $id
	 * @return redirect response
	 */
	public function trash($id)
	{
		$page = Page::findOrFail($id);

		$page->delete();

		$restoreMessage = "The page: {$page->title} was moved to trash. ";
		$restoreLink = '<a href="' . route('pages.restore', $page->id) . '">Undo</a>';

		return redirect()->back()->with('trashed', $restoreMessage . $restoreLink);
	}

	public function restore($id)
	{
		$page = Page::onlyTrashed()->whereId($id)->first();

		$page->restore();

		$restoreMessage = "The page: {$page->title} was restored";

		return redirect()->route('pages')->with('trashed', $restoreMessage);
	}

	public function deleteConfirm()
	{

	}

	public function delete()
	{
		
	}


}