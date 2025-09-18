<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['perfil'] !== 'Administrador' && $_SESSION['perfil'] !== 'Suporte') {
    die("Acesso negado.");
}

include 'config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido.");
}

$id = (int)$_GET['id'];

// Buscar usuário
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch();

if (!$usuario) {
    die("Usuário não encontrado.");
}

// Verificar permissão de edição
if ($_SESSION['perfil'] == 'Administrador') {
    if ($usuario['perfil'] !== 'Usuario') {
        die("Você não tem permissão para editar este perfil.");
    }
}

$erro = "";
$sucesso = "";

if ($_POST) {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $perfil = $_POST['perfil'];

    // Administrador não pode alterar perfil para Suporte/Desenvolvimento
    if ($_SESSION['perfil'] == 'Administrador' && ($perfil == 'Suporte' || $perfil == 'Desenvolvimento')) {
        $erro = "Você não tem permissão para atribuir este perfil.";
    } else {
        try {
            $sql = "UPDATE usuarios SET nome = ?, email = ?, perfil = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $email, $perfil, $id]);
            $sucesso = "Usuário atualizado com sucesso!";
        } catch (Exception $e) {
            $erro = "Erro ao atualizar: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Usuário - Agenda CGD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>✏️ Editar Usuário</h2>
        <p><a href="gerenciar_usuarios.php">⬅ Voltar</a></p>

        <?php if ($erro): ?>
            <div style="background-color: #ffe6e6; color: #cc0000; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <strong>Erro:</strong> <?= htmlspecialchars($erro) ?>
            </div>
        <?php endif; ?>

        <?php if ($sucesso): ?>
            <div style="background-color: #e6ffe6; color: #006600; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <strong>Sucesso:</strong> <?= htmlspecialchars($sucesso) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label>Nome:</label>
            <input type="text" name="nome" required value="<?= htmlspecialchars($usuario['nome']) ?>">

            <label>Email:</label>
            <input type="email" name="email" required value="<?= htmlspecialchars($usuario['email']) ?>">

            <label>Perfil:</label>
            <select name="perfil" required>
                <option value="Usuario" <?= $usuario['perfil'] == 'Usuario' ? 'selected' : '' ?>>Usuário</option>
                <?php if ($_SESSION['perfil'] == 'Suporte'): ?>
                    <option value="Administrador" <?= $usuario['perfil'] == 'Administrador' ? 'selected' : '' ?>>Administrador</option>
                    <option value="Desenvolvimento" <?= $usuario['perfil'] == 'Desenvolvimento' ? 'selected' : '' ?>>Desenvolvimento</option>
                    <option value="Suporte" <?= $usuario['perfil'] == 'Suporte' ? 'selected' : '' ?>>Suporte</option>
                <?php elseif ($_SESSION['perfil'] == 'Administrador'): ?>
                    <!-- Administrador só pode manter ou atribuir "Usuário" -->
                    <option value="Usuario" selected>Usuário</option>
                <?php endif; ?>
            </select>

            <button type="submit">💾 Salvar Alterações</button>
        </form>
    </div>
</body>
</html>