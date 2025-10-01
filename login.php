<?php
session_start();
include 'config.php';

if ($_POST) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['perfil'] = $usuario['perfil'];
        header("Location: dashboard.php");
        exit;
    } else {
        $erro = "Email ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Agenda</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <img src="logo.png" alt="Agenda" style="height: 250px;">
        <h2>Login</h2>
        <?php if (isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
        <?php if (isset($_GET['msg'])) echo "<p style='color:green;'>" . $_GET['msg'] . "</p>"; ?>
        <form method="POST">
            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Senha:</label>
            <input type="password" name="senha" required>

            <button type="submit">Entrar</button>
        </form>
        <br>
        <a href="register.php">Criar conta</a>
    </div>
<footer style="text-align:center; padding:20px; background-color:#f1f1f1; margin-top:40px;">
  <div style="display:flex; justify-content:center; gap:60px; flex-wrap:wrap; max-width:1000px; margin:auto;">
        <!-- Informações de Contato -->
        <div style="flex: 1; min-width:250px;"> 
            <h3>Contato</h3>
                <p>Telefone.:(85) 99661-3303</p>
        </div>        
        <!-- Horário de Atendimento -->
        <div style="flex:1; min-width:250px;">
             <h3>Horário de Atendimento</h3>
             <p>Segunda a Sexta: 08h - 18h
             Sábado e Domingo: Fechado</p>
        </div>
        <!-- Nossos Canais -->
        <!-- Nossos Canais -->
        <div style="flex:1; min-width:250px;">
            <h3>Desenvimento e Manutenções</h3>
            <p><a href="mailto:contato@gmail.com">esmerinomesquita@gmail.com.br</a></p>
            <p><a href="https://github.com/JEMesquita/joao.mesquita.github.io" target="_blank">Site Oficial</a></p>
            <!-- Adicione mais links se necessário -->
             <p style="margin-top:30px; font-size:14px;">&copy; João Mesquita 2025 - Todos os direitos reservados.</p>
        </div>
</footer>
</body>
</html>