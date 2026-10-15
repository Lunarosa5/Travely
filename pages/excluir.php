<?php
session_start();
require_once __DIR__ . '/../database/connect.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';
?><!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Viagem - Travely</title>
    <!-- Correção do caminho do CSS para o padrão absoluto do projeto -->
    <link rel="stylesheet" href="/travely/css/style.css">
</head>

<body class="fundo-dashboard">
    <div class="dashboard-container">
        <?php include __DIR__ . '/../includes/header.php'; ?>

        <main class="dashboard-conteudo-pesquisar">
            <h1 class="titulo-pagina">Apague o relato de uma viagem</h1>

            <div class="container-mensagem">
                <?php  // Se o usuário clicou para excluir uma viagem específica
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['acao']) && $_POST['acao'] == 'excluir') {
                    excluir($conexao, $_POST['id_viagem'], $_SESSION['id_usuario']);
                } ?>
            </div>

            <form action="" method="POST" class="form-pesquisa">
                <div class="campo-pesquisa-grupo">
                    <input type="text" name="destino" id="destino" placeholder="Insira o local da viagem que deseja apagar" value="<?= ($_POST['destino'] ?? ''); ?>" required class="input-pesquisa">
                    <input type="submit" value="Buscar" class="btn-buscar">
                </div>
            </form>

            <div class="resultado-pesquisa-container">
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['destino'])) {
                    $viagens = pesquisar_opcoes($conexao, $_POST['destino']);

                    if (!empty($viagens)) {
                        foreach ($viagens as $viagem) {
                            $fotos = buscar_fotos_viagem($conexao, $viagem['id']);
                            $caminho_imagem = !empty($fotos) ? '../uploads/' . $fotos[0]['nome_arquivo'] : '../images/sem_imagem.png';
                ?>
                            <div class="espaco-viagem">
                                <div class="caixa-imagem">
                                    <img src="<?= ($caminho_imagem); ?>" alt="Foto de <?= ($viagem['destino']); ?>">
                                </div>

                                <div class="info-viagem">
                                    <p class="titulo-local"><strong><?= ($viagem['destino']); ?></strong></p>
                                    <p>Data: <span><?= date('d/m/Y', strtotime($viagem['data_inicio'])); ?></span></p>
                                    <p>Nota: <span><?= ($viagem['avaliacao']); ?></span></p>

                                    <form action="" method="POST" onsubmit="return confirm('Tem certeza que deseja apagar este relato?');">
                                        <input type="hidden" name="id_viagem" value="<?= $viagem['id']; ?>">
                                        <input type="hidden" name="acao" value="excluir">
                                        <input type="submit" value="Excluir" class="btn-ver-mais">
                                    </form>
                                </div>
                            </div>
                <?php
                        }
                    } else {
                        echo "<p class='sem-viagens'>Nenhuma viagem encontrada para este destino.</p>";
                    }
                }
                ?>
            </div>
        </main>

        <?php include __DIR__ . '/../includes/footer.php'; ?>
    </div>
</body>

</html>
