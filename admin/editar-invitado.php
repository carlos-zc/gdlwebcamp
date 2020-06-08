<?php 
  include_once "funciones/sesiones.php";
  include_once "funciones/funciones.php";
  $id = $_GET['id'];

  if(!filter_var($id, FILTER_VALIDATE_INT)){
    // si el id del get no es un numero entero
    die("Error!");
  }
  include_once "templates/header.php";
  include_once "templates/barra.php";
  include_once "templates/navegacion.php";
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Editar Invitado</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <div class="row ml-md-1 mr-0">
      <div class="col-md-8">
        <!-- Main content -->
        <section class="content">
        
          <!-- Default box -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Editar Invitado</h3>
            </div>
            <div class="card-body">
              <?php 
                $sql = "SELECT * FROM invitados WHERE invitado_id = $id";
                $resultado = $conn->query($sql);
                $invitado = $resultado->fetch_assoc();
              ?>
              <form role="form" name="guardar-registro" id="guardar-registro-archivo" method="POST" action="modelo-invitado.php" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="nombre_invitado">Nombre</label>
                    <input type="text" class="form-control" id="nombre_invitado" name="nombre_invitado" placeholder="Nombre del invitado" value="<?= $invitado['nombre_invitado'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="apellido_invitado">Apellido</label>
                    <input type="text" class="form-control" id="apellido_invitado" name="apellido_invitado" placeholder="Apellido del invitado" value="<?= $invitado['apellido_invitado'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="icono">Biografía</label>
                    <textarea id="biografia_invitado" name="biografia_invitado" class="form-control" rows="5" placeholder="Descripción ..."><?= $invitado['descripcion'] ?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="imagen-actual">Imagen Actual</label>
                    <br/>
                    <img src="../img/invitados/<?= $invitado['url_imagen'] ?>" id="imagen-actual" class="imagen-invitado rounded" alt="Imagen del invitado">
                  </div>
                  
                  <!-- INPUT PARA SUBIR ARCHIVOS -->
                  <div class="form-group">
                    <label for="imagen_invitado">Imagen</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="archivo_imagen" class="custom-file-input" id="imagen_invitado" accept="image/*">
                        <label class="custom-file-label" for="imagen_invitado"><?= $invitado['url_imagen'] ?></label>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
        
                <div class="card-footer">
                  <input type="hidden" name="registro" value="actualizar">
                  <input type="hidden" name="id_registro" value="<?= $id ?>">
                  <button type="submit" class="btn btn-primary" id="crear_registro">Guardar</button>
                </div>
              </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        
        </section>
        <!-- /.content -->
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->

  <?php include_once "templates/footer.php"; ?>

