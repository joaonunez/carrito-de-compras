document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'success') {
        Swal.fire({
            icon: 'success',
            title: 'Producto añadido',
            text: 'El producto se ha añadido al carrito con éxito',
            showConfirmButton: true
        }).then(() => {
            // Eliminar el parámetro 'status' de la URL
            urlParams.delete('status');
            const newUrl = window.location.pathname + '?' + urlParams.toString();
            window.history.replaceState(null, '', newUrl);
        });
    } else if (status === 'error_stock') {
        Swal.fire({
            icon: 'error',
            title: 'Stock insuficiente',
            text: 'No hay suficiente stock disponible para añadir más de este producto.',
            showConfirmButton: true
        }).then(() => {
            // Eliminar el parámetro 'status' de la URL
            urlParams.delete('status');
            const newUrl = window.location.pathname + '?' + urlParams.toString();
            window.history.replaceState(null, '', newUrl);
        });
    } else if (status === 'error_limit') {
        Swal.fire({
            icon: 'info',
            title: 'Límite de stock alcanzado',
            text: 'Has alcanzado el límite de stock disponible para este producto.',
            showConfirmButton: true
        }).then(() => {
            // Eliminar el parámetro 'status' de la URL
            urlParams.delete('status');
            const newUrl = window.location.pathname + '?' + urlParams.toString();
            window.history.replaceState(null, '', newUrl);
        });
    }
});
