<?php

namespace Cornernote\Collections\Services\Model;

use Cornernote\Collections\Models\Collection;
use Cornernote\Collections\Services\Model\ModelData;
use Cornernote\Collections\Services\Utilities\FileWriter;

class ModelWriter {

	/**
	 * Collection Instance
	 * @var object
	 */
	protected $collection;

	/**
	 * Model Data Instance
	 * @var object
	 */
	protected $modelData;

	/**
	 * File Writer Instance
	 * @var object
	 */
	protected $fileWriter;

	/**
	 * Default Values
	 * @var array
	 */
	protected $defaults;

	/**
	 * Model Array
	 * @var array
	 */
	protected $model;

	/**
	 * Instantiate with Model Data
	 * @param ModelData $modelData [description]
	 */
	public function __construct(ModelData $modelData, FileWriter $fileWriter)
	{
		$this->modelData = $modelData;
		$this->fileWriter = $fileWriter;
	}

	/**
	 * Write the Model & Insert Model Records
	 * @param  Collection $collection
	 * @return Laravel Collection
	 */
	public function go(Collection $collection)
	{
		$this->setDefaults();
		$this->setCollection($collection);
		$this->getModelData();
		$this->writeModelFile();
		$this->insertCollectionModelRecord();

		return $this->collection;
	}

	/**
	 * Set Defaults
	 * @return  array
	 */
	private function setDefaults()
	{
		return $this->defaults = [
			'modelStub' => base_path('vendor/cornernote/collections/src/Services/Model/Stubs/model.stub.php'), 
		];
	}

	/**
	 * Set the Collection Instance
	 * @param object $collection
	 */
	private function setCollection($collection)
	{
		$this->collection = $collection;
		$this->modelData->setCollection($collection);

		return $this->collection;
	}

	/**
	 * Get the Model Data
	 * We get an array of attributes from model data
	 */
	private function getModelData()
	{
		return $this->model = $this->modelData->get();
	}

	/**
	 * Write Model File
	 */
	private function writeModelFile()
	{
		$stub = $this->defaults['modelStub'];
		$file = $this->model['file'];
		$this->model = $this->stringifyModelArrays($this->model);

		return $this->fileWriter->write($stub, $file, $this->model);
	}

	/**
	 * Insert the Collection Model Record
	 * @return Laravel Collection
	 */
	private function insertCollectionModelRecord()
	{
		$this->collection->model()->create($this->model);
	}

	/**
	 * Go through Model Array and Convert any Array Values to Strings
	 * @param  array $array
	 * @return array
	 */
	private function stringifyModelArrays($array)
	{
		foreach($array as $key => $value) {
			if (is_array($value)) {
				$array[$key] = $this->stringifyArray($value);
			}
		}

		return $array;
	}

	/**
	 * Stringify Array
	 * Take a single level array create a string representation.
	 * @param  array $array
	 * @return array
	 */
	private function stringifyArray($array)
	{
		$output = '[';

		foreach($array as $key => $value) {
			if(is_integer($key)) {
				$output .= "'" . $value . "', ";
			} else {
				$output .= "'".$key."'=>'" . $value . "', ";
			}
		}

		$output = trim($output, ', ');

		$output .= ']';

		return $output;
	}

}