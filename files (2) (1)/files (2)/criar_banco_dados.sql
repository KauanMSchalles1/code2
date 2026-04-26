-- Script SQL - Criar banco de dados e tabelas para PizzaCode

-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS pizzacode_db;
USE pizzacode_db;

-- Tabela de Clientes
CREATE TABLE IF NOT EXISTS clientes (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  telefone VARCHAR(15) NOT NULL,
  endereco TEXT NOT NULL,
  data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  ativo BOOLEAN DEFAULT TRUE,
  INDEX idx_email (email),
  INDEX idx_data (data_cadastro)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Cardápio (Menu de Pizzas)
CREATE TABLE IF NOT EXISTS menu_pizzas (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  descricao TEXT,
  preco DECIMAL(10,2) NOT NULL,
  imagem VARCHAR(255),
  ativa BOOLEAN DEFAULT TRUE,
  data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_ativa (ativa)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Pedidos
CREATE TABLE IF NOT EXISTS pedidos (
  id INT PRIMARY KEY AUTO_INCREMENT,
  cliente_id INT NOT NULL,
  data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  valor_total DECIMAL(10,2),
  status ENUM('pendente', 'confirmado', 'preparando', 'saiu_para_entrega', 'entregue', 'cancelado') DEFAULT 'pendente',
  forma_pagamento ENUM('pix', 'cartao', 'dinheiro') NOT NULL,
  observacoes TEXT,
  FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE RESTRICT,
  INDEX idx_cliente (cliente_id),
  INDEX idx_status (status),
  INDEX idx_data (data_pedido)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Itens do Pedido
CREATE TABLE IF NOT EXISTS itens_pedido (
  id INT PRIMARY KEY AUTO_INCREMENT,
  pedido_id INT NOT NULL,
  pizza_id INT,
  nome_produto VARCHAR(100) NOT NULL,
  quantidade INT NOT NULL,
  preco_unitario DECIMAL(10,2) NOT NULL,
  subtotal DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
  FOREIGN KEY (pizza_id) REFERENCES menu_pizzas(id) ON DELETE SET NULL,
  INDEX idx_pedido (pedido_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Formas de Pagamento
CREATE TABLE IF NOT EXISTS formas_pagamento (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(50) NOT NULL UNIQUE,
  descricao TEXT,
  ativa BOOLEAN DEFAULT TRUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserir formas de pagamento padrão
INSERT INTO formas_pagamento (nome, descricao) VALUES
('PIX', 'Transferência instantânea'),
('Cartão de Crédito', 'Parcelamento em até 3x'),
('Dinheiro', 'Pagamento na entrega com troco');

-- Inserir algumas pizzas de exemplo
INSERT INTO menu_pizzas (nome, descricao, preco, imagem) VALUES
('Pizza Margherita', 'Molho de tomate, mozzarella, tomate e manjericão fresco', 45.00, 'image/margherita.jpg'),
('Pizza Calabresa', 'Molho de tomate, mozzarella, calabresa e cebola', 48.00, 'image/calabresa.jpg'),
('Pizza Quatro Queijos', 'Mozzarella, parmesão, gorgonzola e catupiry', 55.00, 'image/quatro_queijos.jpg'),
('Pizza Frango com Requeijão', 'Frango desfiado, requeijão e cebola', 50.00, 'image/frango.jpg'),
('Pizza Vegetariana', 'Pimentão, cebola, tomate, brócolis e azeitona', 46.00, 'image/vegetariana.jpg');
