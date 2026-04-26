<?php
// api/listar_cardapio.php - Endpoint para listar pizzas do cardápio

header('Content-Type: application/json');
require_once '../config/db.php';

// Permitir requisições de qualquer origem (CORS)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

// Verificar se é GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    responderJSON(false, 'Método não permitido');
}

// Query para buscar pizzas ativas
$sql = "SELECT id, nome, descricao, preco, imagem FROM menu_pizzas WHERE ativa = TRUE ORDER BY nome ASC";
$result = $conn->query($sql);

if (!$result) {
    responderJSON(false, 'Erro ao buscar cardápio: ' . $conn->error);
}

$pizzas = [];
while ($row = $result->fetch_assoc()) {
    $pizzas[] = $row;
}

// Retornar como JSON
header('Content-Type: application/json');
echo json_encode($pizzas);

$conn->close();
?>
