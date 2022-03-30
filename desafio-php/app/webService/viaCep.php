<?php

namespace App\WebService;

class ViaCep{

   /*  consultando cep no via service
    recebe string
    retorna array */
    public static function consultarCep($cep)
    {
        // configura curl
        $curl = curl_init();
        curl_setopt_array($curl,[
            CURLOPT_URL => 'https://viacep.com.br/ws/'.$cep.'/xml/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST=>'GET'
        ]);

        // reponse
        $responseXml = curl_exec($curl);
        // fecha conexao curl
        curl_close($curl);
        // convertendo xml para um array
        $responseXml = simplexml_load_string($responseXml);
        $responseJson = json_encode($responseXml);
        $array = json_decode ($responseJson,TRUE);
        
        // retorando conteudo e ja tratando erro
        return isset($array['cep']) ? $array : null;
    }
}