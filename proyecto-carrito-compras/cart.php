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
    <title>Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <link rel="stylesheet" href="assets/css/mainstyles.css">
</head>
<body>
    <div class="container contenedor-carrito">
        <h1 class="my-4">Carrito de Compras</h1>
        <div class="row">
            <div class="col-12">
                <?php
                if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
                    echo '<table class="table table-bordered mi-table">';
                    echo '<thead>';
                    echo '<tr class="fila-titulo">';
                    echo '<th>Imagen</th>';
                    echo '<th>Producto</th>';
                    echo '<th>Cantidad</th>';
                    echo '<th>Precio</th>';
                    echo '<th>Total</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';

                    $total_carrito = 0;
                    foreach ($_SESSION['carrito'] as $id => $cantidad) {
                        $sql = "SELECT * FROM productos WHERE id = $id";
                        $result = $conn->query($sql);
                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();

                            $total = $row['precio'] * $cantidad;
                            $total_carrito += $total;

                            $imagePath = getImagePath($row["id"]);
                            echo '<tr class="fila-descripcion">';
                            echo '<td><img src="' . $imagePath . '" alt="' . $row["nombre"] . '" style="width: 50px; height: 50px;"></td>';
                            echo '<td class="descripcion"><p>' . $row['nombre'] . '</p><p>' . $row['descripcion'] . '</p></td>';
                            echo '<td class="descripcion">
                                <div class="d-flex align-items-center justify-content-center">
                                    <button class="btn btn-sm btn-danger update-cart" data-id="' . $id . '" data-action="decrease">-</button>
                                    <p class="mx-2 my-0">' . $cantidad . '</p>
                                    <button class="btn btn-sm btn-success update-cart" data-id="' . $id . '" data-action="increase">+</button>
                                </div>
                          </td>';
                            echo '<td class="descripcion"><p>$' . $row['precio'] . '</p></td>';
                            echo '<td class="descripcion"><p>$' . $total . '</p></td>';
                            echo '</tr>';
                        }
                    }

                    echo '<tr>';
                    echo '<td colspan="4" class="descripcion"><p>Total del Carrito</p></td>';
                    echo '<td class="descripcion"><p>$' . $total_carrito . '</p></td>';
                    echo '</tr>';
                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo '<p>No hay productos en el carrito.</p>';
                }

                $conn->close();
                ?>
            </div>
        </div>
        <a href="index.php" class="btn btn-primary boton-seguir-comprando">Seguir comprando</a>
    </div>
    <script src="assets/scripts/productoAgregado.js"></script>
    <script src="assets/scripts/updateCart.js"></script> <!-- Incluye el nuevo archivo JS -->
</body>
</html>
