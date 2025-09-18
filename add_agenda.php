<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';

$erro = "";
$sucesso = "";
/* Verifica se o ID da vara foi fornecido 

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido.");
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM varas WHERE id = ?");
$stmt->execute([$id]);
$vara = $stmt->fetch();

if (!$vara) {
    die("Vara não encontrada.");
}
*/

if ($_POST) {
    $nome = trim($_POST['nome_vara']);
    $contato = trim($_POST['contato']);
    $email = trim($_POST['email']);
    $endereco = trim($_POST['endereco']);
    $link = trim($_POST['link_balcao']);

    if (empty($nome)) {
        $erro = "O nome da vara é obrigatório.";
        /*echo "<p style='color:red;'>❌ O nome da vara é obrigatório.</p>";*/
    } else {
        try {
            $sql = "INSERT INTO varas (nome_vara, contato, email, endereco, link_balcao) VALUES (?, ?, ?, ?, ?)";
            /*$sql = "UPDATE varas SET nome_vara = ?, contato = ?, email = ?, endereco = ?, link_balcao = ? WHERE id = ?";*/
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $contato, $email, $endereco, $link, $id]);
            echo "<p style='color:green;'>✅ Vara atualizada com sucesso!</p>";
            echo "<script>setTimeout(() => { window.parent.location.reload(); }, 1500);</script>";
            exit;
        } catch (Exception $e) {
            echo "<p style='color:red;'>❌ Erro ao atualizar: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Contatos - Agenda TJCE</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>➕ Adicionar Novo Contato</h2>
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
    <div>
    <label>Nome da Comarca ou Vara:</label>
    <input type="text" name="nome_vara" required value="<?= htmlspecialchars($vara['nome_vara']) ?>" style="width:100%; padding:8px; margin:5px 0;">

    <label>Contato:</label>
    <textarea name="contato" rows="3" style="width:100%; padding:8px; margin:5px 0; resize: vertical;"><?= htmlspecialchars($vara['contato'] ?? '') ?></textarea>

    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($vara['email'] ?? '') ?>" style="width:100%; padding:8px; margin:5px 0;">

    <label>Endereço:</label>
    <textarea name="endereco" rows="3" style="width:100%; padding:8px; margin:5px 0; resize: vertical;"><?= htmlspecialchars($vara['endereco'] ?? '') ?></textarea>

    <label>Link do Balcão Virtual:</label>
    <input type="url" name="link_balcao" value="<?= htmlspecialchars($vara['link_balcao'] ?? '') ?>" style="width:100%; padding:8px; margin:5px 0;">

    <div style="text-align: right; margin-top: 20px;">
        <button type="button" onclick="window.parent.closeModal()" style="background: #666; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px;">Cancelar</button>
        <button type="submit" style="background: #008000; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">💾 Salvar Alterações</button>
    </div>
</form>
</div>
</body>
</html>