# 🚀 Guia Prático: Configurar PizzaCode com MySQL

## PASSO 1: Preparar o MySQL

### Windows:
```bash
# Abrir MySQL Command Line (buscar no Menu Iniciar)
# Ou use o prompt de comando:
cd "C:\Program Files\MySQL\MySQL Server 8.0\bin"
mysql -u root -p
```

### macOS/Linux:
```bash
mysql -u root -p
```

### Criar o banco de dados:
```sql
-- Cole todo o conteúdo do arquivo 'criar_banco_dados.sql'
-- Você pode copiar e colar diretamente no terminal MySQL
```

Ou use um cliente MySQL como:
- **MySQL Workbench** (gratuito)
- **phpMyAdmin** (interface web)
- **DBeaver** (gratuito e poderoso)

---

## PASSO 2: Estruturar os Arquivos

```
sua-pasta-pizzacode/
│
├── index.html                    (página principal)
├── css/
│   └── style.css               (estilos personalizados)
│
├── js/
│   └── main.js                 (JavaScript do frontend)
│
├── api/
│   ├── cadastro_cliente.php    (POST - cadastrar cliente)
│   ├── listar_cardapio.php     (GET - listar pizzas)
│   └── criar_pedido.php        (POST - criar pedido)
│
├── config/
│   └── db.php                  (conexão com MySQL)
│
├── image/
│   ├── download1.jpg
│   ├── download2.jpg
│   └── download3.jpg
│
└── README.md
```

---

## PASSO 3: Configurar a Conexão MySQL (IMPORTANTE!)

### Abra o arquivo `config/db.php` e atualize:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');      // ← SEU USUÁRIO MYSQL
define('DB_PASS', '');          // ← SUA SENHA MYSQL
define('DB_NAME', 'pizzacode_db');
```

---

## PASSO 4: Rodar o Servidor

### Opção A: PHP Built-in (Mais simples)

```bash
# Navegue até sua pasta
cd C:\caminho\para\pizzacode

# Inicie o servidor PHP
php -S localhost:8000
```

Abra no navegador: **http://localhost:8000**

### Opção B: Apache/XAMPP (Mais profissional)

1. Instale **XAMPP** (Apache + MySQL + PHP)
2. Copie sua pasta em: `C:\xampp\htdocs\pizzacode`
3. Acesse: **http://localhost/pizzacode**

### Opção C: Docker (Avançado)

```bash
docker-compose up
```

---

## PASSO 5: Testar a Integração

1. **Abra o navegador** em `http://localhost:8000`
2. **Clique no botão "Cadastre-se"**
3. **Preencha o formulário** e clique em Cadastrar
4. Se aparecer ✅ em verde = Sucesso!
5. **Verifique no MySQL** se o cliente foi cadastrado:

```sql
USE pizzacode_db;
SELECT * FROM clientes;
```

---

## PASSO 6: Próximos Passos

### Criar mais APIs:

#### Listar pedidos do cliente:
```php
// api/meus_pedidos.php
$cliente_id = $_GET['cliente_id'];
SELECT * FROM pedidos WHERE cliente_id = ? ORDER BY data_pedido DESC
```

#### Criar novo pedido:
```php
// api/criar_pedido.php
INSERT INTO pedidos (cliente_id, forma_pagamento, valor_total)
INSERT INTO itens_pedido (pedido_id, pizza_id, quantidade)
```

#### Atualizar status do pedido:
```php
// api/atualizar_pedido.php
UPDATE pedidos SET status = ? WHERE id = ?
```

---

## ⚠️ SEGURANÇA - CHECKLIST

- ✅ Usar prepared statements (já implementado)
- ✅ Validar inputs no cliente e servidor
- ✅ NUNCA expor credenciais no código frontend
- ✅ Usar HTTPS em produção
- ✅ Implementar autenticação de usuário
- ✅ Fazer backup do banco de dados regularmente

---

## 🐛 SOLUÇÃO DE PROBLEMAS

### Erro: "Can't connect to MySQL"
- Verifique se MySQL está rodando
- Verifique usuário/senha em `db.php`
- Use `localhost` em vez de `127.0.0.1`

### Erro: "Table doesn't exist"
- Execute o script SQL completo em `criar_banco_dados.sql`
- Verifique o nome do banco: `pizzacode_db`

### Erro: "CORS problem"
- Adicione `header('Access-Control-Allow-Origin: *');`
- Use `http://localhost` em vez de `file://`

### Formulário não funciona
- Abra o DevTools (F12) → Aba Network
- Veja a requisição e a resposta
- Verifique o console para erros JavaScript

---

## 📚 RECURSOS ÚTEIS

- **Documentação MySQL**: https://dev.mysql.com/doc/
- **Documentação PHP**: https://www.php.net/manual/
- **Bootstrap 5**: https://getbootstrap.com/docs/
- **JSON em PHP**: https://www.php.net/manual/en/function.json-encode.php

---

## 💡 DICAS FINAIS

1. **Use um editor de código** como VS Code
2. **Instale extensões**: PHP Intelephense, MySQL
3. **Use Postman** para testar APIs
4. **Documente seu código** com comentários
5. **Faça commits** no Git frequentemente

Qualquer dúvida, vem me chamar! 🍕
