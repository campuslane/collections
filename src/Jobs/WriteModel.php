<?php

namespace Cornernote\Collections\Jobs;

use App\Jobs\Job;
use Illuminate\Http\Request;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Cornernote\Collections\Models\Collection;
use Cornernote\Collections\Services\Model\ModelData;
use Cornernote\Collections\Services\Utilities\FileWriter;


class WriteModel extends Job implements SelfHandling
{

    use DispatchesJobs;

    /**
     * The Collection Instance
     * @var object
     */
    protected $collection;

    /**
     * Model Data Instance
     * @var object
     */
    protected $modelData;

    /**
     * Model Attributes Array
     * @var array
     */
    protected $model;

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
    public function handle(ModelData $modelData, FileWriter $fileWriter)
    {
        $this->setDefaults();
        $this->getModelData($modelData);
        $this->writeModelFile($fileWriter);
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
            'path' => base_path('vendor/cornernote/collections/src/Generated/Models/'), 
            'namespace' => 'Cornernote\Collections\Generated\Models',
            'table_prefix' => 'c_',
            'guarded' => ['id'],
            'fillable' => [],
            'protected' => [],
            'rules' => ['name'=>'required'],

        ];
    }

    /**
     * Get the Model Data
     * We get an array of attributes from model data
     */
    private function getModelData($modelData)
    {
        return $this->model = $modelData->get($this->collection, $this->defaults);
    }


    /**
     * Write Model File
     */
    private function writeModelFile($fileWriter)
    {
        $stub = $this->defaults['modelStub'];
        $file = $this->model['file'];
        $this->model = $this->stringifyModelArrays($this->model);

        return $fileWriter->write($stub, $file, $this->model);
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
                $array[$key] = stringifyArray($value);
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
    // private function stringifyArray($array)
    // {
    //     $output = '[';

    //     foreach($array as $key => $value) {
    //         if(is_integer($key)) {
    //             $output .= "'" . $value . "', ";
    //         } else {
    //             $output .= "'".$key."'=>'" . $value . "', ";
    //         }
    //     }

    //     $output = trim($output, ', ');

    //     $output .= ']';

    //     return $output;
    // }
}
