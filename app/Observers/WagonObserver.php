<?php

namespace App\Observers;

use App\Wagon;
use App\WagonType;

class WagonObserver
{
    /**
     * Handle the wagon "creating" event.
     * Assign the propper wagon type id to the wagon that is being created.
     *
     * @param  \App\Wagon  $wagon
     * @return void
     */
    public function creating(Wagon $wagon)
    {
        $wagonType = substr($wagon->number, 4, 2).'-'.substr($wagon->number, 6, 2);
        $wagon->type_id = WagonType::where('name', $wagonType)->firstOrFail()->id;
    }

    /**
     * Handle the wagon "updating" event.
     *
     * @param  \App\Wagon  $wagon
     * @return void
     */
    public function updating(Wagon $wagon)
    {
        $wagonType = substr($wagon->number, 4, 2).'-'.substr($wagon->number, 6, 2);
        $wagon->type_id = WagonType::where('name', $wagonType)->firstOrFail()->id;
    }

    /**
     * Handle the wagon "deleted" event.
     *
     * @param  \App\Wagon  $wagon
     * @return void
     */
    public function deleted(Wagon $wagon)
    {
        //
    }

    /**
     * Handle the wagon "restored" event.
     *
     * @param  \App\Wagon  $wagon
     * @return void
     */
    public function restored(Wagon $wagon)
    {
        //
    }

    /**
     * Handle the wagon "force deleted" event.
     *
     * @param  \App\Wagon  $wagon
     * @return void
     */
    public function forceDeleted(Wagon $wagon)
    {
        //
    }
}
