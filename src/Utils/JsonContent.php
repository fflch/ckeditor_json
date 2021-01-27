<?php

namespace Drupal\ckeditor_json\Utils;


use Symfony\Component\HttpClient\HttpClient;

class JsonContent
{
    public static function itens(){
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://www.breakingbadapi.com/api/characters?abc');
        #$response = $httpClient->request('GET', 'https://www.breakingbadapi.com/api/characters/1');
        //$response->getStatusCode();
        $itens = json_decode($response->getContent());
        return $itens;
    }
}