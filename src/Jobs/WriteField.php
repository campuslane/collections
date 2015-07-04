<?php

namespace Cornernote\Collections\Jobs;

use Schema;
use App\Jobs\Job;
use Illuminate\Http\Request;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Cornernote\Collections\Models\Collection;
use Cornernote\Collections\Services\Field\FieldData;
use Cornernote\Collections\Services\Table\TableAnalyzer;


class WriteField extends Job implements SelfHandling
{

    use DispatchesJobs;

    /**
     * The Collection Instance
     * @var object
     */
    protected $collection;

    /**
     * The Field Attributes
     * @var array
     */
    protected $field;

    /**
     * The Table Name
     * @var string
     */
    protected $table;

    /**
     * Field Data Instance
     * @var object
     */
    protected $fieldData;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Collection $collection, $field)
    {
        $this->collection = $collection;
        $this->field = $field;
    }

    /**
     * Execute the job.
     *
     * @return Laravel Collection
     */
    public function handle(FieldData $fieldData, TableAnalyzer $tableAnalyzer)
    {
        $this->setTableName();
        $this->writeField();
        $this->verifyField();
        $this->setFieldAttributes($fieldData);
        $this->insertCollectionFieldRecord();

        return $tableAnalyzer->getColumnAttributes($this->table, $this->field['name']);
    }

    /**
     * Set the Table Name
     * @return string
     */
    private function setTableName()
    {
        return $this->table = $this->collection->model->table;
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
    private function setFieldAttributes($fieldData)
    {
        $this->field = $fieldData->setAttributes($this->table, $this->field);
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
