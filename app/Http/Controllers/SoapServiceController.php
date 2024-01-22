<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SoapServiceController extends Controller
{
    //
    private $url_ldap;
    private $url_otp;

    private $url_otp_check;

    public function __construct()
    {
        $this->url_ldap = env('LDAP_URL');
        $this->url_otp = env('OTP_URL');
        $this->url_otp_check = env('OTP_CHECK');
    }

    public function postXmlRequest($xml)
    {
        $response=Http::withBody($xml,'Content-Type: text/xml')->post($this->url_ldap);
        return $response;
    }

    public function getXmlRequest($xml){
        $response = Http::withBody($xml,'Content-Type: text/xml')->get($this->url_ldap);
        return $response;
    }

    
    public function postJsonRequest($body)
    {
        
        $response=Http::withBody($body)->post($this->url_otp);
        return json_decode($response);
    }

    public function postJsonCheckOtp($body)
    {
        
        $response=Http::withBody($body)->post($this->url_otp_check);
        return json_decode($response);
    }
}
