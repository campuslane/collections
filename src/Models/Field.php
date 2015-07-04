<?php

namespace Cornernote\Collections\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model {

	/**
	 * The Fields Table
	 * @var string
	 */
	protected $table = 'fields';

	/**
	 * Fields Guarded from Mass Assignment
	 * @var array
	 */
	protected $guarded = ['id'];

	/**
	 * A Field Belongs to a Collection
	 * @return Relationship
	 */
	public function collection()
	{
		return $this->belongsTo('Cornernote\Collections\Models\Collection');
	}


}