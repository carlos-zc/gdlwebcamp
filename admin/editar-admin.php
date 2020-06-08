<?php 
  include_once "funciones/sesiones.php";
  include_once "funciones/funciones.php";
  include_once "templates/header.php";
  $id = $_GET['id'];

  if(!filter_var($id, FILTER_VALIDATE_INT)){
    // si el id del get no es un numero entero
    die("Error!");
  }
  if($_SESSION['nivel'] == 0 && $id != $_SESSION['id']){
    die("Error, no tienes los permisos necesarios para realizar esta acción");
  }
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
            <h1>Editar Administrador</h1>
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
              <h3 class="card-title">Editar Administrador</h3>
            </div>
            <div class="card-body">
              <?php 
                $sql = "SELECT * FROM admins WHERE id_admin = $id";
                $resultado = $conn->query($sql);
                $admin = $resultado->fetch_assoc();
              ?>
              <form role="form" name="guardar-registro" id="guardar-registro" method="POST" action="modelo-admin.php">
                <div class="card-body">
                  <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" value="<?= $admin['usuario'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre completo" value="<?= $admin['nombre'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña de inicio de sesión">
                  </div>
                  <div class="form-group">
                    <label for="password">Repetir Contraseña</label>
                    <input type="password" class="form-control" id="repetir_password" name="repetir_password" placeholder="Confirma la contraseña">
                    <span id="resultado_password" class="help-block"></span>
                  </div>
                  <!-- INPUT PARA SUBIR ARCHIVOS -->
                  <!-- <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                  </div> -->
                </div>
                <!-- /.card-body -->
        
                <div class="card-footer">
                  <input type="hidden" name="registro" value="actualizar">
                  <input type="hidden" name="id_registro" value="<?= $id ?>">
                  <button type="submit" class="btn btn-primary" id="crear_registro">Añadir</button>
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

