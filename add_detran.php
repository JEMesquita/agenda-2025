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
        $sql = "INSERT INTO detran (nome, setor, contato, email) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $setor, $contato, $email]);
        $sucesso = 'Detran cadastrado com sucesso!';
    } catch (Exception $e) {
        $erro = 'Erro ao cadastrar: ' . htmlspecialchars($e->getMessage());
    }
}

// Função de exclusão
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare('DELETE FROM detran WHERE id = ?');
    $stmt->execute([$id]);
    header('Location: add_detran.php');
    exit;
}

// Função de edição
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = $pdo->prepare('SELECT * FROM detran WHERE id = ?');
    $stmt->execute([$id]);
    $editRow = $stmt->fetch();
}

if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $nome = trim($_POST['nome']);
    $setor = trim($_POST['setor']);
    $contato = trim($_POST['contato']);
    $email = trim($_POST['email']);
    $stmt = $pdo->prepare('UPDATE detran SET nome = ?, setor = ?, contato = ?, email = ? WHERE id = ?');
    $stmt->execute([$nome, $setor, $contato, $email, $id]);
    header('Location: add_detran.php');
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Cadastrar Detran</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Cadastrar Detran</h2>
        <?php if (isset($editRow)): ?>
            <form method="POST">
                <input type="hidden" name="id" value="<?= $editRow['id'] ?>">
                <label>Nome:</label>
                <input name="nome" required value="<?= htmlspecialchars($editRow['nome']) ?>">
                <label>Setor:</label>
                <input name="setor" value="<?= htmlspecialchars($editRow['setor']) ?>">
                <label>Contato:</label>
                <input name="contato" value="<?= htmlspecialchars($editRow['contato']) ?>">
                <label>Email:</label>
                <input name="email" value="<?= htmlspecialchars($editRow['email']) ?>">
            </form>
            <button type="submit" name="insert">Salvar</button>
            <button type="submit" name="update">Atualizar</button>
            <button type="submit" name="delete">Delete</button>
            <a href="add_detran.php">Cancelar</a>
        <?php else: ?>
            <form method="POST">
                <label>Nome:</label>
                <input name="nome" required>
                <label>Setor:</label>
                <input name="setor">
                <label>Contato:</label>
                <input name="contato">
                <label>Email:</label>
                <input name="email">
            </form>
            <button type="submit" name="insert">Salvar</button>
            <button type="submit" name="update">Atualizar</button>
            <button type="submit" name="delete">Delete</button>
        <?php endif; ?>
        <?php if ($erro) echo '<div style="color:red">' . $erro . '</div>'; ?>
        <?php if ($sucesso) echo '<div style="color:green">' . $sucesso . '</div>'; ?>
        <hr>
        <h3>Lista de Contatos do Detran</h3>
        <ul>
            <?php
            foreach ($pdo->query('SELECT * FROM detran') as $row) {
                echo '<li>' . htmlspecialchars($row['nome']) . ' | ' . htmlspecialchars($row['setor']) . ' | ' . htmlspecialchars($row['contato']) . ' | ' . htmlspecialchars($row['email']) .
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