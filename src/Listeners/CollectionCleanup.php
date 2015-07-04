<?php

namespace Cornernote\Collections\Listeners;

use DB;
use File;
use Schema;
use Cornernote\Collections\Models\Model;
use Cornernote\Collections\Events\CollectionDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Collection Cleanup 
 * When we delete a collection, we need to clean up 
 * by deleting its related model, fields, database table, 
 * and model file.
 */

class CollectionCleanup
{

    /**
     * The Collection Id
     * @var integer
     */
    protected $id;

    /**
     * The Model Record
     * @var laravel collection item
     */
    protected $model;


    /**
     * Handle the event.
     *
     * @param  CollectionDeleted  $event
     * @return void
     */
    public function handle(CollectionDeleted $event)
    {
        $this->id = $event->collectionId;

        $this->getModel();
        $this->deleteModelFile();
        $this->deleteTable();
        $this->deleteRelatedModel();
        $this->deleteRelatedFields();
    }

    /**
     * Get Model
     * @return [type] [description]
     */
    private function getModel()
    {
        return $this->model = Model::where('collection_id', $this->id)->first();
    }

    /**
     * Delete Model File
     * @return boolean
     */
    private function deleteModelFile()
    {
        if (File::exists($this->model->file)) {
            return File::delete($this->model->file);
        }

        return false;
    }

    /**
     * Delete Table
     * @return boolean
     */
    private function deleteTable()
    {
        if (Schema::hasTable($this->model->table)) {
            return Schema::drop($this->model->table);
        }

        return false;
    }

    /**
     * Delete Related Model
     * @return boolean
     */
    private function deleteRelatedModel()
    {
        return $this->model->delete();
    }

    /**
     * Delete Related Fields
     * @return boolean
     */
    private function deleteRelatedFields()
    {
        return DB::table('fields')->where('collection_id', $this->id)->delete();
    }
}