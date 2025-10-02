<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';

if ($_POST) {
    $nome = trim($_POST['nome'] ?? '');
    $oab = trim($_POST['oab'] ?? '');
    $contato = trim($_POST['contato'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $associacao = trim($_POST['associacao'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');

    if (empty($nome)) {
        $erro = "O nome é obrigatório.";
    } else {
        try {
            $sql = "INSERT INTO advogados (nome_completo, oab, contato, email, associacao, endereco) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $oab, $contato, $email, $associacao, $endereco]);
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
        <h2>⚖️ Cadastrar Contato Advogado</h2>
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

            <label>Telefone, WhatsApp:</label>
            <input type="text" name="contato">

            <label>E-mail:</label>
            <input type="email" name="email">

            <label>Associação:</label>
            <input type="text" name="associacao"> <!-- CORRIGIDO -->

            <label>Endereço:</label>
            <textarea name="endereco" rows="3"></textarea>
        </form>
        <button type="submit">💾 Salvar</button>
        <button type="submit" name="update">Atualizar</button>
        <button type="submit" name="delete">Delete</button>
        <p><a href="home.php">⬅ Voltar</a></p>
    </div>
</body>
</html>