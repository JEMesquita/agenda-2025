<?php
include '../config.php';
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
<h2>Cadastrar Fórum</h2>
<a href="../home.php">Voltar ao início</a>
<form method="POST">
    <input name="nome" placeholder="Nome" required><br>
    <input name="comarca" placeholder="Comarca"><br>
    <input name="contato" placeholder="Contato"><br>
    <input name="email" placeholder="Email"><br>
    <button type="submit">Salvar</button>
</form>
<?php if ($erro) echo '<div style="color:red">'.$erro.'</div>'; ?>
<?php if ($sucesso) echo '<div style="color:green">'.$sucesso.'</div>'; ?>
<hr>
<h3>Lista de Fóruns</h3>
<ul>
<?php
foreach ($pdo->query('SELECT * FROM forum') as $row) {
    echo '<li>' . htmlspecialchars($row['nome']) . ' | Comarca: ' . htmlspecialchars($row['comarca']) . ' | ' . htmlspecialchars($row['contato']) . ' | ' . htmlspecialchars($row['email']) . '</li>';
}
?>
</ul>
