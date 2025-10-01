<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Agenda 2025</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .menu-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .menu-item {
            background: linear-gradient(135deg, #008000, #006400);
            color: white;
            padding: 30px 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
        }

        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            background: linear-gradient(135deg, #006400, #004d00);
        }

        .welcome {
            text-align: center;
            margin-bottom: 30px;
            color: #006400;
        }

        @media (max-width: 768px) {
            .menu-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="welcome">Bem-vindo(a), <?= htmlspecialchars($_SESSION['usuario_nome']) ?>!</h2>
        <p style="text-align: center; margin-bottom: 30px;">Selecione a Instituição para acessar os contatos que deseja gerenciar:</p>

        <div class="menu-container">
            <a href="add_advogado.php" class="menu-item">⚖️ Advogados</a>
            <a href="add_pessoal.php" class="menu-item">👤 Contatos Pessoais</a>
            <a href="add_cgd.php" class="menu-item">🏛️ CGD</a>
            <a href="add_bombeiros.php" class="menu-item">🚒 Corpo de Bombeiros</a>
            <a href="add_detran.php" class="menu-item">🚗 DETRAN</a>
            <a href="add_forum.php" class="menu-item">🏛️ Fórum</a>
            <a href="add_pcce.php" class="menu-item">🕵️‍♂️ PCCE</a>
            <a href="add_pmce.php" class="menu-item">👮‍♂️ PMCE</a>
            <a href="add_pefoce.php" class="menu-item">🔍 PEFOCE</a>
            <a href="add_sap.php" class="menu-item">🔒 SAP</a>      
            <a href="add_outras.php" class="menu-item">🏢 Outras Instituições</a>
            <a href="add_juizado.php" class="menu-item">⚖️ Juizados Especiais</a>
            
            
        </div>

        <div style="text-align: center; margin-top: 40px;">
            <a href="dashboard.php" style="margin-right: 20px; color: #006400; text-decoration: none;">📋 Ver Agenda Completa</a>
            <a href="logout.php" style="color: #cc0000; text-decoration: none;">🚪 Sair</a>
        </div>
    </div>

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
</body>

</html>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil'] != 'Administrador') {
    header("Location: login.php");
    exit;
}
require 'config.php';
// Buscar usuários
$stmt = $pdo->query("SELECT * FROM usuarios");
$usuarios = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários - Agenda CGD</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .action-btn {
            padding: 5px 10px;
            margin-right: 5px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            color: white;
        }

        .edit-btn {
            background-color: #4CAF50;
        }

        .delete-btn {
            background-color: #f44336;
        }

        .add-btn {
            background-color: #008CBA;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }

        .add-btn:hover {
            background-color: #007B9E;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-bar h2 {
            margin: 0;
        }

        .top-bar a {
            text-decoration: none;
        }
    </style>
</head>

<body>