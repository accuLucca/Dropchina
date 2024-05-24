// Função para adicionar produtos à tabela do carrinho
function adicionarProdutoCarrinho(produto) {
    // Crie uma linha para o produto
    const linha = document.createElement('tr');

    // Crie as células para cada propriedade do produto
    const celulaImagem = document.createElement('td');
    const imagem = document.createElement('img');
    imagem.src = produto.imagem;
    imagem.alt = produto.nome;
    celulaImagem.appendChild(imagem);

    const celulaNome = document.createElement('td');
    celulaNome.textContent =
