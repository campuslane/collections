<?php

namespace Cornernote\Collections\Services\Table;

use Schema;
use Cornernote\Collections\Models\Collection;
use Cornernote\Collections\Services\Table\TableAnalyzer;
use Cornernote\Collections\Exceptions\TableNotCreated;

class TableWriter {

	/**
	 * The Table Name
	 * @var string
	 */
	protected $table;

	/**
	 * The Table Analyzer Instance
	 * @var object
	 */
	protected $tableAnalyzer;

	/**
	 * Instantiate
	 */
	public function __construct(TableAnalyzer $tableAnalyzer)
	{
		$this->tableAnalyzer = $tableAnalyzer;
	}

	/**
	 * Start the Table Writing
	 * @param  array $model
	 * @return array
	 */
	public function go($table)
	{
		$this->table = $table;
		$this->writeTable();
		$this->verifyTable();

		return $this->getTableAttributes();
	}

	/**
	 * Write Table
	 * @param  string $table (table name)	
	 * @return array (table attributes)
	 */
	private function writeTable()
	{
		return Schema::create($this->table, function($table){
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Verify the Table Exists
	 * @return true|exception
	 */
	private function verifyTable()
	{
		if (! Schema::hasTable($this->table)) {
			throw new TableNotCreated($this->table);
		}

		return true;
	}

	/**
	 * Get the Table Attributes
	 * @return array
	 */
	private function getTableAttributes()
	{
		return $this->tableAnalyzer->getAttributes($this->table);
	}
}