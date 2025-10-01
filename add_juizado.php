<?php
include 'config.php';
$erro = "";
$sucesso = "";
if ($_POST) {
    $nome = trim($_POST['nome']);
    $contato = trim($_POST['contato']);
    $email = trim($_POST['email']);
    try {
        $sql = "INSERT INTO juizados (nome, contato, email) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $contato, $email]);
        $sucesso = 'Juizado cadastrado com sucesso!';
    } catch (Exception $e) {
        $erro = 'Erro ao cadastrar: ' . htmlspecialchars($e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Juizado</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Cadastrar Juizado</h2>
    <form method="POST">
        <label>Nome:</label>
        <input name="nome" required>
        <label>Contato:</label>
        <input name="contato">
        <label>Email:</label>
        <input name="email">
        <button type="submit">Salvar</button>
    </form>
    <?php if ($erro) echo '<div style="color:red">'.$erro.'</div>'; ?>
    <?php if ($sucesso) echo '<div style="color:green">'.$sucesso.'</div>'; ?>
    <hr>
    <h3>Lista de Juizados</h3>
    <ul>
    <?php
    foreach ($pdo->query('SELECT * FROM juizados') as $row) {
        echo '<li>' . htmlspecialchars($row['nome']) . ' | ' . htmlspecialchars($row['contato']) . ' | ' . htmlspecialchars($row['email']) . '</li>';
    }
    ?>
    </ul>
    <a href="home.php">Voltar ao início</a>
</div>
</body>
</html>
