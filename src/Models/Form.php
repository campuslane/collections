<?php

namespace Cornernote\Collections\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model {

	protected $table = 'forms';

	/**
	 * A Field Belongs to a Collection
	 * @return Relationship
	 */
	public function collection()
	{
		return $this->belongsTo('Cornernote\Collections\Models\Collection');
	}
}