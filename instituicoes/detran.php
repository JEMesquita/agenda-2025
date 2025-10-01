<?php
include '../config.php';
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
?>
<h2>Cadastrar Detran</h2>
<a href="../home.php">Voltar ao início</a>
<form method="POST">
    <input name="nome" placeholder="Nome" required><br>
    <input name="setor" placeholder="Setor"><br>
    <input name="contato" placeholder="Contato"><br>
    <input name="email" placeholder="Email"><br>
    <button type="submit">Salvar</button>
</form>
<?php if ($erro) echo '<div style="color:red">'.$erro.'</div>'; ?>
<?php if ($sucesso) echo '<div style="color:green">'.$sucesso.'</div>'; ?>
<hr>
<h3>Lista de Detran</h3>
<ul>
<?php
foreach ($pdo->query('SELECT * FROM detran') as $row) {
    echo '<li>' . htmlspecialchars($row['nome']) . ' | Setor: ' . htmlspecialchars($row['setor']) . ' | ' . htmlspecialchars($row['contato']) . ' | ' . htmlspecialchars($row['email']) . '</li>';
}
?>
</ul>
