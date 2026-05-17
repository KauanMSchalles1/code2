<?php
// config/db.php - Configuração do banco de dados

define('DB_HOST', 'localhost');
define('DB_USER', 'root');           // Seu usuário MySQL
define('DB_PASS', 'Ang!@#123');               // Sua senha MySQL (vazia se não tem)
define('DB_NAME', 'pizzacode_db');

// Criar conexão
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar conexão
if ($conn->connect_error) {
    die(json_encode(['sucesso' => false, 'mensagem' => 'Erro ao conectar ao banco de dados']));
}

// Definir charset para UTF-8
$conn->set_charset("utf8mb4");

// Função para preparar dados (prevenir SQL Injection)
function sanitizar($conn, $data) {
    return htmlspecialchars($conn->real_escape_string($data));
}

// Função para responder em JSON
function responderJSON($sucesso, $mensagem, $dados = null) {
    header('Content-Type: application/json');
    $resposta = [
        'sucesso' => $sucesso,
        'mensagem' => $mensagem
    ];
    if ($dados !== null) {
        $resposta['dados'] = $dados;
    }
    echo json_encode($resposta);
    exit;
}
?>
