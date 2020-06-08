<?php 

if(isset($_POST['login-admin']) ){

    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    try {
        include_once "funciones/funciones.php";
        $stmt = $conn->prepare("SELECT * FROM admins WHERE usuario = ? ");
        $stmt->bind_param('s', $usuario);
        $stmt->execute();
        $stmt->bind_result($id_admin, $usuario_admin, $nombre_admin, $password_admin, $editado, $nivel); // guarda en variables los datos recibidos en el orden que se pidieron
        
        if($stmt->affected_rows) {
            $existe = $stmt->fetch();
            if($existe) {
                // Existe el usuario
                if(password_verify($password, $password_admin) ) {
                    // La contraseña tambien es correcta
                    session_start();
                    $_SESSION['usuario'] = $usuario_admin;
                    $_SESSION['nombre'] = $nombre_admin;
                    $_SESSION['nivel'] = $nivel;
                    $_SESSION['id'] = $id_admin;
                    $respuesta = [
                        'respuesta' => 'exito',
                        'nombre' => $nombre_admin
                    ];
                } else {
                    // Contraseña incorrecta
                    $respuesta = [
                        'respuesta' => 'error'
                    ];
                }

            } else {
                // No existe el usuario
                $respuesta = [
                    'respuesta' => 'error'
                ];
            }
            
        } 
        $stmt->close();
        $conn->close();

    } catch(Exception $e) {
        echo "Error: ". $e->getMessage();
    }

    die(json_encode($respuesta));
}