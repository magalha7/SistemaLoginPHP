<!--
Created by: Ítalo Magalhães da Silva
E-mail: italo.ufsj@gmail.com
-->

<?php

session_start();
//remove seção do usuário
unset($_SESSION['id'], $_SESSION['nome'], $_SESSION['email'],$_SESSION['face_access_token']);

$_SESSION['msg'] = "<div class='alert alert-success'>Deslogado com sucesso!</div>";
header("Location: login.php");