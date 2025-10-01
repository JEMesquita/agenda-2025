<?php
session_start();
if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Splash Screen</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to bottom, #008000, #ffffff);
        }
        .splash {
            text-align: center;
        }
        .splash img {
            width: 500px;
            margin-bottom: 30px;
        }
        .splash p {
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="splash">
        <img src="logo.png" alt="Governo do Estado do Ceará">
        <p>Carregando Agenda...</p>
        <meta http-equiv="refresh" content="3;url=login.php">
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