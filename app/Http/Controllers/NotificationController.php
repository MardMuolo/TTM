<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{
    public function sendMail($receiver, $text, $template, $attachement,$subject)
    {
        try {
            $data = [
                "from" => "support@orange.com",
                "to" => config('app.support_contact_mail'),
                "subject" => $subject,
                "text" => $text,
                "html" => $template,
                "attachement" => []
            ];
            $response = Http::withBody(json_encode($data),'application/json')
            ->post("" . config('app.send_alert_url') . "mail");
            // info("Send error alert mail response: " . $response . "");

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['erros' => "erreur d'envoi du mail"]);
        }
    }
    public function sendSms($receiver,$message)
    {
        try {
            $data = [
                "from" => "easyTTM",
                "to" =>  $receiver,
                "message" => $message
            ];
            $response = Http::withBody(json_encode($data),'application/json'
            )->post("" .  config('app.send_alert_url') . "sms");

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['erros' => "erreur d'envoi du SMS"]);
        }
    }
    
}
