<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class SoapClientHelper
{
        //
        private $url;

        public function __construct()
        {
            $this->url = env('ldap_url');
        }
    
        public function postXmlRequest($xml)
        {
            $response=Http::withBody($xml,'Content-Type: text/xml')->post($this->url);
            return $response;
        }
    
        public function getXmlRequest($xml){
            $response = Http::withBody($xml,'Content-Type: text/xml')->get($this->url);
            return $response;
        }
    
}