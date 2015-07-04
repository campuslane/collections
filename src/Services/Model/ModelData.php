<?php

namespace Cornernote\Collections\Services\Model;

use Cornernote\Collections\Models\Collection;
use Cornernote\Collections\Exceptions\ModelSetterMethodMissing;

class ModelData {

	/**
	 * Collection Instance
	 * @var object
	 */
	protected $collection;

	/**
	 * Model Attribute Names
	 * @var array
	 */
	protected $attributes;

	/**
	 * Default Model Attribute Values
	 * @var array
	 */
	protected $defaults;

	/**
	 * The Model Data Array
	 * @var array
	 */
	protected $model;

	/**
	 * Instantiate
	 */
	public function __construct()
	{
		$this->setAttributes();
		//$this->setDefaults(); 
	}

	/**
	 * Set the Attributes Array
	 * @return  array
	 */
	private function setAttributes()
	{
		return $this->attributes = [

			'file', 
			'namespace', 
			'class', 
			'class_with_namespace', 
			'table', 
			'guarded', 
			'fillable', 
			'protected', 
			'rules'

		];
	}

	/**
	 * Get, Set, and Return the Model Data
	 * @return array
	 */
	public function get(Collection $collection, $defaults)
	{
		$this->collection = $collection;
		$this->defaults = $defaults;

		foreach($this->attributes as $attribute) {

			$method = $this->createSetterMethod($attribute);

			$this->model[$attribute] = $this->$method();

		}

		return $this->model;
	}

	/**
	 * Create the Setter Method
	 * @param  string $attribute
	 * @return string
	 */
	private function createSetterMethod($attribute)
	{
		$method = 'set' . studly_case($attribute);

		if (! method_exists($this, $method) ){
			throw new ModelSetterMethodMissing($method);
		}

		return $method;
	}

	/**
	 * Set the File Name (includes path)
	 * @return  string
	 */
	private function setFile()
	{
		$baseName = str_singular(trim(studly_case($this->collection->name)));
		return $this->defaults['path'] . $baseName . '.php';
	}

	/**
	 * Set Namespace
	 * @return  string
	 */
	private function setNamespace()
	{
		return $this->defaults['namespace'];
	}

	/**
	 * Set Class Name
	 * @return  string
	 */
	private function setClass()
	{
		return str_singular(trim(studly_case($this->collection->name)));
	}

	/**
	 * Set Class with Namespace
	 * @return  string
	 */
	private function setClassWithNamespace()
	{
		return $this->model['namespace'] . '\\' . $this->model['class'];
	}

	/**
	 * Set the Table Name
	 * @return  string
	 */
	private function setTable()
	{
		$table = trim(str_replace('-', '_', snake_case($this->collection->slug)));
		return $this->defaults['table_prefix'] . $table;
	}

	/**
	 * Set the Guarded Array
	 * @return  array
	 */
	private function setGuarded()
	{
		return $this->defaults['guarded'];
	}

	/**
	 * Set the Fillable Array
	 * @return  array
	 */
	private function setFillable()
	{
		return $this->defaults['fillable'];
	}

	/**
	 * Set the Protected Array
	 * @return  array
	 */
	private function setProtected()
	{
		return $this->defaults['protected'];
	}

	/**
	 * Set the Rules Array
	 */
	private function setRules()
	{
		return $this->defaults['rules'];
	}


}