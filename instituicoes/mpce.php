<?php
include '../config.php';
if ($_POST) {
    $nome = trim($_POST['nome']);
    $setor = trim($_POST['setor']);
    $contato = trim($_POST['contato']);
    $email = trim($_POST['email']);
    $sql = "INSERT INTO mpce (nome, setor, contato, email) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $setor, $contato, $email]);
    echo '<p>MPCE cadastrado!</p>';
}
?>
<h2>Cadastrar MPCE</h2>
<form method="POST">
    <input name="nome" placeholder="Nome" required><br>
    <input name="setor" placeholder="Setor"><br>
    <input name="contato" placeholder="Contato"><br>
    <input name="email" placeholder="Email"><br>
    <button type="submit">Salvar</button>
</form>
<hr>
<h3>Lista de MPCE</h3>
<ul>
<?php
foreach ($pdo->query('SELECT * FROM mpce') as $row) {
    echo '<li>' . htmlspecialchars($row['nome']) . ' - ' . htmlspecialchars($row['setor']) . '</li>';
}
?>
</ul>
