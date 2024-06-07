document.addEventListener('DOMContentLoaded', () => {
    const loginBtn = document.getElementById('login-btn');
    const loginDropdown = document.getElementById('login-dropdown');
    const signupBtn = document.getElementById('signup-btn');
    const loginForm = document.getElementById('login-form');
    const signupForm = document.getElementById('signup-form');
    const loginBtnBack = document.getElementById('login-btn-back');

    loginBtn.addEventListener('click', (e) => {
        e.preventDefault();
        loginDropdown.style.display = loginDropdown.style.display === 'block' ? 'none' : 'block';
    });

    signupBtn.addEventListener('click', () => {
        loginForm.style.display = 'none';
        signupForm.style.display = 'block';
    });

    loginBtnBack.addEventListener('click', () => {
        loginForm.style.display = 'block';
        signupForm.style.display = 'none';
    });
});

function login(event) {
    event.preventDefault();
    const formData = new FormData(event.target);

    fetch('php/login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);  // Adicionando logging para ver a resposta
        if (data.includes("Senha incorreta.") || data.includes("Usuário não encontrado.") || data.includes("Erro ao preparar a declaração SQL.") || data.includes("Método de requisição inválido.")) {
            alert(data);
        } else {
            window.location.href = data;
        }
    })
    .catch(error => console.error('Error:', error));
}

function loginCarrinho(event) {
    event.preventDefault();
    const formData = new FormData(event.target);

    fetch('../php/login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);  // Adicionando logging para ver a resposta
        if (data.includes("Senha incorreta.") || data.includes("Usuário não encontrado.") || data.includes("Erro ao preparar a declaração SQL.") || data.includes("Método de requisição inválido.")) {
            alert(data);
        } else {
            window.location.href = data;
        }
    })
    .catch(error => console.error('Error:', error));
}

function signup(event) {
    event.preventDefault();
    const formData = new FormData(event.target);

    fetch('php/cadastro.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        if (data === "Cadastro bem-sucedido") {
            loginForm.style.display = 'block';
            signupForm.style.display = 'none';
        }
    })
    .catch(error => console.error('Error:', error));
}

function signupCarrinho(event) {
    event.preventDefault();
    const formData = new FormData(event.target);

    fetch('../php/cadastro.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        if (data === "Cadastro bem-sucedido") {
            loginForm.style.display = 'block';
            signupForm.style.display = 'none';
        }
    })
    .catch(error => console.error('Error:', error));
}

// Carrinho de compra
// Get modal elements
var modal = document.getElementById("productModal");
var span = document.getElementsByClassName("close")[0];

// Function to open modal when button is clicked
function openModal(product) {
    var modalProductImage = document.getElementById("modalProductImage");
    var modalProductName = document.getElementById("modalProductName");
    var modalProductPrice = document.getElementById("modalProductPrice");

    if (modalProductImage && modalProductName && modalProductPrice) {
        modalProductImage.innerHTML = '<img src="' + product.image + '" alt="' + product.name + '">';
        modalProductName.innerText = product.name;
        modalProductPrice.innerText = 'R$' + product.price;
        modal.style.display = "block";
    } else {
        console.error("Modal elements not found");
    }
}

// Close modal when the close button is clicked
span.onclick = function() {
    modal.style.display = "none";
}

// Close modal when user clicks outside of it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Add product to cart
document.getElementById("addToCartButton").onclick = function() {
    var productName = document.getElementById("modalProductName").innerText;
    var productPrice = document.getElementById("modalProductPrice").innerText.replace('R$', '');

    // Make AJAX request to add product to cart
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "php/addCarrinho.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.status === "success") {
                alert(response.message);
                modal.style.display = "none";
            } else {
                alert(response.message);
            }
        }
    };
    xhr.send("name=" + encodeURIComponent(productName) + "&price=" + encodeURIComponent(productPrice));
};
