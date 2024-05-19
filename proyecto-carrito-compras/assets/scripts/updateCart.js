document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.update-cart').forEach(function(button) {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const action = this.getAttribute('data-action');

            fetch('assets/actions-php/update_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}&action=${action}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    location.reload(); // Recargar la página para reflejar los cambios
                } else if (data.status === 'error_stock') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Stock insuficiente',
                        text: 'No hay suficiente stock disponible para añadir más de este producto.',
                        showConfirmButton: true
                    });
                } else if (data.status === 'error_limit') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Límite de stock alcanzado',
                        text: 'Has alcanzado el límite de stock disponible para este producto.',
                        showConfirmButton: true
                    });
                } else {
                    console.error('Error al actualizar el carrito');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
