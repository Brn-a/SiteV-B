<?php
// finalizando.php
// Se você tiver sessão com dados do carrinho, pode recuperar o valor real aqui.
// Exemplo simples: $valor_compra = $_SESSION['valor_total'] ?? 2787.00;
$valor_compra = 2787.00;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Finalizar Reserva - V+</title>
  <style>
    body { font-family: Arial, sans-serif; background:#f2f2f2; padding:20px; }
    h2 { text-align:center; }
    form { background:#fff; padding:30px; max-width:500px; margin:0 auto; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1); }
    label{display:block; margin-top:15px; font-weight:bold;}
    input, select { width:100%; padding:10px; margin-top:5px; border-radius:5px; border:1px solid #ccc; }
    .hidden{display:none;}
    .pix-code{background:#e0e0e0; padding:10px; font-family:monospace; border-radius:5px; margin-top:10px;}
    button{margin-top:25px; width:100%; padding:12px; background:#ffcc00; border:none; border-radius:8px; font-size:16px; font-weight:bold; cursor:pointer;}
    .milhas { margin-top:12px; font-weight:bold; color: #006600; }
  </style>
</head>
<body>
  <h2>Finalizar Reserva</h2>

  <form id="finalizaForm" method="post" action="process_milhas.php">
    <label for="nome">Nome Completo:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="cpf">CPF:</label>
    <input type="text" id="cpf" name="cpf" required>

    <label for="pagamento">Forma de Pagamento:</label>
    <select id="pagamento" name="pagamento" onchange="atualizarPagamento()" required>
      <option value="">Selecione</option>
      <option value="debito">Cartão de Débito</option>
      <option value="credito">Cartão de Crédito</option>
      <option value="boleto">Boleto Bancário</option>
      <option value="pix">Pix</option>
    </select>

    <div id="dados-cartao" class="hidden">
      <label for="titular">Nome do Titular:</label>
      <input type="text" id="titular" name="titular">
      <label for="numero">Número do Cartão:</label>
      <input type="text" id="numero" name="numero">
      <label for="validade">Validade:</label>
      <input type="text" id="validade" name="validade" placeholder="MM/AA">
      <label for="codigo">Código de Segurança:</label>
      <input type="text" id="codigo" name="codigo">
    </div>

    <div id="parcelamento" class="hidden">
      <label for="opcao-parcela">Parcelamento:</label>
      <select id="opcao-parcela" name="opcao_parcela">
        <option value="1x">1x de R$ <?php echo number_format($valor_compra,2,',','.'); ?> (sem juros)</option>
        <option value="6x">6x de R$ <?php echo number_format($valor_compra/6,2,',','.'); ?></option>
        <option value="12x">12x de R$ <?php echo number_format($valor_compra/12,2,',','.'); ?></option>
      </select>
    </div>

    <div id="pix-info" class="hidden">
      <label>Código Pix:</label>
      <div class="pix-code" id="codigoPix">carregando...</div>
    </div>

    <!-- valor da compra (envia ao servidor) -->
    <input type="hidden" name="valor_compra" value="<?php echo htmlspecialchars($valor_compra); ?>">

    <button type="submit">Confirmar Pagamento</button>

    <div id="milhasBox" class="milhas hidden">Você ganhará <span id="proximoMilhas"></span> milhas nesta compra.</div>
  </form>

  <script>
    function atualizarPagamento() {
      const tipo = document.getElementById("pagamento").value;
      const cartao = document.getElementById("dados-cartao");
      const parcela = document.getElementById("parcelamento");
      const pix = document.getElementById("pix-info");
      const codigoPix = document.getElementById("codigoPix");

      cartao.classList.add("hidden");
      parcela.classList.add("hidden");
      pix.classList.add("hidden");

      if (tipo === "debito") {
        cartao.classList.remove("hidden");
      } else if (tipo === "credito") {
        cartao.classList.remove("hidden");
        parcela.classList.remove("hidden");
      } else if (tipo === "pix") {
        pix.classList.remove("hidden");
        const codigo = "pix_" + Math.random().toString(36).substring(2, 12).toUpperCase();
        codigoPix.textContent = codigo;
      }

      // mostra quantas milhas o usuário ganhará (1 milha a cada R$10)
      const valorCompra = parseFloat(document.querySelector('input[name="valor_compra"]').value) || 0;
      const milhas = Math.floor(valorCompra / 10);
      document.getElementById("proximoMilhas").textContent = milhas;
      document.getElementById("milhasBox").classList.remove("hidden");
    }

    // calcula milhas ao carregar a página
    atualizarPagamento();
  </script>
</body>
</html>
