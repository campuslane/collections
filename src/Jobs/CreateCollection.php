<?php

namespace Cornernote\Collections\Jobs;

use App\Jobs\Job;
use Illuminate\Http\Request;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Cornernote\Collections\Models\Collection;

class CreateCollection extends Job implements SelfHandling
{

    use DispatchesJobs;

    /**
     * The Collection Name
     * @var string
     */
    protected $name;

    /**
     * The Collection Slug
     * @var string
     */
    protected $slug;

    /**
     * The Collection Instance
     * @var object
     */
    protected $collection;

    /**
     * The Default Field
     * @var array
     */
    protected $field;

    /**
     * Create a new job instance
     *
     * @return void
     */
    public function __construct($name, $slug)
    {
        $this->name = $name;
        $this->slug = $slug;
    }

    /**
     * Create the Collection
     * Inserts the collection record, writes the model file, adds the table 
     * to db, adds the initial name field to the table and returns the 
     * collection.
     *
     * @return Laravel Collection
     */
    public function handle()
    {
        $this->createCollectionRecord();
        $this->setDefaultField();
        $this->dispatch(new WriteModel($this->collection));
        $this->dispatch(new WriteTable($this->collection));
        $this->dispatch(new WriteField($this->collection, $this->field));

        return $this->collection;
    }

    /**
     * Create the Collection Record
     * @return laravel collection
     */
    private function createCollectionRecord()
    {
        return $this->collection = Collection::create(['name'=>$this->name, 'slug'=>$this->slug]);
    }

    /**
     * Set the Default Field for the Collection
     * We need to include a name/title type of field to list records
     * @return  array
     */
    private function setDefaultField()
    {
        return $this->field = [
            'name' => 'name', 
            'label' => 'Name', 
            'type' => 'string', 
        ];
    }
}
