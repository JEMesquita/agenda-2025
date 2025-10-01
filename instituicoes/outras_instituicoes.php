<?php
include '../config.php';
if ($_POST) {
    $nome = trim($_POST['nome']);
    $tipo = trim($_POST['tipo']);
    $contato = trim($_POST['contato']);
    $email = trim($_POST['email']);
    $sql = "INSERT INTO outras_instituicoes (nome, tipo, contato, email) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $tipo, $contato, $email]);
    echo '<p>Instituição cadastrada!</p>';
}
?>
<h2>Cadastrar Outra Instituição</h2>
<form method="POST">
    <input name="nome" placeholder="Nome" required><br>
    <input name="tipo" placeholder="Tipo"><br>
    <input name="contato" placeholder="Contato"><br>
    <input name="email" placeholder="Email"><br>
    <button type="submit">Salvar</button>
</form>
<hr>
<h3>Lista de Outras Instituições</h3>
<ul>
<?php
foreach ($pdo->query('SELECT * FROM outras_instituicoes') as $row) {
    echo '<li>' . htmlspecialchars($row['nome']) . ' - ' . htmlspecialchars($row['tipo']) . '</li>';
}
?>
</ul>
