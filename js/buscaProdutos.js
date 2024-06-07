document.addEventListener('DOMContentLoaded', function() {
    fetch('php/buscaProdutos.php')
        .then(response => response.json())
        .then(products => {
            const productGrid = document.querySelector('.grid-container');
            products.forEach(product => {
                const productCard = document.createElement('div');
                productCard.classList.add('card');
                productCard.innerHTML = `
                    <img src="imagemProdutos/${product.id}.jpg" alt="${product.name}">
                    <h3>${product.name}</h3>
                    <p>R$${product.price}</p>
                    <button class="comprar" data-id="${product.id}" data-name="${product.name}" data-price="${product.price}" data-image="imagemProdutos/${product.id}.jpg">Adicionar ao Carrinho</button>
                `;
                productGrid.appendChild(productCard);
            });

            // Add event listeners to the "Adicionar ao Carrinho" buttons
            const addToCartButtons = document.querySelectorAll('.comprar');
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const product = {
                        id: this.dataset.id,
                        name: this.dataset.name,
                        price: this.dataset.price,
                        image: this.dataset.image
                    };
                    openModal(product);
                });
            });
        })
        .catch(error => console.error('Erro ao carregar produtos:', error));
});
