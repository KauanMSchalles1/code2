# 🍕 PizzaCode - Guia de Integração com MySQL

## 1. ESTRUTURA RECOMENDADA DO BANCO DE DADOS

### Tabelas Necessárias:

```sql
-- Tabela de Clientes
CREATE TABLE clientes (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE,
  telefone VARCHAR(15),
  endereco TEXT,
  data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Pedidos
CREATE TABLE pedidos (
  id INT PRIMARY KEY AUTO_INCREMENT,
  cliente_id INT NOT NULL,
  data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  valor_total DECIMAL(10,2),
  status ENUM('pendente', 'preparando', 'enviando', 'entregue'),
  forma_pagamento ENUM('pix', 'cartao', 'dinheiro'),
  FOREIGN KEY (cliente_id) REFERENCES clientes(id)
);

-- Tabela de Itens do Pedido
CREATE TABLE itens_pedido (
  id INT PRIMARY KEY AUTO_INCREMENT,
  pedido_id INT NOT NULL,
  produto VARCHAR(100),
  quantidade INT,
  preco_unitario DECIMAL(10,2),
  FOREIGN KEY (pedido_id) REFERENCES pedidos(id)
);

-- Tabela de Cardápio
CREATE TABLE menu_pizzas (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  descricao TEXT,
  preco DECIMAL(10,2),
  imagem VARCHAR(255),
  ativa BOOLEAN DEFAULT TRUE
);
```


## 3. ARQUITETURA SUGERIDA

```
pizzacode/
├── index.html (frontend)
├── css/
│   └── style.css
├── js/
│   └── main.js (requisições ao servidor)
├── server.php (ou server.js, ou app.py)
├── config/
│   └── db.php (conexão com BD)
└── api/
    ├── cadastro_cliente.php
    ├── listar_cardapio.php
    ├── criar_pedido.php
    └── historico_pedidos.php
```

## 4. PASSOS DE IMPLEMENTAÇÃO

### Passo 1: Criar o Banco de Dados
```sql
CREATE DATABASE pizzacode_db;
USE pizzacode_db;
-- Execute os CREATE TABLE acima
```

