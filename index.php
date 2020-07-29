<?php
	require_once 'db_connect.php';//Chamando arquivo que faz conexão com o BD
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>Consultar CEP</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
		<link rel="stylesheet" href="style.css"><!--Chamando arquivo de estilo CSS-->
	</head>
	<body>
		<div class="header">
			<nav class="navbar navbar-light">
				<span class="navbar-brand mb-0 h1">
					<figure class="figure">
						<img src="bracep.png" class="logo figure-img img-fluid rounded">
						<figcaption class="figure-caption text-white">Consulte CEPs de todo o Brasil</figcaption>
					</figure>
				</span>
			</nav>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-sm">
					<p class="lead"><strong>Preencha o campo com o CEP a ser consultado.</strong></p>
					<form name="form" method="POST" onSubmit="return validation();">
						<div class="form-group">
							<label>CEP:</label>
							<input id="cep" class="form-control w-25" placeholder="CEP" name="cep" onkeyup="mask();" autocomplete="off" onkeypress="return number();">
							<small class="form-text text-muted">Insira números apenas.</small>
							<button type="submit" name="submit" class="btn btn-primary">Consultar</button>
						</div>
					</form>
				</div>
				<div id="result_consult" class="col-sm <?php if(isset($_POST['submit'])){echo "border-left";} ?>"><!--Colocando border-left depois de processar formulário para separar visualmente-->
					<?php
						if(isset($_POST['submit'])){
							$cep=$_POST['cep'];
							$url="https://viacep.com.br/ws/$cep/xml";//Consultando CEP no VIACEP
							$xml=simplexml_load_file($url) or die("Erro: sem êxito ao consultar XML.");//Interpretando o arquivo XML
							echo "<p class=\"lead\"><strong>Resultado da consulta do CEP ".$_POST['cep'].":</strong></p>";
							//Verificando se o CEP existe:
							if($xml->erro=="true"){
								echo "<p class=\"text-danger\">CEP inexistente</p>";
							}else{
								//Consultando/Adicionando CEP no BD:
								$sql="SELECT cep FROM table_cep WHERE cep='$cep'";//Código SQL para selecionar campo da tabela
								$result=mysqli_query($connect,$sql);//Aplicando consulta no BD
								if(mysqli_num_rows($result)!=0){
									echo "<p class=\"text-primary\">CEP já consultado, tente outro.</p>";
								}else{
									$sql="INSERT INTO table_cep (cep) VALUES ('$cep')";//Código SQL para inserir valor na tabela
									mysqli_query($connect,$sql);//Aplicando consulta no BD
									//Mostrando resultados:
									echo "Logradouro: ".$xml->logradouro."<br><hr>";
									if($xml->complemento==""){
										echo "Complemento: Em Branco<br><hr>";
									}else{
										echo "Complemento: ".$xml->complemento."<br><hr>";
									}
									echo "Bairro: ".$xml->bairro."<br><hr>";
									echo "Cidade: ".$xml->localidade."<br><hr>";
									echo "Estado: ".$xml->uf."<br><hr>";
									if($xml->unidade==""){
										echo "Unidade: Em Branco <br><hr>";
									}else{
										echo "Unidade: ".$xml->unidade."<br><hr>";
									}
									echo "IBGE: ".$xml->ibge."<br><hr>";
									if($xml->gia==""){
										echo "Gia: Em Branco";
									}else{
										echo "Gia: ".$xml->gia;
									}
								}
							}
						}
					?>
				</div>
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
		<script src="script.js"></script><!--Incluindo JavaScript-->
	</body>
</html>