<?php
session_start();
include "conexao.php";

$email = $_POST['email'];
$senha = $_POST['senha'];

//Buscar usuario
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();

    if (password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario'] = $usuario['nome'];
        echo "Login realizado com sucesso! Bem vindo, " . $_SESSION['usuario'] . ".";
        // Exemplo: redirecionar para a página inicial
        // header("Location: index.php");
    } else {
        echo "Senha incorreta. <a href='login.php'>Tentar novamente</a>";
    }
} else {
    echo "Usuario não encontrado. <a href='cadastro.php'>Cadastrar</a>";
}
    
$conn->close();
?>
