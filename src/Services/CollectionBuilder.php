<?php

namespace Cornernote\Collections\Services;

use Illuminate\Http\Request;
use Cornernote\Collections\Models\Collection;
use Cornernote\Collections\Services\Model\ModelWriter;
use Cornernote\Collections\Services\Table\TableWriter;
use Cornernote\Collections\Services\Field\FieldWriter;

class CollectionBuilder {

	/**
	 * Collection Instance
	 * @var Object
	 */
	protected $collection;

	/**
	 * Model Writer Instance
	 * @var object
	 */
	protected $modelWriter;

	/**
	 * Model Attributes Array
	 * @var array
	 */
	protected $model;

	/**
	 * Table Attributes Array
	 * @var array
	 */
	protected $table;

	/**
	 * Table Writer Instance
	 * @var object
	 */
	protected $tableWriter;

	/**
	 * Field Writer Instance
	 * @var object
	 */
	protected $fieldWriter;

	/**
	 * Instantiate
	 * Inject the Model, Table, & Field Writer Instances
	 */
	public function __construct(ModelWriter $modelWriter, TableWriter $tableWriter, FieldWriter $fieldWriter)
	{
		$this->modelWriter = $modelWriter;
		$this->tableWriter = $tableWriter;
		$this->fieldWriter = $fieldWriter;
	}

	/**
	 * Take the Request Info and Go!
	 * @param  Request $request
	 * @return not sure yet.
	 */
	public function go(Request $request)
	{
	
		$this->createCollection($request);

		$this->writeModel();
		$this->writeTable();
		$this->writeField();

		return $this->collection;
	}

	/**
	 * Create the Base Collection
	 * We just need a name and slug...
	 * @param  Object $request
	 * @return Collection Instance
	 */
	private function createCollection($request)
	{
		$collection = new Collection;
		$collection->name = $request->get('name');
		$collection->slug = $request->get('slug');
		$collection->save();

		return $this->collection = $collection;
	}

	/**
	 * Write the Model File & Insert Collection Model Record
	 * @return array
	 */
	private function writeModel()
	{
		$this->collection = $this->modelWriter->go($this->collection);
	}

	/**
	 * Write the DB Table
	 * @return array (table attributes)
	 */
	private function writeTable()
	{
		$table = $this->collection->model->table;

		return $this->table = $this->tableWriter->go($table);
	}

	/**
	 * Write the Default Name Field
	 * @return array (table attributes);
	 */
	private function writeField()
	{
		$field = [
			'name' => 'name',
			'label' => 'Name',
			'type' => 'string',
		];

		return $this->field = $this->fieldWriter->go($this->collection, $field);
	}
}