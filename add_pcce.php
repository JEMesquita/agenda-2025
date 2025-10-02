<?php
include 'config.php';
$erro = "";
$sucesso = "";
if ($_POST) {
    $nome = trim($_POST['nome']);
    $setor = trim($_POST['setor']);
    $contato = trim($_POST['contato']);
    $email = trim($_POST['email']);
    try {
        $sql = "INSERT INTO pcce (nome, setor, contato, email) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $setor, $contato, $email]);
        $sucesso = 'PCCE cadastrado com sucesso!';
    } catch (Exception $e) {
        $erro = 'Erro ao cadastrar: ' . htmlspecialchars($e->getMessage());
    }
}

// Função de exclusão
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare('DELETE FROM pcce WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: add_pcce.php');
    exit;
}

// Função de edição
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $pdo->prepare('SELECT * FROM pcce WHERE id = ?');
    $stmt->execute([$id]);
    $editRow = $stmt->fetch();
}

if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $sigla = trim($_POST['sigla']);
    $local = trim($_POST['local']);
    $email = trim($_POST['email']);
    $contato = trim($_POST['contato']);
    $endereco = trim($_POST['endereco']);
    $stmt = $pdo->prepare('UPDATE pcce SET sigla = ?, local = ?, email = ?, contato = ?, endereco = ? WHERE id = ?');
    $stmt->execute([$sigla, $local, $email, $contato, $endereco, $id]);
    header('Location: add_pcce.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar PCCE</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Cadastrar Contatos da Polícia Civil de Ceará - PCCE</h2>
    <?php if (isset($editRow)): ?>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $editRow['id'] ?>">
        <label>Sigla:</label>
        <input name="sigla" required value="<?= htmlspecialchars($editRow['sigla']) ?>">
        <label>Local:</label>
        <input name="local" value="<?= htmlspecialchars($editRow['local']) ?>">
        <label>Email:</label>
        <input name="email" value="<?= htmlspecialchars($editRow['email']) ?>">
        <label>Contato:</label>
        <input name="contato" value="<?= htmlspecialchars($editRow['contato']) ?>">
        <label>Endereço:</label>
        <input name="endereco" value="<?= htmlspecialchars($editRow['endereco']) ?>">
        <button type="submit" name="update">Atualizar</button>
        <a href="add_pcce.php">Cancelar</a>
    </form>
    <?php else: ?>
    <form method="POST">
        <label>Sigla:</label>
        <input name="sigla" required>
        <label>Local:</label>
        <input name="local">
        <label>Email:</label>
        <input name="email">
        <label>Contato:</label>
        <input name="contato">
        <label>Endereço:</label>
        <input name="endereco">
        <button type="submit">Salvar</button>
    </form>
    <?php endif; ?>
    <?php if ($erro) echo '<div style="color:red">'.$erro.'</div>'; ?>
    <?php if ($sucesso) echo '<div style="color:green">'.$sucesso.'</div>'; ?>
    <hr>
    <h3>Lista de Contatos da PCCE</h3>
    <ul>
    <?php
    foreach ($pdo->query('SELECT * FROM pcce') as $row) {
        echo '<li>' . htmlspecialchars($row['sigla']) . ' | ' . htmlspecialchars($row['local']) . ' | ' . htmlspecialchars($row['email']) .' | ' . htmlspecialchars($row['contato']) .  ' | ' . htmlspecialchars($row['endereco']) . ' <a href="?edit=' . $row['id'] . '" style="color:blue">Editar</a> '
        . ' <a href="?delete=' . $row['id'] . '" style="color:red" onclick="return confirm(\'Confirma excluir este contato?\')">Excluir</a>';
        echo '</li>';
    }
    ?>
    </ul>
    <p><a href="home.php">⬅ Voltar</a></p>
</body>
</html>
