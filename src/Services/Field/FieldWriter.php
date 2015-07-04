<?php

namespace Cornernote\Collections\Services\Field;

use Schema;
use Cornernote\Collections\Models\Collection;
use Cornernote\Collections\Services\Field\FieldData;
use Cornernote\Collections\Exceptions\FieldNotCreated;

class FieldWriter {

	/**
	 * Field Array
	 * @var array
	 */
	protected $field;

	/**
	 * Collection Instance
	 * @var object
	 */
	protected $collection;

	/**
	 * Table Name
	 * @var string
	 */
	protected $table;

	/**
	 * Field Data Instance
	 * @var [type]
	 */
	protected $fieldData;

	/**
	 * Instantiate
	 * @param TableAnalyzer $tableAnalyzer
	 */
	public function __construct(FieldData $fieldData)
	{
		$this->fieldData = $fieldData;
	}

	/**
	 * Write the Field
	 * @param  string $table
	 * @param  array $field
	 * @return array (the table attributes)
	 */
	public function go($collection, $field)
	{
		$this->collection = $collection;
		$this->table = $collection->model->table;
		$this->field = $field;

		$this->writeField();
		$this->verifyField();
		$this->setFieldAttributes();
		$this->insertCollectionFieldRecord();

		return $this->collection;
	}

	/**
	 * Write the Field
	 * @return boolean
	 */
	private function writeField()
	{
		$type = $this->field['type'];
		$name = $this->field['name'];

		return Schema::table($this->table, function($table) use($type, $name) {
			$table->$type($name);
		});
	}

	/**
	 * Verify the Field (column) Exists
	 * @return true | exception
	 */
	private function verifyField()
	{
		if (! Schema::hasColumn($this->table, $this->field['name'])) {
			throw new FieldNotCreated($this->table . ' | ' . $this->field['name']);
		}

		return true;
	}

	/**
	 * Set Field Attributes
	 */
	private function setFieldAttributes()
	{
		$this->field = $this->fieldData->setAttributes($this->table, $this->field);
	}

	/**
	 * Insert the Collection Field Record
	 * @return Laravel Collection
	 */
	private function insertCollectionFieldRecord()
	{
		return $this->collection->fields()->create($this->field);
	}

}