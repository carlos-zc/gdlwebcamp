<?php

include_once "funciones/funciones.php";
$nombre_invitado = $_POST['nombre_invitado'];
$apellido_invitado = $_POST['apellido_invitado'];
$biografia_invitado = $_POST['biografia_invitado'];

$id_registro = $_POST['id_registro'];

if($_POST['registro'] == "nuevo" ){

    // $respuesta = [
    //     'post' => $_POST,
    //     'files' => $_FILES
    // ];
    // die(json_encode($respuesta));

    $directorio = "../img/invitados/";
    if(!is_dir($directorio)){
        // si no existe la ruta, la crea
        mkdir($directorio, 0755, true);
    }

    if(move_uploaded_file($_FILES['archivo_imagen']['tmp_name'], $directorio. $_FILES['archivo_imagen']['name']) ) {
        $imagen_url = $_FILES['archivo_imagen']['name'];
        $imagen_resultado = "Se subio correctamente";
    } else {
        $respuesta = [
            'respuesta' => error_get_last()
        ];
    }

    try {
        $stmt = $conn->prepare("INSERT INTO invitados (nombre_invitado, apellido_invitado, descripcion, url_imagen) VALUES (?,?,?,?)");
        $stmt->bind_param('ssss', $nombre_invitado, $apellido_invitado, $biografia_invitado, $imagen_url);
        $stmt->execute();
        $id_insertado = $stmt->insert_id;
        if($id_insertado > 0) {
            $respuesta = [
                'respuesta' => 'exito',
                'id_evento' => $id_insertado,
                'resultado_imagen' => $imagen_resultado
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
    
    $directorio = "../img/invitados/";
    if(!is_dir($directorio)){
        // si no existe la ruta, la crea
        mkdir($directorio, 0755, true);
    }

    if(move_uploaded_file($_FILES['archivo_imagen']['tmp_name'], $directorio. $_FILES['archivo_imagen']['name']) ) {
        $imagen_url = $_FILES['archivo_imagen']['name'];
        $imagen_resultado = "Se subio correctamente";
    } else {
        $respuesta = [
            'respuesta' => error_get_last()
        ];
    }

    try {

        if($_FILES['archivo_imagen']['size'] > 0 ) {
            // Con imagen
            $stmt = $conn->prepare("UPDATE invitados SET nombre_invitado = ?, apellido_invitado = ?, descripcion = ?, url_imagen = ?, editado = NOW() WHERE invitado_id = ?");
            $stmt->bind_param('ssssi', $nombre_invitado, $apellido_invitado, $biografia_invitado, $imagen_url, $id_registro);
        } else {
            // Sin imagen
            $stmt = $conn->prepare("UPDATE invitados SET nombre_invitado = ?, apellido_invitado = ?, descripcion = ?, editado = NOW() WHERE invitado_id = ?");
            $stmt->bind_param('sssi', $nombre_invitado, $apellido_invitado, $biografia_invitado, $id_registro);
        }
        
        $stmt->execute();
        if($stmt->affected_rows) {
            $respuesta = [
                'respuesta' => 'exito',
                'id_actualizado' => $id_registro,
                'nueva_imagen' => $imagen_url // se pasa nulo si no se cambio la imagen
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
        $stmt = $conn->prepare("DELETE FROM invitados WHERE invitado_id = ?");
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
