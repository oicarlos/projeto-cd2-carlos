<?php
	$servername="localhost";//Nome do servidor
	$username="root";//Usuário
	$pass="";//Senha
	$dbname="projeto_cd2";//Nome do BD
	$connect=mysqli_connect($servername,$username,$pass,$dbname);//Conexão com BD
	//Em caso de conexão malsucedida:
	if(mysqli_connect_error()){
		echo "Falha na conexão: ".mysqli_connect_error();
	}
?>