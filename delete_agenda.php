<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido.");
}

$id = (int)$_GET['id'];

try {
    $stmt = $pdo->prepare("DELETE FROM varas WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['mensagem'] = "Vara excluída com sucesso!";
} catch (Exception $e) {
    $_SESSION['erro'] = "Erro ao excluir: " . $e->getMessage();
}

header("Location: dashboard.php");
exit;
?>