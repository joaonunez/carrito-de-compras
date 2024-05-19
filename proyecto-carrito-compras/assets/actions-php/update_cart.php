<?php
session_start();
require_once 'db_connect.php';

if (isset($_POST['id']) && isset($_POST['action'])) {
    $producto_id = $_POST['id'];
    $action = $_POST['action'];

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

        if ($action == 'increase') {
            // Verificar si hay suficiente stock
            if ($stock_disponible > $cantidad_actual) {
                $_SESSION['carrito'][$producto_id]++;
                $response_status = 'success';
            } else {
                $response_status = 'error_limit';
            }
        } elseif ($action == 'decrease') {
            $_SESSION['carrito'][$producto_id]--;
            if ($_SESSION['carrito'][$producto_id] <= 0) {
                unset($_SESSION['carrito'][$producto_id]);
            }
            $response_status = 'success';
        }
    } else {
        $response_status = 'error_product';
    }

    $response = array(
        'status' => $response_status,
        'total_carrito' => 0,
        'items' => array()
    );

    foreach ($_SESSION['carrito'] as $id => $cantidad) {
        $sql = "SELECT * FROM productos WHERE id = $id";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $total = $row['precio'] * $cantidad;
            $response['total_carrito'] += $total;
            $response['items'][] = array(
                'id' => $id,
                'nombre' => $row['nombre'],
                'descripcion' => $row['descripcion'],
                'cantidad' => $cantidad,
                'precio' => $row['precio'],
                'total' => $total
            );
        }
    }

    echo json_encode($response);
}
?>
