<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';

if ($_POST) {
    $nome = trim($_POST['nome']);
    $contato = trim($_POST['contato']);
    $email = trim($_POST['email']);
    $endereco = trim($_POST['endereco']);
    $tipo = 'Advogado'; // Define o tipo

    if (empty($nome)) {
        $erro = "O nome é obrigatório.";
    } else {
        try {
            $sql = "INSERT INTO varas (nome_completo, contato, email, endereco, link_balcao) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $contato, $email, $endereco, $tipo]);
            $_SESSION['mensagem'] = "Advogado cadastrado com sucesso!";
            header("Location: home.php");
            exit;
        } catch (Exception $e) {
            $erro = "Erro ao cadastrar: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Advogado - Agenda 2025</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>⚖️ Cadastrar Novo Advogado</h2>
        <p><a href="home.php">⬅ Voltar</a></p>

        <?php if (isset($erro)): ?>
            <div style="background-color: #ffe6e6; color: #cc0000; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <strong>Erro:</strong> <?= htmlspecialchars($erro) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label>Nome Completo:</label>
            <input type="text" name="nome" required>

            <label>OAB:</label>
            <input type="text" name="oab" required>

            <label>Contato (Telefone, WhatsApp, etc.):</label>
            <textarea name="contato" rows="3"></textarea>

            <label>E-mail:</label>
            <input type="email" name="email">

            <label>Associação:</label>
            <input type="associacao" name="associacao">

            <label>Endereço:</label>
            <textarea name="endereco" rows="3"></textarea>

            <button type="submit">💾 Salvar</button>
        </form>
    </div>
</body>
</html>