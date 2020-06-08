<?php

include_once "funciones/funciones.php";

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
// Boletos
$boletos_adquiridos = $_POST['boletos'];
// Camisas y etiquetas
$camisas = $_POST['pedido_extra']['camisas']['cantidad'];
$etiquetas = $_POST['pedido_extra']['etiquetas']['cantidad'];

$pedido = productos_json($boletos_adquiridos, $camisas, $etiquetas);

$total = $_POST['total_pedido'];
$regalo = $_POST['regalo'];
$eventos = $_POST['registro_evento'];
$registro_eventos = eventos_json($eventos);

$id_registro = $_POST['id_registro'];

if($_POST['registro'] == "nuevo" ){

    try {
        $stmt = $conn->prepare("INSERT INTO registrados (nombre_registrado, apellido_registrado, email_registrado, fecha_registro, pases_articulos, talleres_registrados, regalo, total_pagado, pagado) VALUES (?,?,?,NOW(),?,?,?,?,1)"); // prepare previene de ataques de inyeccion sql
        $stmt->bind_param("sssssis", $nombre, $apellido, $email, $pedido, $registro_eventos, $regalo, $total);
        $stmt->execute();
        $id_insertado = $stmt->insert_id;
        if($id_insertado > 0) {
            $respuesta = [
                'respuesta' => 'exito',
                'id_registrado' => $id_insertado
            ];
        } else {
            $respuesta = [
                'respuesta' => 'error'
            ];
        }
        $stmt->close();
        $conn->close();

    } catch(Exception $e) {
        $respuesta = [
            'respuesta' => $e->getMessage()
        ];
    }

    die(json_encode($respuesta));
}

if($_POST['registro'] == "actualizar" ){
    
    try {
        $stmt = $conn->prepare("UPDATE registrados SET nombre_registrado = ?, apellido_registrado = ?, email_registrado = ?, pases_articulos = ?, talleres_registrados = ?, regalo = ?, total_pagado = ?, pagado = 1 WHERE ID_registrado = ?");
        $stmt->bind_param('sssssisi', $nombre, $apellido, $email, $pedido, $registro_eventos, $regalo, $total, $id_registro);
        $stmt->execute();
        if($stmt->affected_rows) {
            $respuesta = [
                'respuesta' => 'exito',
                'id_actualizado' => $id_registro
            ];
        } else {
            $respuesta = [
                'respuesta' => 'error'
            ];
        }
        $stmt->close();
        $conn->close();

    } catch(Exception $e) {
        $respuesta = [
            'respuesta' => $e->getMessage()
        ];
    }

    die(json_encode($respuesta));
}

if($_POST['registro'] == "eliminar" ){
    
    $id_borrar = $_POST['id'];

    try {
        $stmt = $conn->prepare("DELETE FROM registrados WHERE ID_registrado = ?");
        $stmt->bind_param('i', $id_borrar);
        $stmt->execute();
        if($stmt->affected_rows) {
            $respuesta = [
                'respuesta' => 'exito',
                'id_eliminado' => $id_borrar
            ];
        } else {
            $respuesta = [
                'respuesta' => 'error'
            ];
        }
        $stmt->close();
        $conn->close();

    } catch(Exception $e) {
        $respuesta = [
            'respuesta' => $e->getMessage()
        ];
    }

    die(json_encode($respuesta));
}
