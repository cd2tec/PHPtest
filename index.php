<?php
    
    $cep = $_POST['cep'];

    $mysqli = new mysqli("localhost", "root", "", "viacep");
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }

    $validacao = "SELECT * FROM enderecos_pesquisados WHERE cep = '$cep'";

    $teste = $mysqli->query($validacao);
    $temRegistros = mysqli_fetch_array($teste);

    if(empty($temRegistros)){

        $url = "viacep.com.br/ws/$cep/json/";
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        // $teste = file_put_contents('arquivo.xml', $response);
        
        $response = json_decode($response);
        $response = (object)$response;

        $query = "INSERT INTO enderecos_pesquisados (cep,logradouro,complemento,bairro,localidade,uf,ibge,gia,ddd,siafi) VALUES ('$response->cep','$response->logradouro','$response->complemento','$response->bairro','$response->localidade','$response->uf','$response->ibge','$response->gia','$response->ddd','$response->siafi')";

        $mysqli->query($query);

        return $response;
        // echo 'cep cadastrado com sucesso';
    }else{
        return $temRegistros;
        // echo 'cep ja cadastrado';
    }
?>