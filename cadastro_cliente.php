<?php
// api/cadastro_cliente.php - Endpoint para cadastrar clientes

header('Content-Type: application/json');
require_once '../config/db.php';

// Permitir requisições de qualquer origem (CORS)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Verificar se é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responderJSON(false, 'Método não permitido');
}

// Receber dados JSON
$data = json_decode(file_get_contents('php://input'), true);

// Validar campos obrigatórios
if (empty($data['nome']) || empty($data['email']) || empty($data['telefone']) || empty($data['endereco'])) {
    responderJSON(false, 'Todos os campos são obrigatórios');
}

// Sanitizar dados
$nome = sanitizar($conn, $data['nome']);
$email = sanitizar($conn, $data['email']);
$telefone = sanitizar($conn, $data['telefone']);
$endereco = sanitizar($conn, $data['endereco']);

// Validar email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    responderJSON(false, 'Email inválido');
}

// Preparar e executar query (usando prepared statement é mais seguro)
$stmt = $conn->prepare("INSERT INTO clientes (nome, email, telefone, endereco) VALUES (?, ?, ?, ?)");

if (!$stmt) {
    responderJSON(false, 'Erro ao preparar query: ' . $conn->error);
}

$stmt->bind_param("ssss", $nome, $email, $telefone, $endereco);

if ($stmt->execute()) {
    $cliente_id = $stmt->insert_id;
    responderJSON(true, 'Cliente cadastrado com sucesso!', ['cliente_id' => $cliente_id]);
} else {
    // Verificar se o erro é email duplicado
    if ($conn->errno == 1062) {
        responderJSON(false, 'Este email já está cadastrado');
    } else {
        responderJSON(false, 'Erro ao cadastrar cliente: ' . $stmt->error);
    }
}

$stmt->close();
$conn->close();
?>
