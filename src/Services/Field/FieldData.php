<?php

namespace Cornernote\Collections\Services\Field;

use Cornernote\Collections\Models\Collection;
use Cornernote\Collections\Services\Table\TableAnalyzer;

class FieldData {

	/**
	 * Collection Instance
	 * @var object
	 */
	protected $collection;

	/**
	 * Table Analyzer Instance
	 * @var object
	 */
	protected $tableAnalyzer;

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
	 * The Table Name
	 * @var array
	 */
	protected $table;

	/**
	 * The Field Attributes Array
	 * @var array
	 */
	protected $field;

	/**
	 * Instantiate
	 */
	public function __construct(TableAnalyzer $tableAnalyzer)
	{
		$this->tableAnalyzer = $tableAnalyzer;
		$this->setAttributeNames();
	}

	/**
	 * Set the Attributes Array
	 * @return  array
	 */
	private function setAttributeNames()
	{
		return $this->attributes = [
			'name', 
			'label', 
			'type', 
			'form_label', 
			'form_element', 
			'form_instructions', 
			'sort', 
			'db', 
		];
	}

	/**
	 * Set and Return the Field Attributes
	 * @return array
	 */
	public function setAttributes($table, $field)
	{
		$this->table = $table;
		$this->field = $field;

		foreach($this->attributes as $attribute) {

			$method = $this->createSetterMethod($attribute);

			$this->field[$attribute] = $this->$method();

		}

		return $this->field;
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
	 * Set the Field Name
	 */
	private function setName()
	{
		return $this->field['name'];
	}

	/**
	 * Set the Field Label
	 */
	private function setLabel()
	{
		return isset($this->field['label']) ? $this->field['label'] : 'no label';
	}

	/**
	 * Set the Field Type
	 */
	private function setType()
	{
		return isset($this->field['type']) ? $this->field['type'] : 'no type';
	}

	/**
	 * Set the Field Form Label
	 */
	private function setFormLabel()
	{
		return isset($this->field['form_label']) ? $this->field['form_label'] : $this->field['label'];
	}

	/**
	 * Set the Field Form Element
	 */
	private function setFormElement()
	{
		return $this->field['type'] == 'text' ? 'textarea' : 'text';
	}

	/**
	 * Set the Field Form Instructions
	 */
	private function setFormInstructions()
	{
		return isset($this->field['form_instructions']) ? $this->field['form_instructions'] : '';
	}

	/**
	 * Set the Field Sort Value
	 */
	private function setSort()
	{
		return isset($this->field['sort']) ? $this->field['sort'] : 0;
	}

	/**
	 * Set the Field Db Array
	 */
	private function setDb()
	{
		return serialize($this->tableAnalyzer->getColumnAttributes($this->table, $this->field['name']));
	}

}