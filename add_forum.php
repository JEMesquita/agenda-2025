<?php
include 'config.php';
$erro = "";
$sucesso = "";
if ($_POST) {
    $nome = trim($_POST['nome']);
    $comarca = trim($_POST['comarca']);
    $contato = trim($_POST['contato']);
    $email = trim($_POST['email']);
    try {
        $sql = "INSERT INTO forum (nome, comarca, contato, email) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $comarca, $contato, $email]);
        $sucesso = 'Fórum cadastrado com sucesso!';
    } catch (Exception $e) {
        $erro = 'Erro ao cadastrar: ' . htmlspecialchars($e->getMessage());
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
    <?php if ($erro) echo '<div style="color:red">'.$erro.'</div>'; ?>
    <?php if ($sucesso) echo '<div style="color:green">'.$sucesso.'</div>'; ?>
    <hr>
    <h3>Lista de Fóruns</h3>
    <ul>
    <?php
    foreach ($pdo->query('SELECT * FROM forum') as $row) {
        echo '<li>' . htmlspecialchars($row['nome']) . ' | ' . htmlspecialchars($row['comarca']) . ' | ' . htmlspecialchars($row['contato']) . ' | ' . htmlspecialchars($row['email']) . '</li>';
    }
    ?>
    </ul>
    <a href="home.php">Voltar ao início</a>
</div>
</body>
</html>
