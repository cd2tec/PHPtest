<?php

require __DIR__ . '/vendor/autoload.php';

// dependencias do projeto
use  \App\WebService\ViaCep;

if(!isset($argv[1])){
    die("CEP não definido\n");
}

// consutlta
$dados = ViaCep::consultarCep($argv[1]);

// imprime
print_r($dados);