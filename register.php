<?php
session_start();
include 'config.php';

$erro = ""; // variável para armazenar mensagem de erro

if ($_POST) {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $perfil = $_POST['perfil'];

    // Validação básica
    if (empty($nome) || empty($email) || empty($senha)) {
        $erro = "Todos os campos são obrigatórios!";
    } else {
        try {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios (nome, email, senha, perfil) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $email, $senha_hash, $perfil]);

            // Redireciona com mensagem de sucesso
            $_SESSION['mensagem'] = "Usuário cadastrado com sucesso!";
            header("Location: login.php");
            exit;

        } catch (PDOException $e) {
            // Verifica se foi erro de chave única (email duplicado)
            if ($e->getCode() == 23000) {
                $erro = "E-mail já cadastrado. Tente outro.";
            } else {
                $erro = "Erro ao cadastrar: " . $e->getMessage();
                // Para ambiente de produção, remova a exibição da mensagem técnica
                // $erro = "Erro interno. Tente novamente mais tarde.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <img src="logo.png" alt="Agenda 2025" style="display:block; margin:auto; max-width:150px;">
        <h2>Cadastro de Usuário</h2>

        <?php if (!empty($erro)): ?>
            <script>
                alert("❌ Erro ao cadastrar usuário:\n<?= addslashes($erro) ?>");
            </script>
            <div style="background-color: #ffe6e6; color: #cc0000; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #ff9999;">
                <strong>Erro:</strong> <?= htmlspecialchars($erro) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label>Nome:</label>
            <input type="text" name="nome" required value="<?= isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : '' ?>">

            <label>Email:</label>
            <input type="email" name="email" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">

            <label>Senha:</label>
            <input type="password" name="senha" required>

            <label>Perfil:</label>
            <select name="perfil" required>
                <option value="Usuario" <?= (isset($_POST['perfil']) && $_POST['perfil'] == 'Usuario') ? 'selected' : '' ?>>Usuário</option>
                <option value="Administrador" <?= (isset($_POST['perfil']) && $_POST['perfil'] == 'Administrador') ? 'selected' : '' ?>>Administrador</option>
                <option value="Desenvolvimento" <?= (isset($_POST['perfil']) && $_POST['perfil'] == 'Desenvolvimento') ? 'selected' : '' ?>>Desenvolvimento</option>
                <option value="Suporte" <?= (isset($_POST['perfil']) && $_POST['perfil'] == 'Suporte') ? 'selected' : '' ?>>Suporte</option>
            </select>

            <button type="submit">Cadastrar</button>
        </form>
        <br>
        <a href="login.php">Já tem conta? Faça login</a>
        <footer style="text-align:center; padding:20px; background-color:#f1f1f1; margin-top:40px;">
        <div style="display:flex; justify-content:center; gap:60px; flex-wrap:wrap; max-width:1000px; margin:auto;">
            <!-- Nossos Canais -->
            <div style="flex:1; min-width:250px;">
                <h3>Desenvimento e Manutenções</h3>
                <p><a href="mailto:contato@gmail.com">esmerinomesquita@gmail.com.br</a></p>
                <p><a href="https://github.com/JEMesquita/joao.mesquita.github.io" target="_blank">Site Oficial</a></p>
                <!-- Adicione mais links se necessário -->
            </div>
            <!-- Horário de Atendimento -->
            <div style="flex:1; min-width:250px;">
                <h3>Horário de Atendimento</h3>
                <p>Segunda a Sexta: 08h - 18h
                    Sábado e Domingo: Fechado</p>
            </div>

            <!-- Informações de Contato -->
            <div style="flex: 1; min-width:250px;">
                <h3>Contato</h3>
                <p>Telefone.:(85) 99661-3303</p>
            </div>
            <p style="margin-top:30px; font-size:14px;">&copy; João Mesquita 2025 - Todos os direitos reservados.</p>
    </footer>
    </div>
</body>
</html>