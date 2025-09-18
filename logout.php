<?php
session_start();
session_destroy();
header("Location: login.php?msg=Você saiu com sucesso.");
exit;
?>
