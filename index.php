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

        $url = "viacep.com.br/ws/$cep/xml/";
        
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

        if(!empty($response)){
            $xml = simplexml_load_string($response);
            $json = json_encode($xml);
            $response = json_decode($json,TRUE);
        }
        
        // $teste = file_put_contents('arquivo.xml', $response);
        
        // $response = json_decode($response);
        $response = (object)$response;
        if(isset($response->erro)){

            $linha = "<tr class='table-active'>
                        <td colspan='10' text-align='center'><b>CEP inválido, por favor digite um CEP válido </b><td>
                    </tr>";
        }else{
            if(empty($response->complemento)){
                $complemento = '';
            }else{
                $complemento = $response->complemento;
            }
            if(empty($response->gia)){
                $gia = '';
            }else{
                $gia = $response->gia;
            }
            $linha = "
                <tr class='table-active'>
                    <td>$response->cep</td>
                    <td>$response->logradouro</td>
                    <td>$complemento</td>
                    <td>$response->bairro</td>
                    <td>$response->localidade</td>
                    <td>$response->uf</td>
                    <td>$response->ibge</td>
                    <td>$gia</td>
                    <td>$response->ddd</td>
                    <td>$response->siafi</td>
                </tr>                
            ";

            $query = "INSERT INTO enderecos_pesquisados (cep,logradouro,complemento,bairro,localidade,uf,ibge,gia,ddd,siafi) VALUES ('$response->cep','$response->logradouro','$complemento','$response->bairro','$response->localidade','$response->uf','$response->ibge','$gia','$response->ddd','$response->siafi')";
            
            $mysqli->query($query);
        }



    }else{
        $temRegistros = (object)$temRegistros;
        $linha = "
            <tr class='table-active'>
                <td>$temRegistros->cep</td>
                <td>$temRegistros->logradouro</td>
                <td>$temRegistros->complemento</td>
                <td>$temRegistros->bairro</td>
                <td>$temRegistros->localidade</td>
                <td>$temRegistros->uf</td>
                <td>$temRegistros->ibge</td>
                <td>$temRegistros->gia</td>
                <td>$temRegistros->ddd</td>
                <td>$temRegistros->siafi</td>
            </tr>                
        ";
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>PHP Test</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/navbar-fixed/">



    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="index.css" rel="stylesheet">
</head>

<body>

    <div id="container">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled"></a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="hidden" placeholder="Search" aria-label="">
                </form>
            </div>
        </div>
    </nav>
    <main class="container">
        <div class="bg-light p-5 rounded">
            <div id="container">
                <!-- <div class="row gy-2 gx-3 align-items-center"> -->
                    <!-- <div class="col-lg-8"> -->
                        <form method="POST" action="index.php">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="cep" class="visually-hidden">CEP</label>
                                    <input type="text" class="form-control" id="cep" name="cep" placeholder="Digite o CEP"
                                        maxlength="9">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 row-md-3">
                                    <input type="submit" id="pesquisar" class="btn btn-primary mb-3" value="Pesquisar">
                                </div>
                            </div>
                        </form>
                    <!-- </div> -->
                <!-- </div> -->
            </div>
        </div>

        <table class="table table-striped">
            <thead>
                <th>cep</th>
                <th>logradouro</th>
                <th>complemento</th>
                <th>bairro</th>
                <th>localidade</th>
                <th>uf</th>
                <th>ibge</th>
                <th>gia</th>
                <th>ddd</th>
                <th>siafi</th>
            </thead>
            <tbody>
                <?php
                    echo $linha;
                ?>
            </tbody>
        </table>
    </main>

    <script type="text/javascript">
        const inputValue = document.querySelector("#cep");
        let cep = "";

        inputValue.addEventListener("keyup", () => {
            cep = inputValue.value;
            if (cep) {
                if (cep.length === 8) {
                    inputValue.value = `${cep.substr(0, 5)}-${cep.substr(5, 9)}`;
                    console.log(cep);
                }
            }
        });
    </script>
</body>

</html>