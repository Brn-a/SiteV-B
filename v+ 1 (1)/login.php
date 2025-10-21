<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="main">
        <form method="POST" action="validar_login.php">
            <fieldset id="border_form">
                <legend>Login</legend>
 
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
 
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" required><br><br>
 
                <button type="submit">Entrar</button>
            </fieldset>
        </form>
    </div>
</body>
</html>
