<?php
session_start();
require_once 'db_connect.php';

if (isset($_GET['id'])) {
    $producto_id = $_GET['id'];

    // Consulta el stock disponible
    $sql = "SELECT stock FROM productos WHERE id = $producto_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stock_disponible = $row['stock'];

        // Inicializa el carrito si no existe
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = array();
        }

        // Cantidad actual en el carrito
        $cantidad_actual = isset($_SESSION['carrito'][$producto_id]) ? $_SESSION['carrito'][$producto_id] : 0;

        // Verificar si hay suficiente stock
        if ($stock_disponible > $cantidad_actual) {
            // Agrega el producto al carrito o incrementa su cantidad si ya existe
            if (isset($_SESSION['carrito'][$producto_id])) {
                $_SESSION['carrito'][$producto_id]++;
            } else {
                $_SESSION['carrito'][$producto_id] = 1;
            }
            // Redirigir con éxito
            header('Location: ../../index.php?status=success');
        } else {
            // Redirigir con error de stock insuficiente
            header('Location: ../../index.php?status=error_stock');
        }
    } else {
        // Redirigir con error de producto no encontrado
        header('Location: ../../index.php?status=error_product');
    }
}
exit();
?>
