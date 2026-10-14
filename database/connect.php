<?php

// Carrega o arquivo que guarda as configurações do banco de dados.
require_once __DIR__ . '/../config.php';

// Tenta executar o código que realiza a conexão com o banco.
try {
    // dsn é uma variável que guarda as informações necessárias para identificar o banco de dados ao qual o PHP vai se conectar. Então ela junta as informações do servidor em uma única string.
    $dsn = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;

    // conexao guarda o objeto de conexao(PDO) criado. Assim, aqui a conexão com o PostgresSQL tenta acontecer usando as cofigurações definidas no config.php.
    $conexao = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Configura o PDO para lançar exceções quando ocorrerem erros, permitindo que o código tente tratá-los.

        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]); // faz com que os dados retornados pelas consultas possam ser acessados pelos nomes das colunas, ou seja,  se o banco retornar o nome de um usuário, é possível acessar o valor por $usuario['nome'];

    // se ocorrer uma exceção do PDO durante a execução do bloco try, o código entra no catch para tratar o erro.
} catch (PDOException $e) {
    die("Erro ao conectar ao PostgreSQL: " . $e->getMessage()); // Exibe uma mensagem e encerra a execução do código.
}
?>