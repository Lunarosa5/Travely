<?php
session_start();

require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';
require_once __DIR__ . '/../database/connect.php';

$hoje = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Nova Viagem - Travely</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="fundo-dashboard">
    <div class="dashboard-container">

        <?php include __DIR__ . '/../includes/header.php'; ?>

        <main class="dashboard-conteudo-form">
            <h1 class="titulo-pagina">Descreva sua nova viagem</h1>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $id_usuario = $_SESSION['id_usuario'];
                $titulo = "Viagem para " . $_POST['destino'];

                // Conta quantas fotos foram selecionadas de fato
                $total_fotos = 0;
                if (isset($_FILES['imagem']['name']) && is_array($_FILES['imagem']['name'])) {
                    foreach ($_FILES['imagem']['name'] as $nome) {
                        if (!empty($nome)) {
                            $total_fotos++;
                        }
                    }
                }

                // Se passou de 10, nem tenta cadastrar a viagem e mostra o aviso direto
                if ($total_fotos > 10) {
                    echo "<div class='container-mensagem'><p class='caixa-mensagem erro'>Você só pode adicionar até 10 imagens por viagem!</p></div>";
                } else {
                    // Tenta cadastrar a viagem normalmente
                    $id_viagem_criada = cadastrar_viagem(
                        $conexao,
                        $id_usuario,
                        $titulo,
                        $_POST['destino'],
                        $_POST['data_inicio'],
                        $_POST['data_fim'],
                        $_POST['relato'],
                        $_POST['avaliacao']
                    );

                    if ($id_viagem_criada) {
                        if (isset($_FILES['imagem'])) {
                            foto_viagem($conexao, $id_viagem_criada, $_FILES['imagem']);
                        }

                        echo "<div class='container-mensagem'><p class='caixa-mensagem sucesso'>Viagem cadastrada com sucesso!</p></div>";
                        $_POST = array();
                    }
                }
            }
            ?>

            <div class="card-formulario">
                <form action="" method="post" enctype="multipart/form-data" class="form-viagem">

                    <!-- Campo Destino (Largura Total) -->
                    <div class="campo-form largura-total">
                        <label for="destino">Adicione o destino:</label>
                        <input type="text" name="destino" id="destino" value="<?= ($_POST['destino'] ?? ''); ?>" required>
                    </div>

                    <!-- Datas Lado a Lado -->
                    <div class="campo-form metade">
                        <label for="data_inicio">Data de inicio da viagem:</label>
                        <input type="date" name="data_inicio" id="data_inicio" max="<?= $hoje; ?>" value="<?= ($_POST['data_inicio'] ?? ''); ?>" required>
                    </div>

                    <div class="campo-form metade">
                        <label for="data_fim">Data de fim da viagem:</label>
                        <input type="date" name="data_fim" id="data_fim" max="<?= $hoje; ?>" value="<?= ($_POST['data_fim'] ?? ''); ?>" required>
                    </div>

                    <!-- Descrição (Largura Total) -->
                    <div class="campo-form largura-total">
                        <label for="relato">Descreva-a:</label>
                        <textarea name="relato" id="relato" rows="3" required><?= ($_POST['relato'] ?? ''); ?></textarea>
                    </div>

                    <!-- Foto e Nota Lado a Lado -->
                    <div class="campo-form metade">
                        <label for="imagem">Adicione uma foto da viagem:</label>
                        <input type="file" name="imagem[]" id="imagem" accept="image/*" multiple>
                    </div>

                    <div class="campo-form metade">
                        <label for="avaliacao">De uma nota de 0 à 5:</label>
                        <input type="number" name="avaliacao" id="avaliacao" min="0" max="5" value="<?= ($_POST['avaliacao'] ?? ''); ?>" required>
                    </div>

                    <!-- Botões de Ação Centralizados -->
                    <div class="container-botoes">
                        <input type="reset" value="Limpar" class="btn-form btn-limpar">
                        <input type="submit" value="Salvar" class="btn-form btn-salvar">
                    </div>
                </form>
            </div>
        </main>

        <?php include __DIR__ . '/../includes/footer.php'; ?>

    </div>
</body>

</html>