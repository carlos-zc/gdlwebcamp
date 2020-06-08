<?php 
  include_once "funciones/sesiones.php";
  include_once "funciones/funciones.php";
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
            <h1>Crear Categorías de Eventos</h1>
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
              <h3 class="card-title">Crear Categoría</h3>
            </div>
            <div class="card-body">
              <form role="form" name="guardar-registro" id="guardar-registro" method="POST" action="modelo-categoria.php">
                <div class="card-body">
                  <div class="form-group">
                    <label for="nombre_categoria">Nombre</label>
                    <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" placeholder="Categoría">
                  </div>
                  <div class="form-group">
                    <label for="icono">Icono</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <div class="input-group-addon"><i class="fa fa-address-book"></i></div>
                        </div>
                      </div>
                      <input type="text" id="icono" name="icono" class="form-control pull-right" placeholder="fa-icon">
                    </div>
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
                  <input type="hidden" name="registro" value="nuevo">
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

