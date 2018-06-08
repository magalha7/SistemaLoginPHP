# SistemaLoginPHP

Para testa-lo você deve possuir um servidor Apache Ex: Xampp,wampp etc

Clone o repositório, extrai-o e cole dentro do seu servidor Apache. Caso seja Xampp cole na pasta "htdocs" e caso seja Wampp cole na pasta "www"

Feito isto abra em seu navegador o phpMyAdmin Ex: https://localhost/phpmyadmin e crie um database com nome "sistemaLogin", ou a da forma que desejar. Importe o arquivo "sistemaLogin.sql"

Feito isto você poderá usar o sistema. Basta acessar seu navegador e digitar https://localhost/SistemaLogin_PHP/login.php

OBS: Caso deseja utilizar o login pelo facebook vá até o arquivo "face.php" é nas linhas onde aparecer.

'app_id' => '{app-id}', 'app_secret' => '{app-secret}'

troque pela chave de id da sua aplicação e pela chave secreta criada em https://developers.facebook.com/
