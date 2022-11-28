<?php

// Cette page permet de se connecter à la base de donnée
$engine = "mysql";
$host = "localhost";
$port = 8889;
$dbname = "forum";
$username = "root";
$password = "root";
$pdo = new PDO("$engine:host=$host:$port;dbname=$dbname", $username, $password);

?>
