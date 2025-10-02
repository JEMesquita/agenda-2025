<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';

// Corrige campo para nome
$stmt = $pdo->query("SELECT * FROM varas ORDER BY nome ASC");
$varas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda - Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Agenda 2025 - Bem-vindo, <?= $_SESSION['usuario_nome'] ?> (<?= $_SESSION['perfil'] ?>)</h2>
        <p>
            <a href="add_agenda.php">➕ Adicionar Novo Contato</a> |
            <a href="export_agenda.php" target="_blank">📄 Exportar como .TXT</a> |
            <a href="import_agenda.php">📥 Importar .TXT</a> |
            <a href="logout.php">🚪 Sair</a>
        </p>

        <div style="margin: 20px 0;">
            <label for="searchVara">🔍 Localizar Contato:</label>
            <input type="text" id="searchVara" placeholder="Digite parte do nome, contato ou e-mail..." style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 5px; border: 1px solid #ccc;">
        </div>

        <table id="tabelaVaras">
            <tr>
                <th>Nome da Comarca ou Vara</th>
                <th>Contato</th>
                <th>Email</th>
                <th>Endereço</th>
                <th>Balcão Virtual</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($varas as $vara): ?>
                <tr>
                    <td><?= htmlspecialchars($vara['nome_vara']) ?></td>
                    <td style="word-wrap: break-word; max-width: 200px;"><?= htmlspecialchars($vara['contato'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($vara['email'] ?? '-') ?></td>
                    <td style="word-wrap: break-word; max-width: 250px;"><?= htmlspecialchars($vara['endereco'] ?? '-') ?></td>
                    <td>
                        <?php if (!empty($vara['link_balcao'])): ?>
                            <a href="<?= htmlspecialchars($vara['link_balcao']) ?>" target="_blank">Acessar</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <button onclick="openModal('edit_agenda.php?id=<?= $vara['id'] ?>', '✏️ Editar <?= htmlspecialchars($vara['nome_vara']) ?>')" style="background: #006400; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; margin-right: 5px;">✏️ Editar</button>
                        <button onclick="confirmDelete(<?= $vara['id'] ?>, '<?= addslashes($vara['nome_vara']) ?>')" style="background: #cc0000; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">🗑️ Excluir</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

    </div>

    <!-- MODAL DE EDIÇÃO -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3 id="modal-title">Carregando...</h3>
            <div id="modal-body"></div>
        </div>
    </div>

    <!-- MODAL DE CONFIRMAÇÃO DE EXCLUSÃO -->
    <div id="confirm-modal" class="modal">
        <div class="modal-content">
            <h3>⚠️ Confirmar Exclusão</h3>
            <p id="confirm-message"></p>
            <button id="confirm-btn">Sim, excluir</button>
            <button id="cancel-btn" onclick="closeConfirmModal()">Cancelar</button>
    </div>
    <div>
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
    <script src="script.js"></script>
    <script>
        document.getElementById('searchVara').addEventListener('keyup', function() {
            let filtro = this.value.toLowerCase().trim();
            let linhas = document.querySelectorAll('#tabelaVaras tbody tr, #tabelaVaras tr:not(:first-child)');

            linhas.forEach(linha => {
                let textoLinha = linha.textContent.toLowerCase();
                linha.style.display = filtro === '' || textoLinha.includes(filtro) ? '' : 'none';
            });
        });
    </script>
</body>

</html>