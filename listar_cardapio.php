<?php
// api/listar_cardapio.php - Endpoint para listar pizzas com categoria

header('Content-Type: application/json');
require_once '../config/db.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    responderJSON(false, 'Método não permitido');
}

// Recebe categoria via GET (opcional)
$categoria = isset($_GET['categoria']) ? sanitizar($conn, $_GET['categoria']) : '';

$sql = "SELECT id, nome, descricao, preco, imagem, categoria 
        FROM menu_pizzas 
        WHERE ativa = TRUE";

if (!empty($categoria) && $categoria !== 'todos') {
    $sql .= " AND categoria = '$categoria'";
}

$sql .= " ORDER BY 
            CASE categoria 
                WHEN 'tradicional' THEN 1
                WHEN 'especial' THEN 2
                WHEN 'picante' THEN 3
                WHEN 'doce' THEN 4
                WHEN 'premium' THEN 5
                ELSE 6
            END, nome ASC";

$result = $conn->query($sql);

if (!$result) {
    responderJSON(false, 'Erro ao buscar cardápio: ' . $conn->error);
}

$pizzas = [];
while ($row = $result->fetch_assoc()) {
    // Garantir que imagem tenha um caminho padrão se estiver vazio
    if (empty($row['imagem'])) {
        $row['imagem'] = 'image/pizza_padrao.jpg';
    }
    $pizzas[] = $row;
}

echo json_encode($pizzas);
$conn->close();
?>