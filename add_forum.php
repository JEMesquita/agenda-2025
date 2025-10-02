<?php
include 'config.php';
$erro = "";
$sucesso = "";
// Função de exclusão
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare('DELETE FROM forum WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: add_forum.php');
    exit;
}

// Função de edição
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $pdo->prepare('SELECT * FROM forum WHERE id = ?');
    $stmt->execute([$id]);
    $editRow = $stmt->fetch();
}

if ($_POST) {
    $nome = trim($_POST['nome']);
    $comarca = trim($_POST['comarca']);
    $contato = trim($_POST['contato']);
    $email = trim($_POST['email']);
    try {
        if (isset($editRow)) {
            $id = (int)$_POST['id'];
            $stmt = $pdo->prepare('UPDATE forum SET nome = ?, comarca = ?, contato = ?, email = ? WHERE id = ?');
            $stmt->execute([$nome, $comarca, $contato, $email, $id]);
            $sucesso = 'Fórum atualizado com sucesso!';
        } else {
            $sql = "INSERT INTO forum (nome, comarca, contato, email) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $comarca, $contato, $email]);
            $sucesso = 'Fórum cadastrado com sucesso!';
        }
    } catch (Exception $e) {
        $erro = 'Erro ao cadastrar/atualizar: ' . htmlspecialchars($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Fórum</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Cadastrar Fórum</h2>
    <?php if (isset($editRow)): ?>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $editRow['id'] ?>">
        <label>Nome:</label>
        <input name="nome" required value="<?= htmlspecialchars($editRow['nome']) ?>">
        <label>Comarca:</label>
        <input name="comarca" value="<?= htmlspecialchars($editRow['comarca']) ?>">
        <label>Contato:</label>
        <input name="contato" value="<?= htmlspecialchars($editRow['contato']) ?>">
        <label>Email:</label>
        <input name="email" value="<?= htmlspecialchars($editRow['email']) ?>">
        <button type="submit" name="update">Atualizar</button>
        <a href="add_forum.php">Cancelar</a>
    </form>
    <?php else: ?>
    <form method="POST">
        <label>Nome:</label>
        <input name="nome" required>
        <label>Comarca:</label>
        <input name="comarca">
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
    <h3>Lista de Contatos dos Fóruns - TJCE</h3>
    <ul>
    <?php
    foreach ($pdo->query('SELECT * FROM forum') as $row) {
        echo '<li>' . htmlspecialchars($row['nome']) . ' | ' . htmlspecialchars($row['comarca']) . ' | ' . htmlspecialchars($row['contato']) . ' | ' . htmlspecialchars($row['email']) . 
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
