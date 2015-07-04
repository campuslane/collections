<?php

namespace Cornernote\Collections\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cornernote\Collections\Models\PageContent;

class Page extends Model {

	use softDeletes;

	/**
	 * The Pages Table
	 * @var string
	 */
	protected $table = 'pages';

	/**
	 * Guarded Fields
	 * @var array
	 */
	protected $guarded = ['id'];

	/**
	 * Validation Rules
	 * @var array
	 */
	protected static $rules = [
			'title' => 'required|unique:pages,title,:id', 
			'slug' => 'required|unique:pages,slug,:id', 
	];

	/**
	 * Create Page with Content
	 * @param  object $request
	 * @return laravel collection
	 */
	public static function createWithContent($request)
	{
		$page = self::create([
			'title'=>$request['title'], 
			'slug'=>$request['slug'], 
			'template'=>$request['template'], 
		]);

		$content = new PageContent([
			'content_area' => 'main', 
			'content' => $request['content'], 
		]);

		$page->content()->save($content);

		return $page;
	}

	/**
	 * Update Page with Content
	 * @param  object $page
	 * @param  object $request
	 * @return Laravel Collection
	 */
	public function updateWithContent($request)
	{
		$this->update([
			'title'=>$request['title'], 
			'slug'=>$request['slug'], 
			'template'=>$request['template'], 
		]);

		$this->content->update([
			'content_area' => 'main', 
			'content' => $request['content'], 
		]);

		$this->save();

		return $this;
	}

	/**
	 * A Page Has One Template
	 * @return Relationship
	 */
	public function template()
	{
		return $this->hasOne('Cornernote\Collections\Models\PageTemplate');
	}

	/**
	 * A Page Has Many Content Sections
	 * @return Relationship
	 */
	public function content()
	{
		return $this->hasOne('Cornernote\Collections\Models\PageContent');
	}



	/**
	 * Get the Page Validation Rules
	 * @param  laravel collection $page
	 * @return array
	 */
	public static function getRules($page='')
	{
		$rules = static::$rules;

		if($page) {
			$rules = [];
			foreach(static::$rules as $name => $rule) {
				$rules[$name] = str_replace(':id', $page->id, $rule);
			}
		}
		
		return $rules;
	}

}