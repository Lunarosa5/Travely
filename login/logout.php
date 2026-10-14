<?php
// logout.php: Desloga o usuário destruindo a sessão e o redireciona para o index.php.

// Se a sessão não estava iniciada, inicia ela para conseguir acessar os dados antes de encerrá-la.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Limpa os dados da sessão atual
$_SESSION = array();

// Encerra a sessão atual no servidor
session_destroy();

// Redireciona o usuário à página inicial, index.php.
header("Location: ../index.php");
exit();
