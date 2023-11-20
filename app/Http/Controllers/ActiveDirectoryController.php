<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class ActiveDirectoryController extends Controller
{
    //
    protected static $startPoint = 'http://10.143.41.70:8000/promo2/odcapi/';
    public static function getData($url){
        try {
            $response = Http::get($url);
            $response = json_decode($response->body());

            return $response;

        } catch (Exception) {
            throw ValidationException::withMessages(["server_error" => 'Server not working']);
        }
    }

    public static function postData($url, array $data){
        try {
            $response = Http::post($url, $data);
            $response = json_decode($response->body());

            return $response;

        } catch (Exception) {
            throw ValidationException::withMessages(["server_error" => 'Server not working']);
        }
    }
    public static function loginFromAd($username, $password){
        return ActiveDirectoryController::postData(ActiveDirectoryController::$startPoint.'?method=login',[
            'username'=>$username,
            'password'=>$password
        ]);
    }

    public static function getUsers(){
        return ActiveDirectoryController::getData(ActiveDirectoryController::$startPoint.'?method=getUsers');
    }

    public static function getUserByEmail(string $email){
        return ActiveDirectoryController::getData(ActiveDirectoryController::$startPoint.'?method=getUserByEmail&email='.$email);
    }

    public static function getUserByUsername(string $username){
        return ActiveDirectoryController::getData(ActiveDirectoryController::$startPoint.'?method=getUserByUsername&username='.$username);
    }
}
