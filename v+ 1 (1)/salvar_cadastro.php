<?php
include "conexao.php";

$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$confirmSenha = $POST['confirmSenha'];

if ($senha !== $confirmSenha) {
    die("As senhas não coincidem. <a href='cadastro.php'>Voltar</a>");
}

// Criptografia senha
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

// Inserir no banco
$sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senhaHash')";

if ($conn->query($sql) === TRUE) {
    echo "Cadastro realizado com sucesso! <a href='login.php'>Fazer login</a>";
} else {
    echo "Erro: " . $conn->error;
}

$conn->close()
?>