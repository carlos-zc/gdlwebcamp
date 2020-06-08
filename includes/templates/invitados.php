<?php
    try {
        require_once('includes/funciones/bd_conexion.php');
        $sql = 'SELECT * FROM invitados ';
        
        $resultado = $conn->query($sql);
    } catch(Exception $e) {
        echo $e->getMessage(); // mensaje de error en caso de no conectar db
    }
?>

<section class="invitados contenedor seccion">
    <h2>Nuestros Invitados</h2>
    <ul class="lista-invitados clearfix">

    <?php 
    while( $invitados = $resultado->fetch_assoc()){ // Trae los datos en un array donde se usa campo y valor ?>
            <li>
                <div class="invitado">
                    <a class="invitado-info" href="#invitado<?php echo $invitados['invitado_id']; ?>">
                        <img src="img/invitados/<?php echo $invitados['url_imagen']?>" alt="Imagen invitado">
                        <p><?php echo $invitados['nombre_invitado']. " ". $invitados['apellido_invitado']?></p>
                    </a>
                </div>
            </li>

            <div style="display: none;">
                <div class="invitado-info" id="invitado<?php echo $invitados['invitado_id']; ?>">
                    <h2><?php echo $invitados['nombre_invitado']. " ". $invitados['apellido_invitado']?></h2>
                    <img src="img/invitados/<?php echo $invitados['url_imagen']?>" alt="Imagen invitado">
                    <p><?php echo $invitados['descripcion']?></p>
                </div> 
            </div>

    <?php } // Fin del while ?>
    </ul>
</section>

<?php
    $conn->close();
?>