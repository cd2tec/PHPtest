<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Rodrigo Ribeiro Franco">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="This template based on Bootstrap 5">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<title>Encontre o seu endereço</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body>
    <!-- Modal para o Endereço-->
	<div class="modal fade" id="modalEndereco" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="staticBackdropLabel">Endereço</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
		<table class="table table-bordered">
					<tbody>
						<tr>
						<td>CEP: </td>
						<td><?php echo $_POST['cep'] ?></td>
						</tr>
						<tr>
						<td>Logradouro: </td>
						<td><?php echo $_POST['logradouro'] ?></td>
						</tr>
						<tr>
						<td>Complemento:</td>
						<td><?php echo $_POST['complemento'] ?></td>
						</tr>
						<tr>
						<td>Bairro:</td>
						<td><?php echo $_POST['bairro'] ?></td>
						</tr>
						<tr>
						<td>Localidade:</td>
						<td><?php echo $_POST['localidade'] ?></td>
						</tr>
						<tr>
						<td>UF:</td>
						<td><?php echo $_POST['uf'] ?></td>
						</tr>
						<tr>
						<td>IBGE:</td>
						<td><?php echo $_POST['ibge'] ?></td>
						</tr>
						<tr>
						<td>GIA:</td>
						<td><?php echo $_POST['gia'] ?></td>
						</tr>
						<tr>
						<td>DDD:</td>
						<td><?php echo $_POST['ddd'] ?></td>
						</tr>
						<tr>
						<td>SIAFI:</td>
						<td><?php echo $_POST['siafi'] ?></td>
						</tr>
					</tbody>
				</table>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		</div>
		</div>
	</div>
	</div>

	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-5">
						<img src="img/logo-branca.png" alt="logo" width="100">
					</div>
					<div class="card shadow-lg">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4">CEP</h1>
							<form method="POST" action = "autenticar.php">
								<div class="mb-3">
									<input id="cep" type="number" class="form-control" name="cep" value="" required="required">
									
								</div>
									<button type="submit" class="btn btn-primary ms-auto">
										Pesquisar
									</button>
								</div>
							</form>
						</div>
						<?php
							//Caso a verificação for bem sucedida
							if( isset($_POST['verifica']) )
							{
							echo '<div class="card-footer py-3 border-0">';
							if($_POST['verifica'] == "sim"){
								echo '<div class="text-center">';
								echo '<button type="button" id="abrirModal" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEndereco">';
								echo 'Ver de novo';
								echo '</button>';
								echo '</div>';
								echo '</div>';
								
								echo '<script>document.getElementById("abrirModal").click();</script>';
							}else{
								echo '<div align = "center" class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-danger">';
								echo 'CEP inválido!'; //Mensagem de erro
								echo '</div>';
							   }
							}
						?>
					</div>
					
					<div class="text-center mt-5 text-muted">
						Copyright &copy; 2021 &mdash; Rodrigo Franco 
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
</html>
