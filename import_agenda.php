<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';

$mensagem = '';
$erro = '';

if ($_POST && isset($_FILES['arquivo'])) {
    $arquivo = $_FILES['arquivo'];

    if ($arquivo['error'] !== UPLOAD_ERR_OK) {
        $erro = "Erro no upload do arquivo.";
    } elseif ($arquivo['type'] !== 'text/plain') {
        $erro = "Apenas arquivos .txt são permitidos.";
    } else {
        $conteudo = file_get_contents($arquivo['tmp_name']);
        $blocos = explode("---\n", $conteudo);

        $inseridos = 0;
        $falhas = 0;

        foreach ($blocos as $bloco) {
            $linhas = explode("\n", trim($bloco));
            $dados = [];

            foreach ($linhas as $linha) {
                if (strpos($linha, 'NOME:') === 0) $dados['nome'] = trim(substr($linha, 5));
                if (strpos($linha, 'CONTATO:') === 0) $dados['contato'] = trim(substr($linha, 9)) === 'Não informado' ? null : trim(substr($linha, 9));
                if (strpos($linha, 'EMAIL:') === 0) $dados['email'] = trim(substr($linha, 6)) === 'Não informado' ? null : trim(substr($linha, 6));
                if (strpos($linha, 'ENDEREÇO:') === 0) $dados['endereco'] = trim(substr($linha, 9)) === 'Não informado' ? null : trim(substr($linha, 9));
                if (strpos($linha, 'BALCÃO VIRTUAL:') === 0) $dados['balcao'] = trim(substr($linha, 15)) === 'Não informado' ? null : trim(substr($linha, 15));
            }

            if (!empty($dados['nome'])) {
                try {
                    $sql = "INSERT INTO varas (nome_vara, contato, email, endereco, link_balcao) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        $dados['nome'],
                        $dados['contato'] ?? null,
                        $dados['email'] ?? null,
                        $dados['endereco'] ?? null,
                        $dados['balcao'] ?? null
                    ]);
                    $inseridos++;
                } catch (Exception $e) {
                    $falhas++;
                }
            }
        }

        $mensagem = "Importação concluída: $inseridos registros inseridos, $falhas falhas.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Importar Varas - Agenda CGD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>📥 Importar Varas de Arquivo .TXT</h2>
        <p><a href="dashboard.php">⬅ Voltar ao Dashboard</a></p>

        <?php if ($erro): ?>
            <div style="background-color: #ffe6e6; color: #cc0000; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <strong>Erro:</strong> <?= htmlspecialchars($erro) ?>
            </div>
        <?php endif; ?>

        <?php if ($mensagem): ?>
            <div style="background-color: #e6ffe6; color: #006600; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <strong>Sucesso:</strong> <?= htmlspecialchars($mensagem) ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <label>Selecione o arquivo .TXT exportado:</label>
            <input type="file" name="arquivo" accept=".txt" required>
            <button type="submit">Importar Registros</button>
        </form>
    </div>
</body>
</html>