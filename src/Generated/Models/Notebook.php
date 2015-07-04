<?php

namespace Cornernote\Collections\Generated\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Notebook Collection Class
 * This class was automatically generated, and shouldn't 
 * be modified directly.
 */

class Notebook extends Model {

	/**
	 * The Collections Table
	 * @var string
	 */
	protected $table = 'c_notebooks';

	/**
	 * Guarded Fields
	 * @var array
	 */
	protected $guarded = ['id'];

	/**
	 * Collection Validation Rules
	 * @var array
	 */
	public static $rules = ['name'=>'required'];

	

}