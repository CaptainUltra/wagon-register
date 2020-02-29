<?php

namespace App\Observers;

use App\Wagon;
use App\WagonType;
use Carbon\Carbon;

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
        $wagonTypeInstance = WagonType::where('name', $wagonType)->firstOrFail();
        $wagon->type_id = $wagonTypeInstance->id;

        $this->CalculateRevisionExpirationDate($wagon, $wagonTypeInstance);
    }

    /**
     * Handle the wagon "updating" event.
     *  Assign the propper wagon type id to the wagon that is being update.
     *
     * @param  \App\Wagon  $wagon
     * @return void
     */
    public function updating(Wagon $wagon)
    {
        $wagonType = substr($wagon->number, 4, 2).'-'.substr($wagon->number, 6, 2);
        $wagonTypeInstance = WagonType::where('name', $wagonType)->firstOrFail();
        $wagon->type_id = $wagonTypeInstance->id;
        
        $this->CalculateRevisionExpirationDate($wagon, $wagonTypeInstance);
    }
    private function CalculateRevisionExpirationDate(Wagon $wagon, WagonType $wagonType)
    {
        if($wagon->revision_date != null)
        {
            $timeToAdd = $wagonType->revision_valid_for;
            $revisionDate = $wagon->revision_date;
            $expirationDate = $revisionDate->addYears($timeToAdd);
            $wagon->revision_exp_date = $expirationDate;
        }
        else
        {
            $wagon->revision_exp_date = '';
        }
    }
}
