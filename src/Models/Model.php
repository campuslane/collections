<?php

namespace Cornernote\Collections\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel {

	/**
	 * The Models Table
	 * @var string
	 */
	protected $table = 'models';

	/**
	 * The Guarded Fields
	 * @var array
	 */
	protected $guarded = ['id'];

	/**
	 * A Model Belongs to a Collection
	 * @return Relationship
	 */
	public function collection()
	{
		return $this->belongsTo('Cornernote\Collections\Models\Collection');
	}

	/**
	 * A Model Has Many Relations
	 * @return Relationship
	 */
	public function relations()
	{
		return $this->hasMany('Cornernote\Collections\Models\Relation');
	}


}