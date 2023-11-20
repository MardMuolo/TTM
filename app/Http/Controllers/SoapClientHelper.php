<?php

namespace App\Helpers;

class SoapClientHelper
{
    private $client;

    public function __construct()
    {

        $url =  env('ldap_url');

        $this->client = new \SoapClient($url, [
            // 'cache_url' => url_CACHE_NONE,
            'trace' => true,
        ]);
    }

    public function getDataFromSoapApi()
    {
        try {
            // Appeler une méthode de l'API SOAP
            $response = $this->client->getData();

            return $response;
        } catch (\SoapFault $e) {
            
            return null;
        }
    }
}