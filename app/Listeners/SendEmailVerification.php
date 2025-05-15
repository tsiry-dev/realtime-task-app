<?php

namespace App\Listeners;

use App\Events\NewUserCreated;
use App\Mail\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailVerification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewUserCreated $event): void
    {
        //Attendre 5s pour envoyer l'email a l'utilisateur
        sleep(5);

        Mail::to($event->user->email)->send(new SendMail($event->user));
    }
}
