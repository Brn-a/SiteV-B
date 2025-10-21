<?php
// process_milhas.php
require_once 'conexao.php'; // ajuste o nome se for diferente

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: finalizando.php");
    exit;
}

// pegar e limpar dados (sem usar ?? para compatibilidade)
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$cpf  = isset($_POST['cpf']) ? preg_replace('/\D/', '', $_POST['cpf']) : ''; // remove tudo que nao é numero
$valor_compra = isset($_POST['valor_compra']) ? floatval(str_replace(',', '.', $_POST['valor_compra'])) : 0;

// validações simples
if (!$nome || !$cpf || $valor_compra <= 0) {
    die("Dados inválidos. Verifique Nome, CPF e valor da compra.");
}

// lógica de cálculo de milhas (exemplo: 1 milha a cada R$10)
$multiplicador = 10; // R$ 10 por milha
$milhas_ganhas = (int) floor($valor_compra / $multiplicador);

// inicia transação para segurança
$conn->begin_transaction();

try {
    // checar se já existe registro para esse CPF
    $sql = "SELECT id, saldo FROM tb_milhas WHERE cpf = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows === 1) {
        // atualiza saldo existente
        $row = $res->fetch_assoc();
        $novo_saldo = $row['saldo'] + $milhas_ganhas;

        $upd = $conn->prepare("UPDATE tb_milhas SET saldo = ?, nome = ?, atualizado = NOW() WHERE id = ?");
        $upd->bind_param("isi", $novo_saldo, $nome, $row['id']);
        $upd->execute();
    } else {
        // cria novo registro
        $novo_saldo = $milhas_ganhas;
        $ins = $conn->prepare("INSERT INTO tb_milhas (cpf, nome, saldo) VALUES (?, ?, ?)");
        $ins->bind_param("ssi", $cpf, $nome, $novo_saldo);
        $ins->execute();
    }

    $conn->commit();
    ?>
    <!doctype html>
    <html lang="pt-br">
    <head>
      <meta charset="utf-8">
      <title>Milhas - Confirmação</title>
      <style>
        body{font-family:Arial; background:#f2f2f2; padding:30px}
        .box{max-width:600px; margin:0 auto; background:#fff; padding:20px; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1)}
        .ok{color:green; font-weight:bold}
        .btn{display:inline-block; margin-top:12px; padding:10px 16px; background:#4CAF50; color:#fff; border-radius:6px; text-decoration:none}
      </style>
    </head>
    <body>
      <div class="box">
        <h2>Pagamento confirmado</h2>
        <p class="ok">✅ Pagamento confirmado! Obrigado, <?php echo htmlspecialchars($nome); ?>.</p>
        <p>Valor da compra: R$ <?php echo number_format($valor_compra,2,',','.'); ?></p>
        <p>Milhas ganhas nesta compra: <strong><?php echo $milhas_ganhas; ?></strong></p>
        <p>Seu novo saldo de milhas: <strong><?php echo $novo_saldo; ?></strong></p>
        <a class="btn" href="finalizando.php">Voltar</a>
      </div>
    </body>
    </html>
    <?php

} catch (Exception $e) {
    $conn->rollback();
    die("Erro ao processar milhas: " . $e->getMessage());
}
?>
