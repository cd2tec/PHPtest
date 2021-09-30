<?php
	require_once("conexao.php");
	@session_start();

    $cep = $_POST['cep'];
	$verifica = "sim";
	//Verificando o banco de dados
	$query = $pdo->query("SELECT * FROM endereco where cep = '$cep'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);

	if(@count($res) > 0){
		$logradouro = $res[0]['logradouro'];
		$complemento = $res[0]['complemento'];
		$bairro = $res[0]['bairro'];
		$localidade = $res[0]['localidade'];
		$uf = $res[0]['uf'];
		$ibge = $res[0]['ibge'];
		$gia = $res[0]['gia'];
		$ddd = $res[0]['ddd'];
		$siafi = $res[0]['siafi'];
	}else{
		$url = "https://viacep.com.br/ws/$cep/xml/";
            
		$xml = @simplexml_load_file($url);
		if ($xml == false) { //Verificando se o cep existe
			$logradouro = "";
			$complemento = "";
			$bairro = "";
			$localidade = "";
			$uf = "";
			$ibge = "";
			$gia = "";
			$ddd = "";
			$siafi = "";
			$verifica = "nao";
		}else{
			$logradouro = $xml->logradouro;
			$complemento = $xml->complemento;
			$bairro = $xml->bairro;
			$localidade = $xml->localidade;
			$uf = $xml->uf;
			$ibge = $xml->ibge;
			$gia = $xml->gia;
			$ddd = $xml->ddd;
			$siafi = $xml->siafi;
			$res2 = $pdo->prepare("INSERT INTO endereco SET cep = :cep, logradouro = :logradouro, complemento = :complemento, bairro = :bairro, localidade = :localidade, uf = :uf, ibge = :ibge, gia = :gia, ddd = :ddd, siafi = :siafi");	
		
			$res2->bindValue(":cep", $cep);
			$res2->bindValue(":logradouro", "$logradouro");
			$res2->bindValue(":complemento", $complemento);
			$res2->bindValue(":bairro", $bairro);
			$res2->bindValue(":localidade", $localidade);
			$res2->bindValue(":uf", $uf);
			$res2->bindValue(":ibge", $ibge);
			$res2->bindValue(":gia", $gia);
			$res2->bindValue(":ddd", $ddd);
			$res2->bindValue(":siafi", $siafi);
			$res2->execute();
		}
		
		
	}
?>
<form name="formulario" method ="POST" action ="index.php">
	<input type="hidden" value="<?php echo $cep ?>" name = "cep" id="cep"/>
	<input type="hidden" value="<?php echo $logradouro ?>" name = "logradouro" id="logradouro"/>
	<input type="hidden" value="<?php echo $complemento ?>" name = "complemento" id="complemento"/>
	<input type="hidden" value="<?php echo $bairro ?>" name = "bairro" id="bairro"/>
	<input type="hidden" value="<?php echo $localidade ?>" name = "localidade" id="localidade"/>
	<input type="hidden" value="<?php echo $uf ?>" name = "uf" id="uf"/>
	<input type="hidden" value="<?php echo $ibge ?>" name = "ibge" id="ibge"/>
	<input type="hidden" value="<?php echo $gia ?>" name = "gia" id="gia"/>
	<input type="hidden" value="<?php echo $ddd ?>" name = "ddd" id="ddd"/>
	<input type="hidden" value="<?php echo $siafi ?>" name = "siafi" id="siafi"/>
	<input type="hidden" value="<?php echo $verifica ?>" name = "verifica" id="verifica"/>
	<button type="submit" name = "btn-voltar" id="btn-voltar"></button>
</form>


<script type="text/javascript">
	document.getElementById("btn-voltar").click(); 
</script>