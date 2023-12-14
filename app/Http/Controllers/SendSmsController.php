<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SendSmsController extends NotificationController
{
    public function to_sysAdmin()
    {
        $this->sendSms("0844297349", env('to_sysAdmin'));
        return true;
    }
    public function to_ttmOfficer()
    {
        $this->sendSms("0844297349", env('to_ttmOfficher'));
        return true;
    }
    public function to_contributeur($receiver)
    {
        $this->sendSms("0844297349", env('to_contributeur'));
        return true;
    }
    public function to_directeur($receiver)
    {
        $this->sendSms("0844297349", env('to_directeur_App'));
        return true;
    }
    public function to_sponsor($receiver)
    {
        $this->sendSms("0844297349", env('to_sponsor'));
        return true;
    }
    public function to_projectOwner($receiver)
    {
        $this->sendSms("0844297349", env('to_projectOwner'));
        return true;
    }
}
