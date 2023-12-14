<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class InfoController extends Controller
{
    public function send($notifiable, Notification $notification)
    {
        dd($notifiable);
        /*$message = $notification->toWhatsApp($notifiable);

        $to = $notifiable->routeNotificationFor('WhatsApp');
        $from = config('services.twilio.whatsapp_from');

        $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));


        return $twilio->messages->create('whatsapp:' . $to, [
            "from" => 'whatsapp:' . $from,
            "body" => $message->content
        ]);*/
    }
}
