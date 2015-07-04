<?php

namespace Cornernote\Collections\Models;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model {

	/**
	 * The Page Content Table
	 * @var string
	 */
	protected $table = 'page_content';

	/**
	 * Guarded Fields
	 * @var array
	 */
	protected $guarded = ['id'];


	/**
	 * A Content Section Belongs to a Page
	 * @return Relationship
	 */
	public function page()
	{
		return $this->belongsTo('Cornernote\Collections\Models\Page');
	}


}