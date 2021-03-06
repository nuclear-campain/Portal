<?php

namespace App\Observers;

use App\Models\Notation;
use App\Notifications\Monitor\NotationNotification;
use Illuminate\Support\Facades\Notification;

/**
 * Class NotationObserver
 *
 * @package App\Observers
 */
class NotationObserver
{
    /**
     * Handle the notation "created" event.
     *
     * @param  Notation  $notation The notation entity that has been created in the storage.
     * @return void
     */
    public function created(Notation $notation): void
    {
        $user = auth()->user();
        $notation->author()->associate($user)->save();

        if ($notation->status) { // The status = public. So send out notifications.
            $when = now()->addMinute();
            $city = $notation->city;

            Notification::send($city->followers()->where('id', '!=', auth()->user()->id)->get(), new NotationNotification($notation));
        }
    }
}
