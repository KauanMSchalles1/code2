async function carregarCardapio() {
    let pizzas = [];

    try {
        const response = await fetch('api/listar_cardapio.php');
        pizzas = await response.json();
    } catch (error) {
        console.warn('API não respondeu, usando dados locais');

        pizzas = [
            {
                id: 1,
                nome: "Margherita",
                descricao: "Mozzarella, tomate e manjericão",
                preco: 45,
                imagem: "fig1.jpg"
            },
            {
                id: 2,
                nome: "Calabresa",
                descricao: "Calabresa com cebola",
                preco: 50,
                imagem: "fig2.jpg"
            }
        ];
    }

    // 🔥 MAIS PIZZAS AQUI
    const pizzasExtras = [
        {
            id: 3,
            nome: "Pizza Bacon",
            descricao: "Bacon crocante com queijo",
            preco: 62,
            imagem: "fig4.jpg"
        },
        {
            id: 4,
            nome: "Frango com Catupiry",
            descricao: "Frango com catupiry",
            preco: 55,
            imagem: "fig5.jpg"
        },
        {
            id: 5,
            nome: "Quatro Queijos",
            descricao: "Mix de queijos",
            preco: 60,
            imagem: "fig6.jpg"
        }
    ];

    const todasPizzas = [...pizzas, ...pizzasExtras];

    const menuContainer = document.getElementById('menuContainer');
    menuContainer.innerHTML = '';

    todasPizzas.forEach(pizza => {
        menuContainer.innerHTML += `
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card menu-item h-100">
                    <img src="${pizza.imagem}" class="card-img-top" alt="${pizza.nome}">
                    
                    <div class="card-body d-flex flex-column">
                        <h5>${pizza.nome}</h5>
                        <p>${pizza.descricao}</p>

                        <p class="h5 text-danger mt-auto">
                            R$ ${pizza.preco.toFixed(2)}
                        </p>

                        <button class="btn btn-custom text-white mt-2">
                            Adicionar ao Carrinho
                        </button>
                    </div>
                </div>
            </div>
        `;
    });
}

document.addEventListener('DOMContentLoaded', carregarCardapio);