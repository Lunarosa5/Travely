<?php
session_start();
require_once __DIR__ . '/../database/connect.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';

// Processa a exclusão da conta do usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'excluir_conta') {
    excluir_conta($conexao, $_SESSION['id_usuario']);
}

// Busca os dados do usuário para preencher a tela
$usuario = buscar_usuario($conexao, $_SESSION['id_usuario']);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - Travely</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="fundo-dashboard">
    <div class="dashboard-container">
        <?php include __DIR__ . '/../includes/header.php'; ?>

        <main class="dashboard-conteudo-perfil">
            <h1 class="titulo-pagina">Meu Perfil</h1>

            <div class="card-perfil-container">
                
                <!-- Ícone / Foto do Perfil -->
                <div class="avatar-circulo">
                    <img src="../images/foto_perfil.png" alt="Foto de Perfil" class="foto-perfil-redonda">
                </div>

                <div class="form-perfil-campos">
                    <!-- Nome -->
                    <div class="campo-perfil-item">
                        <label>Nome:</label>
                        <input type="text" value="<?= ($usuario['nome'] ?? ''); ?>" readonly class="input-perfil-pino">
                    </div>

                    <!-- Email -->
                    <div class="campo-perfil-item">
                        <label>Email:</label>
                        <input type="email" value="<?= ($usuario['email'] ?? ''); ?>" readonly class="input-perfil-pino">
                    </div>

                    <!-- Senha -->
                    <div class="campo-perfil-item">
                        <label>Senha:</label>
                        <input type="password" value="********" readonly class="input-perfil-pino">
                    </div>
                </div>

                <!-- Botões de Ação Centralizados Embaixo -->
                <div class="container-botoes-perfil">
                    <form action="" method="POST" onsubmit="return confirm('Tem certeza de que deseja excluir sua conta? Esta ação apagará todos os seus relatos e não poderá ser desfeita!');" class="form-excluir-inline">
                        <input type="hidden" name="acao" value="excluir_conta">
                        <input type="submit" value="Excluir" class="btn-perfil-acao btn-perfil-excluir">
                    </form>

                    <a href="../login/atualizar_perfil.php" class="btn-perfil-acao btn-perfil-atualizar">Atualizar</a>
                </div>
            </div>
        </main>

        <?php include __DIR__ . '/../includes/footer.php'; ?>
    </div>
</body>

</html>