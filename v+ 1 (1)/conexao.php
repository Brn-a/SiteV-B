<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "viagem";

//Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

//Verificar
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>