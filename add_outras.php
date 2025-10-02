<?php
include 'config.php';
$erro = "";
$sucesso = "";
if ($_POST) {
    $nome = trim($_POST['nome']);
    $tipo = trim($_POST['tipo']);
    $contato = trim($_POST['contato']);
    $email = trim($_POST['email']);
    try {
        $sql = "INSERT INTO outras_instituicoes (nome, tipo, contato, email) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $tipo, $contato, $email]);
        $sucesso = 'Instituição cadastrada com sucesso!';
    } catch (Exception $e) {
        $erro = 'Erro ao cadastrar: ' . htmlspecialchars($e->getMessage());
    }
}

// Função de exclusão
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare('DELETE FROM outras_instituicoes WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: add_outras.php');
    exit;
}

// Função de edição
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $pdo->prepare('SELECT * FROM outras_instituicoes WHERE id = ?');
    $stmt->execute([$id]);
    $editRow = $stmt->fetch();
}

if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $nome = trim($_POST['nome']);
    $tipo = trim($_POST['tipo']);
    $contato = trim($_POST['contato']);
    $email = trim($_POST['email']);
    $stmt = $pdo->prepare('UPDATE outras_instituicoes SET nome = ?, tipo = ?, contato = ?, email = ? WHERE id = ?');
    $stmt->execute([$nome, $tipo, $contato, $email, $id]);
    header('Location: add_outras.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Outra Instituição</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Cadastrar Outra Instituição</h2>
    <?php if (isset($editRow)): ?>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $editRow['id'] ?>">
        <label>Nome:</label>
        <input name="nome" required value="<?= htmlspecialchars($editRow['nome']) ?>">
        <label>Tipo:</label>
        <input name="tipo" value="<?= htmlspecialchars($editRow['tipo']) ?>">
        <label>Contato:</label>
        <input name="contato" value="<?= htmlspecialchars($editRow['contato']) ?>">
        <label>Email:</label>
        <input name="email" value="<?= htmlspecialchars($editRow['email']) ?>">
        <button type="submit" name="update">Atualizar</button>
        <a href="add_outras.php">Cancelar</a>
    </form>
    <?php else: ?>
    <form method="POST">
        <label>Nome:</label>
        <input name="nome" required>
        <label>Tipo:</label>
        <input name="tipo">
        <label>Contato:</label>
        <input name="contato">
        <label>Email:</label>
        <input name="email">
        <button type="submit">Salvar</button>
    </form>
    <?php endif; ?>
    <?php if ($erro) echo '<div style="color:red">'.$erro.'</div>'; ?>
    <?php if ($sucesso) echo '<div style="color:green">'.$sucesso.'</div>'; ?>
    <hr>
    <h3>Lista de Outras Instituições</h3>
    <ul>
    <?php
    foreach ($pdo->query('SELECT * FROM outras_instituicoes') as $row) {
        echo '<li>' . htmlspecialchars($row['nome']) . ' | ' . htmlspecialchars($row['tipo']) . ' | ' . htmlspecialchars($row['contato']) . ' | ' . htmlspecialchars($row['email']) . 
        ' <a href="?edit=' . $row['id'] . '" style="color:blue">Editar</a> ' 
        . ' <a href="?delete=' . $row['id'] . '" style="color:red" onclick="return confirm(\'Confirma excluir este contato?\')">Excluir</a>';
        echo '</li>';
    }
    ?>
    </ul>
    <p><a href="home.php">⬅ Voltar</a></p>
</div>
</body>
</html>
