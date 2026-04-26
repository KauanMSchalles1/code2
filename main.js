// main.js - Comunicação com o backend

// Quando o formulário for submetido
document.getElementById('formCadastro').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Capturar dados do formulário
    const formData = {
        nome: document.getElementById('nome').value,
        email: document.getElementById('email').value,
        telefone: document.getElementById('telefone').value,
        endereco: document.getElementById('endereco').value
    };
    
    try {
        // Enviar dados para o servidor
        const response = await fetch('api/cadastro_cliente.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        });
        
        const resultado = await response.json();
        
        const mensagemDiv = document.getElementById('mensagem');
        
        if (resultado.sucesso) {
            mensagemDiv.className = 'alert alert-success';
            mensagemDiv.textContent = 'Cadastro realizado com sucesso!';
            mensagemDiv.style.display = 'block';
            document.getElementById('formCadastro').reset();
            
            // Fechar modal após 2 segundos
            setTimeout(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('cadastroModal'));
                modal.hide();
            }, 2000);
        } else {
            mensagemDiv.className = 'alert alert-danger';
            mensagemDiv.textContent = ' Erro: ' + resultado.mensagem;
            mensagemDiv.style.display = 'block';
        }
    } catch (error) {
        console.error('Erro:', error);
        const mensagemDiv = document.getElementById('mensagem');
        mensagemDiv.className = 'alert alert-danger';
        mensagemDiv.textContent = 'Erro ao conectar com o servidor';
        mensagemDiv.style.display = 'block';
    }
});

// Função para carregar cardápio do banco de dados
async function carregarCardapio() {
    try {
        const response = await fetch('api/listar_cardapio.php');
        const pizzas = await response.json();
        
        const menuContainer = document.getElementById('menuContainer');
        menuContainer.innerHTML = '';
        
        pizzas.forEach(pizza => {
            const html = `
                <div class="col-md-4 mb-4">
                    <div class="card menu-item">
                        <img src="${pizza.imagem}" class="card-img-top" alt="${pizza.nome}">
                        <div class="card-body">
                            <h5 class="card-title">${pizza.nome}</h5>
                            <p class="card-text">${pizza.descricao}</p>
                            <p class="h5 text-danger">R$ ${parseFloat(pizza.preco).toFixed(2)}</p>
                            <button class="btn btn-custom w-100 text-white" onclick="adicionarAoCarrinho(${pizza.id})">
                                Adicionar ao Carrinho
                            </button>
                        </div>
                    </div>
                </div>
            `;
            menuContainer.innerHTML += html;
        });
    } catch (error) {
        console.error('Erro ao carregar cardápio:', error);
    }
}

// Função para adicionar pizza ao carrinho
function adicionarAoCarrinho(pizzaId) {
    // Implementar lógica de carrinho aqui
    alert('Pizza adicionada ao carrinho! (Funcionalidade em desenvolvimento)');
}

// Carregar cardápio quando a página carregar
document.addEventListener('DOMContentLoaded', function() {
    // carregarCardapio(); // Descomente quando o backend estiver pronto
});
