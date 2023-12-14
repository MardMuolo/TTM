<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SendSmsController extends NotificationController
{
    public static function to_sysAdmin()
    {
        NotificationController::sendSms("0844297349", env('to_sysAdmin'));
        return true;
    }
    public static function to_ttmOfficer()
    {
        NotificationController::sendSms("0844297349", env('to_ttmOfficher'));
        return true;
    }
    public static function to_contributeur($receiver)
    {
        NotificationController::sendSms("0844297349", env('to_contributeur'));
        return true;
    }
    public static function to_directeur($receiver)
    {
        NotificationController::sendSms("0844297349", env('to_directeur_App'));
        return true;
    }
    public static function to_sponsor($receiver)
    {
        NotificationController::sendSms("0843185472", env('to_sponsor'));
        return true;
    }
    public static function to_projectOwner($receiver)
    {
        NotificationController::sendSms("0844297349", env('to_projectOwner'));
        return true;
    }
}
