<?php
// login.php: interface de login

// Inicia a sessão antes de qualquer saída HTML
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Carrega conexão e funções
require_once __DIR__ . '/../database/connect.php';
require_once __DIR__ . '/../includes/functions.php';

// Verifica se o usuário enviou o formulário (clicou no botão) antes de executar a função.
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Executa a função que, no banco de dados, procura o usuário correspondente ao e-mail digitado e guarda o resultado em $usuario.
    $usuario = consulta_user($conexao, $_POST['email']);

    // Verifica se o usuário existe e se a senha (hash) digitada corresponde à senha (hash) armazenada.
    if ($usuario && password_verify($_POST['senha'], $usuario['senha'])) {
        session_start();

        // Após o login acontecer o usuário é redirecionado à página inicial (inicio.php).
        $_SESSION['id_usuario'] = $usuario['id'];
        header("Location: ../pages/inicio.php");
        exit();
    }

    // Em caso de erro, uma mensagem é exibida.
    else {
        echo "<p class='alerta erro'>E-mail ou senha inválidos.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/travely/css/style.css">
    <title>Faça seu login - Travely</title>
</head>

<body class="fundo-login">

    <!-- Lado Esquerdo - Formulário (Metade da Tela) -->
    <div class="login-lado-form">

        <a href="../index.php" class="login-botao-voltar">⬅ Voltar</a>

        <div class="login-conteudo-central">
            <h2>Faça o login</h2>

            <form action="" method="POST">
                <div class="login-campo">
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" placeholder="Insira seu email" required>
                </div>

                <div class="login-campo">
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" id="senha" placeholder="Insira sua senha" required>
                </div>

                <div class="login-container-submit">
                    <input type="submit" value="Entrar" class="login-botao-submit">
                </div>
            </form>

            <?php if (!empty($erro_login)): ?>
                <p class='alerta erro'><?= htmlspecialchars($erro_login) ?></p>
            <?php endif; ?>

            <p class="login-texto-cadastrar">Ainda não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
        </div>

    </div>

    <!-- Lado Direito - Imagem -->
    <div class="login-lado-imagem"></div>

</body>

</html>