<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{
    public static function sendMail($receiver, $text, $template,$subject)
    {
        try {
            $data = [
                "from" => "support@orange.com",
                "to" => [$receiver],
                "subject" => $subject,
                "text" => $text,
                "html" => $template,
                "attachement" => []
            ];
            $response = Http::withBody(json_encode($data),'application/json')
            ->post("".env('MAIL_URL')."mail");
            // info(" " . $response . "");
            return $response;

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['erros' => "erreur d'envoi du mail"]);
        }
    }
    public static function sendSms($receiver,$message)
    {
        try {
            $data = [
                "from" => "easyTTM",
                "to" =>  [$receiver],
                "message" => $message
            ];
            $response = Http::withBody(json_encode($data),'application/json'
            )->post("" .env('MAIL_URL'). "sms");
            return $response;


        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['erros' => "erreur d'envoi du SMS"]);
        }
    }
    
}
