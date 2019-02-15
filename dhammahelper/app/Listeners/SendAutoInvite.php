<?php

namespace App\Listeners;

use App\Models\User;
use Carbon\Carbon;
use App\Notification;

use Illuminate\Auth\Events\Registered;

class SendAutoInvite
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login $event
     * @return void
     */
    public function handle(Registered $event)
    {
        // Update user last login date/time
        $friendID = $event->user->id;

        $senderID = 1;

        $notification = new Notification;
        $notification->user_id = $friendID;
        $notification->requester = $senderID;
        $notification->type = 'friend request';
        $notification->resolved = false;
        $notification->save();

    }
}