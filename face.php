<!--
Created by: Ítalo Magalhães da Silva
E-mail: italo.ufsj@gmail.com
-->

<?php 
//inicia a seção
session_start();
//unset($_SESSION['face_access_token']);
require_once 'lib/Facebook/autoload.php';
include_once 'conexao.php';

//instanciando a classe do Facebook
$fb = new \Facebook\Facebook([
  'app_id' => '{app-id}',
  'app_secret' => '{app-secret}',
  'default_graph_version' => 'v2.9',
  //'default_access_token' => '{access-token}', // optional
]);

//instanciando o método
$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions ex: profile, photo

//tenta encontrar uma sessão já aberta
try {
	if(isset($_SESSION['face_access_token'])){
		$accessToken = $_SESSION['face_access_token']; //recupera o token
	}else{
		$accessToken = $helper->getAccessToken(); //senão ele cria o token
	}
	
} catch(Facebook\Exceptions\FacebookResponseException $e) {
	// When Graph returns an error 
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}

//Verifica existencia do token em uma seção aberta

if (! isset($accessToken)) {  //caso não exista

	$url_login = 'http://localhost/SistemaLoginPHP/face.php';
	$loginUrl = $helper->getLoginUrl($url_login, $permissions);

}else{ //se existir

	$url_login = 'http://localhost/SistemaLoginPHP/face.php';
	$loginUrl = $helper->getLoginUrl($url_login, $permissions);
	
	//Verifica se Usuário ja é autenticado nesta seção
	if(isset($_SESSION['face_access_token'])){
		$fb->setDefaultAccessToken($_SESSION['face_access_token']);

	}//Usuário não está autenticado nesta seção
	else{
		$_SESSION['face_access_token'] = (string) $accessToken;
		$oAuth2Client = $fb->getOAuth2Client();
		$_SESSION['face_access_token'] = (string) $oAuth2Client->getLongLivedAccessToken($_SESSION['face_access_token']);
		$fb->setDefaultAccessToken($_SESSION['face_access_token']);	
	}
	
	try {
		// Returns a `Facebook\FacebookResponse` object
		$response = $fb->get('/me?fields=name, picture, email');
		$user = $response->getGraphUser();
		//Valida o usuário
		$result_usuario = "SELECT id, nome, email FROM usuarios WHERE email='".$user['email']."' LIMIT 1";
		$resultado_usuario = mysqli_query($conn, $result_usuario);
		if($resultado_usuario){
			$row_usuario = mysqli_fetch_assoc($resultado_usuario);
			$_SESSION['id'] = $row_usuario['id'];
			$_SESSION['nome'] = $row_usuario['nome'];
			$_SESSION['email'] = $row_usuario['email'];
			header("Location: administrativo.php");			
		}
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
	}
}

?>
