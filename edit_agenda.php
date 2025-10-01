<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';

$erro = "";
$sucesso = "";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido.");
}

$id = (int)$_GET['id'];

// Buscar vara
$stmt = $pdo->prepare("SELECT * FROM varas WHERE id = ?");
$stmt->execute([$id]);
$vara = $stmt->fetch();

if (!$vara) {
    die("Vara não encontrada.");
}

if ($_POST) {
    $nome = trim($_POST['nome_vara']);
    $contato = trim($_POST['contato']);
    $email = trim($_POST['email']);
    $endereco = trim($_POST['endereco']);
    $link = trim($_POST['link_balcao']);

    if (empty($nome)) {
        $erro = "O nome da vara é obrigatório.";
    } else {
        try {
            $sql = "UPDATE varas SET nome_vara = ?, contato = ?, email = ?, endereco = ?, link_balcao = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $contato, $email, $endereco, $link, $id]);

            $sucesso = "Vara atualizada com sucesso!";
        } catch (Exception $e) {
            $erro = "Erro ao atualizar: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Alterar Contato - Agenda TJCE</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>✏️ Alterar Nome da Vara ou Comarca</h2>
        <p><a href="dashboard.php">⬅ Voltar ao Dashboard</a></p>

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
            <label>Nome da Vara ou Comarca:</label>
            <input type="text" name="nome_vara" required value="<?= htmlspecialchars($vara['nome_vara']) ?>">

            <label>Contato:</label>
            <textarea name="contato" rows="3" style="resize: vertical;"><?= htmlspecialchars($vara['contato'] ?? '') ?></textarea>

            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($vara['email'] ?? '') ?>">

            <label>Endereço:</label>
            <textarea name="endereco" rows="3" style="resize: vertical;"><?= htmlspecialchars($vara['endereco'] ?? '') ?></textarea>

            <label>Link do Balcão Virtual:</label>
            <input type="url" name="link_balcao" value="<?= htmlspecialchars($vara['link_balcao'] ?? '') ?>">

            <button type="submit">💾 Salvar Alterações</button>
        </form>
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
<?php
// Fechar a conexão PDO
$pdo = null;
?>
