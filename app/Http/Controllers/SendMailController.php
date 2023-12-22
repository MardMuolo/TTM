<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;

class SendMailController extends NotificationController
{
    public static function to_sysAdmin()
    {
        $users = User::all();
        foreach ($users as $user) {
            foreach ($user->roles as $is_admin) {
                if ($is_admin->name == env('AdminSys')) {
                    NotificationController::sendMail($user->email, "Bonjour", "<del>hello admin </del>", "Access request");
                }
            }
        }
        return true;
    }
    public static function to_ttmOfficer()
    {
        $users = User::all();
        foreach ($users as $user) {
            foreach ($user->roles as $is_admin) {
                if ($is_admin->name == env('TtmOfficer')) {
                    NotificationController::sendMail($user->email, "Bonjour", "<del>hello admin </del>", "Access request");
                }
            }

            return true;
        }
    }
    public static function to_contributeur($receiver, $text, $template)
    {
        $response = NotificationController::sendMail($receiver, $text, $template,env('sub_contributeur'));

        return $response;
    }
    public static function to_directeur($receiver, $text, $template)
    {
        $response = NotificationController::sendMail($receiver, $text, $template,env('sub_directeur_App'));

        return $response;
    }
    public static function to_sponsor($receiver, $text, $template)
    {
        $response = NotificationController::sendMail($receiver, $text, $template,env('sub_sponsor'));

        return $response;
    }
    public static function to_projectOwner($receiver, Project $text)
    {
        $msg="
        <h2>nom du projet <br/>".$text->name."</h2><br/>
        <h5>OptionTT du projet <br/>".$text->target." <span>".$text->score."</span></h5><br/>
        <h5>type <br/>".$text->type."</h5><br/>
        <p>Sponsor du projet <br/>".$text->nom."</p><br/><hr/>
        <p>Descriptiom<br/> </p><br/>
        $text->nom
        ";
        $response = NotificationController::sendMail($receiver, $text, $msg,env('sub_projectOwner'));

        return $response;
    }
}
