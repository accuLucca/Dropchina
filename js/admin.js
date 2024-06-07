document.addEventListener('DOMContentLoaded', function() {
    const addProductForm = document.getElementById('add-product-form');
    const deleteProductForm = document.getElementById('delete-product-form');

    addProductForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(addProductForm);
        fetch('admin.php', {
            method: 'POST',
            body: formData
        }).then(response => response.text()).then(result => {
            alert('Produto adicionado');
            location.reload();
        });
    });

    deleteProductForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(deleteProductForm);
        fetch('admin.php', {
            method: 'POST',
            body: formData
        }).then(response => response.text()).then(result => {
            alert('Produto removido');
            location.reload();
        });
    });
});
