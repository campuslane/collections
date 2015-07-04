<?php

namespace Cornernote\Collections\Jobs;

use Schema;
use App\Jobs\Job;
use Illuminate\Http\Request;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Cornernote\Collections\Models\Collection;
use Cornernote\Collections\Services\Table\TableAnalyzer;


class WriteTable extends Job implements SelfHandling
{

    use DispatchesJobs;

    /**
     * The Collection Instance
     * @var object
     */
    protected $collection;

    /**
     * The Table Name
     * @var string
     */
    protected $table;

    /**
     * Table Analyzer Instance
     * @var object
     */
    protected $tableAnalyzer;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Execute the job.
     *
     * @return Laravel Collection
     */
    public function handle(TableAnalyzer $tableAnalyzer)
    {
        $this->tableAnalyzer = $tableAnalyzer;
        $this->setTable();
        $this->writeTable();
        $this->verifyTable();

        return $this->getTableAttributes();
    }

    /**
     * Set the Table Name
     * @return string
     */
    private function setTable()
    {
        return $this->table = $this->collection->model->table;
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
