<?php

namespace Cornernote\Collections\Services\Table;

use DB;
use Schema;
use Cornernote\Collections\Models\Collection;

class TableAnalyzer {

	/**
	 * The Table Columns Array
	 * @var array
	 */
	protected $columns;

	/**
	 * Get the Table Attributes
	 * 		
	 * @param  string $table
	 * @return array
	 */
	public function getAttributes($table)
	{
		$select = "

			SELECT 

				COLUMN_NAME as 'name', 
				COLUMN_TYPE as 'full_type', 
				COLUMN_KEY as 'index', 
				DATA_TYPE as 'type', 
				IS_NULLABLE as 'nullable', 
				COLUMN_DEFAULT  as 'default', 
				CHARACTER_MAXIMUM_LENGTH  as 'size'

	   		FROM INFORMATION_SCHEMA.COLUMNS

	   		WHERE table_name = '$table'

   		";

		$this->columns = DB::select($select);

   		return $this->formatOutput($table);

	}

	/**
	 * Get Column Attributes
	 * @param  string $table
	 * @param  string $column
	 * @return array
	 */
	public function getColumnAttributes($table, $column)
	{
		$tableAttributes = $this->getAttributes($table);

		return $tableAttributes['columns'][$column];

	}

	/**
	 * Format the Output to an Array
	 * @return array
	 */
	private function formatOutput($table)
	{
		$output = [];

		$output['table'] = $table;
		$output['columns'] = [];

		foreach($this->columns as $column) {

			$column->size = $this->setColumnSize($column->size, $column->full_type);
			
			$output['columns'][$column->name] = [
				'column' => $column->name, 
				'full_type' => $column->full_type, 
				'type' => $column->type,
				'nullable' => $column->nullable,
				'default' => $column->default,
				'size' => $column->size, 
			];
		}

		return $output;
	}

	/**
	 * Set Column Size
	 * For the mysql INT type there is no size value returned. 
	 * So if the size is empty, we grab the size value from the 
	 * full type information which has the basic format: 
	 * 		int(10) unsigned
	 * For this case it returns the value 10;
	 * 
	 * @param integer/empty $size  
	 * @param string $full_type
	 * @return integer or empty string
	 */
	private function setColumnSize($size, $full_type)
	{
		// e.g. takes: "int(10) unsigned" and sets $length as 10
		if( ! $size ) {
			preg_match('/\d+/', $full_type, $length);
			return $length = isset($length[0]) ? $length[0]: '';
		}
		return $size;
	}


}