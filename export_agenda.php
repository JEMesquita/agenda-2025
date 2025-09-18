<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    exit('Acesso negado.');
}

include 'config.php';

$stmt = $pdo->query("SELECT * FROM varas ORDER BY nome_vara");
$varas = $stmt->fetchAll();

header('Content-Type: text/plain; charset=utf-8');
header('Content-Disposition: attachment; filename="varas_cgd.txt"');

echo "=== EXPORTAÇÃO DE VARAS - TJCE ===\n";
echo "Gerado em: " . date('d/m/Y H:i:s') . "\n";
echo "Usuário: " . $_SESSION['usuario_nome'] . "\n";
echo "===================================\n\n";

foreach ($varas as $vara) {
    echo "NOME: " . $vara['nome_vara'] . "\n";
    echo "CONTATO: " . ($vara['contato'] ?? 'Não informado') . "\n";
    echo "EMAIL: " . ($vara['email'] ?? 'Não informado') . "\n";
    echo "ENDEREÇO: " . ($vara['endereco'] ?? 'Não informado') . "\n";
    echo "BALCÃO VIRTUAL: " . ($vara['link_balcao'] ?? 'Não informado') . "\n";
    echo "---\n";
}