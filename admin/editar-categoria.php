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
            <h1>Editar Categorías de Eventos</h1>
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
              <h3 class="card-title">Editar Categoría</h3>
            </div>
            <div class="card-body">
              <?php 
                $sql = "SELECT * FROM categoria_evento WHERE id_categoria = $id";
                $resultado = $conn->query($sql);
                $categoria = $resultado->fetch_assoc();
              ?>
              <form role="form" name="guardar-registro" id="guardar-registro" method="POST" action="modelo-categoria.php">
                <div class="card-body">
                  <div class="form-group">
                    <label for="nombre_categoria">Nombre</label>
                    <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" placeholder="Categoría" value="<?= $categoria['cat_evento'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="icono">Icono</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <div class="input-group-addon"><i class="fa fa-address-book"></i></div>
                        </div>
                      </div>
                      <input type="text" id="icono" name="icono" class="form-control pull-right" placeholder="fa-icon" value="<?= $categoria['icono'] ?>">
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

