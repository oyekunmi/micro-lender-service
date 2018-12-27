<?php

namespace App\Listeners;

use App\Events\UserCreated;

class AttachRole
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
//        die($event->request->name);
    }
}
