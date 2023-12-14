<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SendMailController extends NotificationController
{
    public function to_sysAdmin()
    {
        $users = User::all();
        foreach ($users as $user) {
            foreach ($user->roles as $is_admin) {
                if ($is_admin->name == env('AdminSys')) {
                    $this->sendMail($user->email, "Bonjour", "<del>hello admin </del>", "Access request");
                }
            }
        }
        return true;
    }
    public function to_ttmOfficer()
    {
        $users = User::all();
        foreach ($users as $user) {
            foreach ($user->roles as $is_admin) {
                if ($is_admin->name == env('TtmOfficer')) {
                    $this->sendMail($user->email, "Bonjour", "<del>hello admin </del>", "Access request");
                }
            }

            return true;
        }
    }
    public function to_contributeur($receiver, $text, $template)
    {
        $response = $this->sendMail($receiver, $text, $template,env('to_contributeur'));

        return $response;
    }
    public function to_directeur($receiver, $text, $template)
    {
        $response = $this->sendMail($receiver, $text, $template,env('to_directeur_App'));

        return $response;
    }
    public function to_sponsor($receiver, $text, $template)
    {
        $response = $this->sendMail($receiver, $text, $template,env('to_sponsor'));

        return $response;
    }
    public function to_projectOwner($receiver, $text, $template)
    {
        $response = $this->sendMail($receiver, $text, $template,env('to_projectOwner'));

        return $response;
    }
}
