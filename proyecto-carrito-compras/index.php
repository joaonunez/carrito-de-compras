<?php
session_start();
require_once 'assets/actions-php/db_connect.php';

function getImagePath($id) {
    $jpgPath = "assets/imagenes-productos/$id.jpg";
    if (file_exists($jpgPath)) {
        return $jpgPath;
    } else {
        return "assets/imagenes-productos/default.jpg"; // Imagen por defecto si no se encuentra ninguna
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="assets/css/mainstyles.css">
</head>
<body>
    <div class="container contenedor-catalogo">
        <h1 class="my-4">Tienda Online</h1>
        <div class="row fila-productos">
            <?php
            $sql = "SELECT * FROM productos";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $imagePath = getImagePath($row["id"]);
                    echo '<div class="col-lg-3 col-md-4 col-sm-6 mb-4">';
                    echo '<div class="card">';
                    echo '<img src="' . $imagePath . '" class="card-img-top imagen-carrito" alt="' . $row["nombre"] . '" style="width: 200px; height: 200px;">';
                    echo '<div class="card-body cuerpo-tarjeta">';
                    echo '<h5 class="card-title">' . $row["nombre"] . '</h5>';
                    echo '<p class="card-text">' . $row["descripcion"] . '</p>';
                    echo '<p class="card-text">Cantidad Disponible: ' . $row["stock"] . '</p>';
                    echo '<p class="card-text">$' . $row["precio"] . '</p>';
                    echo '<a href="assets/actions-php/add_to_cart.php?id=' . $row["id"] . '" class="btn btn-primary boton-añadir-al-carrito">Agregar al carrito</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No hay productos disponibles.";
            }

            $conn->close();
            ?>
        </div>
        <a href="cart.php" class="btn btn-success boton-ver-carrito">Ir al Carrito</a>
    </div>

    <!-- Botón fijo para ver el carrito -->
    <a href="cart.php" class="btn  ver-carrito-flotante">Ver Carrito</a>

    <script src="assets/scripts/productoAgregado.js"></script>
    <script src="assets/scripts/updateCart.js"></script> 

</body>
</html>
