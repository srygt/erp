<?php

namespace App\Http\Controllers;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use App\Http\Controllers\EarsivFaturaOlustur;

class FaturaGonder extends Controller
{
    private $guzzle;
    public function __construct()
    {
        $this->guzzle =  new Client();
    }

    public  function suFaturasiGonder(){

        $endpoint ='*';
        $xml= new EarsivFaturaOlustur();
        $xmlveri =$xml->suFaturasiOlustur();
        $head=[
            'Accept' => '*',
            'username' => '*',
            'password' => '*'

        ];
        $data = [

              'AppType'=>1,
              'DocumentXml'=> $xmlveri

        ];


        $response = $this->guzzle->post($endpoint,[
            'headers' => $head,
            'json' => $data,
        ]);

        return $response->getBody();


    }
}
