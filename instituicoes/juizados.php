<?php
include '../config.php';
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
<h2>Cadastrar Juizado</h2>
<a href="../home.php">Voltar ao início</a>
<form method="POST">
    <input name="nome" placeholder="Nome" required><br>
    <input name="contato" placeholder="Contato"><br>
    <input name="email" placeholder="Email"><br>
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
