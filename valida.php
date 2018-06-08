<!--
Created by: Ítalo Magalhães da Silva
E-mail: italo.ufsj@gmail.com
-->

<?php
//inicia seção
session_start();
//inclui conexão somente uma vez
include_once("conexao.php");
//pega o click do botão "Acessar"
$btnLogin = filter_input(INPUT_POST, 'btnLogin', FILTER_SANITIZE_STRING);

//Se existir o click 
if($btnLogin){
	//recebe o usuário e a senha digitados pelo usuário na tela "login.php"
	$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
	$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
	
	//verifica se o usuário não esqueceu de digitar seu usuário e sua senha 
	if((!empty($usuario)) AND (!empty($senha))){
	
		//Pesquisar o usuário no BD
		$result_usuario = "SELECT id, nome, email, senha FROM usuarios WHERE usuario='$usuario' LIMIT 1";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		if($resultado_usuario){
			$row_usuario = mysqli_fetch_assoc($resultado_usuario);
			if(password_verify($senha, $row_usuario['senha'])){
				$_SESSION['id'] = $row_usuario['id'];
				$_SESSION['nome'] = $row_usuario['nome'];
				$_SESSION['email'] = $row_usuario['email'];
				/*Se as informações(nome de usuario e senha) digitados conscidirem com o usuário já cadastrado no banco chama o painel administrativo para esse usuário*/ 
				header("Location: administrativo.php");
			}else{
				/*Caso as informações nao concidem com as armazenadas no banco de dados*/
				$_SESSION['msg'] = "<div class='alert alert-danger'>Login ou senha incorreto!</div>";
				header("Location: login.php");
			}
		}
	}else{
		$_SESSION['msg'] = "<div class='alert alert-danger'>Login ou senha incorreto!</div>";
		header("Location: login.php");
	}
}else{
	//caso não haja clique no botão
	$_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada</div>";
	header("Location: login.php");
}
