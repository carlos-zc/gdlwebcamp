<?php

include_once "funciones/funciones.php";
$usuario = $_POST['usuario'];
$nombre = $_POST['nombre'];
$password = $_POST['password'];
$id_registro = $_POST['id_registro'];

if($_POST['registro'] == "nuevo" ){

    $opciones = [
        'cost' => 12
    ];
    $password_hashed = password_hash($password, PASSWORD_BCRYPT, $opciones);

    try {
        $stmt = $conn->prepare("INSERT INTO admins (usuario, nombre, password) VALUES (?,?,?)");
        $stmt->bind_param('sss', $usuario, $nombre, $password_hashed);
        $stmt->execute();
        $id_registro = $stmt->insert_id;
        if($id_registro > 0) {
            $respuesta = [
                'respuesta' => 'exito',
                'id_admin' => $id_registro
            ];
        } else {
            $respuesta = [
                'respuesta' => 'error'
            ];
        }
        $stmt->close();
        $conn->close();

    } catch(Exception $e) {
        echo "Error: ". $e->getMessage();
    }

    die(json_encode($respuesta));
}

if($_POST['registro'] == "actualizar" ){
    
    

    try {
        if(empty($_POST['password']) ) {
            // si el campo password viene vacio, no se cambiara la contraseña
            $stmt = $conn->prepare("UPDATE admins SET usuario = ?, nombre = ?, editado = NOW() WHERE id_admin = ?");
            $stmt->bind_param('ssi', $usuario, $nombre, $id_registro);

        } else {
            $opciones = [
                'cost' => 12
            ];
            $password_hashed = password_hash($password, PASSWORD_BCRYPT, $opciones);
            // Actualiza la contraseña
            $stmt = $conn->prepare("UPDATE admins SET usuario = ?, nombre = ?, password = ?, editado = NOW() WHERE id_admin = ?");
            $stmt->bind_param('sssi', $usuario, $nombre, $password_hashed, $id_registro);
        }
        $stmt->execute();
        $id_insertado = $stmt->insert_id;
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
        $stmt = $conn->prepare("DELETE FROM admins WHERE id_admin = ?");
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
