<?php

namespace Cornernote\Collections\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model {

	/**
	 * The Collections Table
	 * @var string
	 */
	protected $table = 'collections';

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
			'name' => 'required|unique:collections,name,:id', 
			'slug' => 'required|unique:collections,slug,:id', 
		];


	/**
	 * A Collection Can Belong to a Parent Collection
	 * @return Relationship
	 */
	public function parent()
	{
		return $this->belongsTo('Cornernote\Collections\Models\Collection');
	}

	/**
	 * A Collection Can Have Many Child Collections
	 * @return Relationship
	 */
	public function children()
	{
		return $this->hasMany('Cornernote\Collections\Models\Collection', 'parent_id');
	}

	/**
	 * A Collection Has One Model
	 * @return Relationship
	 */
	public function model()
	{
		return $this->hasOne('Cornernote\Collections\Models\Model');
	}

	/**
	 * A Collection Can Have Many Fields
	 * @return Relationship
	 */
	public function fields()
	{
		return $this->hasMany('Cornernote\Collections\Models\Field');
	}

	/**
	 * A Collection Can Have Many Forms
	 * @return Relationship
	 */
	public function forms()
	{
		return $this->hasMany('Cornernote\Collections\Models\Form');
	}

	/**
	 * Get the Collection Validation Rules
	 * @param  laravel collection $collection
	 * @return array
	 */
	public static function getRules($collection='')
	{
		$rules = static::$rules;

		if($collection) {
			$rules = [];
			foreach(static::$rules as $name => $rule) {
				$rules[$name] = str_replace(':id', $collection->id, $rule);
			}
		}
		
		return $rules;
	}

}