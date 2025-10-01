<?php
include '../config.php';
$erro = "";
$sucesso = "";
if ($_POST) {
    $nome = trim($_POST['nome']);
    $oab = trim($_POST['oab']);
    $contato = trim($_POST['contato']);
    $email = trim($_POST['email']);
    $instituicao = trim($_POST['instituicao']);
    try {
        $sql = "INSERT INTO advogados (nome, oab, contato, email, instituicao) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $oab, $contato, $email, $instituicao]);
        $sucesso = 'Advogado cadastrado com sucesso!';
    } catch (Exception $e) {
        $erro = 'Erro ao cadastrar: ' . htmlspecialchars($e->getMessage());
    }
}
?>
<h2>Cadastrar Advogado</h2>
<a href="../home.php">Voltar ao início</a>
<form method="POST">
    <input name="nome" placeholder="Nome" required><br>
    <input name="oab" placeholder="OAB"><br>
    <input name="contato" placeholder="Contato"><br>
    <input name="email" placeholder="Email"><br>
    <select name="instituicao" required>
        <option value="OAB">OAB</option>
        <option value="TJCE">TJCE</option>
        <option value="MPCE">MPCE</option>
        <option value="Outros">Outros</option>
    </select><br>
    <button type="submit">Salvar</button>
</form>
<?php if ($erro) echo '<div style="color:red">'.$erro.'</div>'; ?>
<?php if ($sucesso) echo '<div style="color:green">'.$sucesso.'</div>'; ?>
<hr>
<h3>Lista de Advogados</h3>
<ul>
<?php
foreach ($pdo->query('SELECT * FROM advogados') as $row) {
    echo '<li>' . htmlspecialchars($row['nome']) . ' | OAB: ' . htmlspecialchars($row['oab']) . ' | ' . htmlspecialchars($row['instituicao']) . ' | ' . htmlspecialchars($row['contato']) . ' | ' . htmlspecialchars($row['email']) . '</li>';
}
?>
</ul>
