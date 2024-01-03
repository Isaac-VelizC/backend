<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class InfoController extends Controller
{
    /*public function send($notifiable, Notification $notification)
    {
        dd($notifiable);
        $message = $notification->toWhatsApp($notifiable);

        $to = $notifiable->routeNotificationFor('WhatsApp');
        $from = config('services.twilio.whatsapp_from');

        $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));


        return $twilio->messages->create('whatsapp:' . $to, [
            "from" => 'whatsapp:' . $from,
            "body" => $message->content
        ]);
    }*/
    public function sendWhatsAppMessage()
    {
        //+591 74245921
        //
        $recipientNumber = 'whatsapp:+59169625120'; // Replace with the recipient's phone number in WhatsApp format (e.g., "whatsapp:+59169625120")
        $message = "Hello, Issac";

        $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));

        try {
            $twilio->messages->create(
                $recipientNumber,
                [
                    "from" => "whatsapp:+14155238886",
                    "body" => $message,
                ]
            );
            dd('enviado correctamente');
            return response()->json(['message' => 'WhatsApp message sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
