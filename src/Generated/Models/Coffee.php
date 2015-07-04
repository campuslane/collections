<?php

namespace Cornernote\Collections\Generated\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Coffee Collection Class
 * This class was automatically generated, and shouldn't 
 * be modified directly.
 */

class Coffee extends Model {

	/**
	 * The Collections Table
	 * @var string
	 */
	protected $table = 'c_coffees';

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