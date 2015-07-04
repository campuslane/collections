<?php

namespace {{namespace}};

use Illuminate\Database\Eloquent\Model;

/**
 * {{class}} Collection Class
 * This class was automatically generated, and shouldn't 
 * be modified directly.
 */

class {{class}} extends Model {

	/**
	 * The Collections Table
	 * @var string
	 */
	protected $table = '{{table}}';

	/**
	 * Guarded Fields
	 * @var array
	 */
	protected $guarded = {{guarded}};

	/**
	 * Collection Validation Rules
	 * @var array
	 */
	public static $rules = {{rules}};

	

}