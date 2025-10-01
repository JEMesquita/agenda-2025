<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Verifica se o perfil tem permissão para acessar esta página
if ($_SESSION['perfil'] !== 'Administrador' && $_SESSION['perfil'] !== 'Suporte') {
    die("Acesso negado. Você não tem permissão para gerenciar usuários.");
}

include 'config.php';

// Buscar todos os usuários
$stmt = $pdo->query("SELECT id, nome, email, perfil FROM usuarios ORDER BY nome");
$usuarios = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gerenciar Usuários - Agenda 2025</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>👥 Gerenciar Usuários</h2>
        <p><a href="dashboard.php">⬅ Voltar ao Dashboard</a></p>

        <table>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Perfil</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= htmlspecialchars($usuario['nome']) ?></td>
                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                    <td><?= htmlspecialchars($usuario['perfil']) ?></td>
                    <td>
                        <?php
                        $pode_editar = false;

                        if ($_SESSION['perfil'] == 'Suporte') {
                            $pode_editar = true; // Suporte edita todos
                        } elseif ($_SESSION['perfil'] == 'Administrador') {
                            // Administrador só edita "Usuário"
                            if ($usuario['perfil'] == 'Usuario') {
                                $pode_editar = true;
                            }
                        }

                        if ($pode_editar):
                        ?>
                            <a href="editar_usuario.php?id=<?= $usuario['id'] ?>" style="color: #006400;">✏️ Editar</a>
                        <?php else: ?>
                            <span style="color: #999;">🔒 Sem permissão</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>