<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="cadastro.css">
    <title>Cadastro</title>
</head>
<body>
    <form method="POST" action="salvar_cadastro.php">
        <h1><b>CADASTRO</b></h1>
        <fieldset>
            <legend>Informações Pessoais</legend>
 
            <label for="nome">Nome completo:</label><br>
            <input type="text" id="nome" name="nome" size="30" maxlength="60"><br>
 
            <label for="endereco">Endereço:</label><br>
            <input type="text" id="endereco" name="endereco" size="30" maxlength="20"><br>
 
            <label for="email">E-mail:</label><br>
            <input type="email" id="email" name="email" size="30" maxlength="60"><br>
 
            <label for="telefone">Telefone:</label><br>
            <input type="text" id="telefone" name="telefone" size="30" maxlength="9"><br>
 
            <label for="nascimento">Data de nascimento:</label><br>
            <input type="date" id="nascimento" name="nascimento"><br>
 
            <label for="cpf">CPF:</label><br>
            <input type="text" id="cpf" name="cpf" size="30" maxlength="11"><br>
 
            <label for="password">Senha:</label><br>
            <input type="password" id="password" name="senha"><br>
 
            <label for="confirmSenha">Confirme a senha:</label><br>
            <input type="password" id="confirmSenha" name="confirmSenha"><br><br>
 
            <a href="#" class="btn" onclick="validarCadastro()">Entrar</a>
        
            <button type="submit">Cadastrar</button>
        </fieldset>
    </form>
</body>
</html>
 
