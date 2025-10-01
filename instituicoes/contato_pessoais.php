<?php
include '../config.php';
$erro = "";
$sucesso = "";
if ($_POST) {
    $nome = trim($_POST['nome']);
    $telefone = trim($_POST['telefone']);
    $email = trim($_POST['email']);
    $observacao = trim($_POST['observacao']);
    try {
        $sql = "INSERT INTO contato_pessoais (nome, telefone, email, observacao) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $telefone, $email, $observacao]);
        $sucesso = 'Contato pessoal cadastrado com sucesso!';
    } catch (Exception $e) {
        $erro = 'Erro ao cadastrar: ' . htmlspecialchars($e->getMessage());
    }
}
?>
<h2>Cadastrar Contato Pessoal</h2>
<a href="../home.php">Voltar ao início</a>
<form method="POST">
    <input name="nome" placeholder="Nome" required><br>
    <input name="telefone" placeholder="Telefone"><br>
    <input name="email" placeholder="Email"><br>
    <input name="observacao" placeholder="Observação"><br>
    <button type="submit">Salvar</button>
</form>
<?php if ($erro) echo '<div style="color:red">'.$erro.'</div>'; ?>
<?php if ($sucesso) echo '<div style="color:green">'.$sucesso.'</div>'; ?>
<hr>
<h3>Lista de Contatos Pessoais</h3>
<ul>
<?php
foreach ($pdo->query('SELECT * FROM contato_pessoais') as $row) {
    echo '<li>' . htmlspecialchars($row['nome']) . ' | Tel: ' . htmlspecialchars($row['telefone']) . ' | ' . htmlspecialchars($row['email']) . ' | ' . htmlspecialchars($row['observacao']) . '</li>';
}
?>
</ul>
