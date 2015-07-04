<?php

namespace Cornernote\Collections\Models;

use Illuminate\Database\Eloquent\Model;

class PageTemplate extends Model {

	/**
	 * The Page Content Table
	 * @var string
	 */
	protected $table = 'page_templates';

	/**
	 * Guarded Fields
	 * @var array
	 */
	protected $guarded = ['id'];


	/**
	 * A Page Template can belong to Many Pages
	 * @return Relationship
	 */
	public function page()
	{
		return $this->belongsToMany('Cornernote\Collections\Models\Page');
	}



}