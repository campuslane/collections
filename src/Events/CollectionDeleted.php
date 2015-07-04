<?php

namespace Cornernote\Collections\Events;

use Cornernote\Collections\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Collection Deleted Event
 * When we delete a collection record, we also 
 * need to clean up by deleting its related model, 
 * fields, database table, and model file.  This
 * Event triggers the CollectionCleanup listener.
 */

class CollectionDeleted extends Event
{
    use SerializesModels;

    /**
     * The Deleted Collection Id
     * @var integer
     */
    public $collectionId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($collectionId)
    {
        $this->collectionId = $collectionId;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}