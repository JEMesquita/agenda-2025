<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';

$erro = "";
$sucesso = "";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido.");
}

$id = (int)$_GET['id'];

// Buscar vara
$stmt = $pdo->prepare("SELECT * FROM varas WHERE id = ?");
$stmt->execute([$id]);
$vara = $stmt->fetch();

if (!$vara) {
    die("Vara não encontrada.");
}

if ($_POST) {
    $nome = trim($_POST['nome_vara']);
    $contato = trim($_POST['contato']);
    $email = trim($_POST['email']);
    $endereco = trim($_POST['endereco']);
    $link = trim($_POST['link_balcao']);

    if (empty($nome)) {
        $erro = "O nome da vara é obrigatório.";
    } else {
        try {
            $sql = "UPDATE varas SET nome_vara = ?, contato = ?, email = ?, endereco = ?, link_balcao = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $contato, $email, $endereco, $link, $id]);

            $sucesso = "Vara atualizada com sucesso!";
        } catch (Exception $e) {
            $erro = "Erro ao atualizar: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Alterar Contato - Agenda TJCE</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>✏️ Alterar Nome da Vara ou Comarca</h2>
        <p><a href="dashboard.php">⬅ Voltar ao Dashboard</a></p>

        <?php if ($erro): ?>
            <div style="background-color: #ffe6e6; color: #cc0000; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <strong>Erro:</strong> <?= htmlspecialchars($erro) ?>
            </div>
        <?php endif; ?>

        <?php if ($sucesso): ?>
            <div style="background-color: #e6ffe6; color: #006600; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <strong>Sucesso:</strong> <?= htmlspecialchars($sucesso) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label>Nome da Vara ou Comarca:</label>
            <input type="text" name="nome_vara" required value="<?= htmlspecialchars($vara['nome_vara']) ?>">

            <label>Contato:</label>
            <textarea name="contato" rows="3" style="resize: vertical;"><?= htmlspecialchars($vara['contato'] ?? '') ?></textarea>

            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($vara['email'] ?? '') ?>">

            <label>Endereço:</label>
            <textarea name="endereco" rows="3" style="resize: vertical;"><?= htmlspecialchars($vara['endereco'] ?? '') ?></textarea>

            <label>Link do Balcão Virtual:</label>
            <input type="url" name="link_balcao" value="<?= htmlspecialchars($vara['link_balcao'] ?? '') ?>">

            <button type="submit">💾 Salvar Alterações</button>
        </form>