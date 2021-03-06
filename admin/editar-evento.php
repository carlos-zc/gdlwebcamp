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
            <h1>Editar Evento</h1>
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
              <h3 class="card-title">Editar Evento</h3>
            </div>
            <div class="card-body">
              <?php 
                $sql = "SELECT * FROM eventos WHERE evento_id = $id";
                $resultado = $conn->query($sql);
                $evento = $resultado->fetch_assoc();
              ?>
              <form role="form" name="guardar-registro" id="guardar-registro" method="POST" action="modelo-evento.php">
                <div class="card-body">
                  <div class="form-group">
                    <label for="usuario">Título Evento</label>
                    <input type="text" class="form-control" id="titulo_evento" name="titulo_evento" placeholder="Título del evento" value="<?= $evento['nombre_evento'] ?>">
                  </div>

                  <div class="form-group">
                    <label for="nombre">Categoría</label>
                    <select name="categoria_evento" class="form-control seleccionar">
                        <option value="0">- Seleccionar -</option>
                        <?php 
                        try {
                          $categoria_actual = $evento['id_cat_evento'];
                          $sql= "SELECT * FROM categoria_evento";
                          $resultado = $conn->query($sql);
                          while($cat_evento = $resultado->fetch_assoc()){ 
                            if($cat_evento['id_categoria'] == $categoria_actual){ ?>
                              <option value="<?= $cat_evento['id_categoria'] ?>" selected>
                            <?php } else { ?>
                              <option value="<?= $cat_evento['id_categoria'] ?>">
                            <?php } ?> <!-- Fin del if -->

                                  <?= $cat_evento['cat_evento'] ?>
                              </option>
                          <?php } // Fin del while
                        } catch(Exception $e) {
                            echo "Error: ". $e->getMessage();
                        }
                        ?>
                    </select>
                  </div>

                  <!-- Date range -->
                  <div class="form-group">
                    <label>Fecha</label>
                    <?php 
                      $fecha = $evento['fecha_evento'];
                      $fecha_formato = date('d/m/Y', strtotime($fecha));

                    ?>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control float-right" id="fecha" name="fecha_evento" value="<?= $fecha_formato ?>">
                    </div>
                  </div>

                  <!-- time Picker -->
                  <div class="bootstrap-timepicker">
                    <div class="form-group">
                        <label>Hora</label>
                        <?php 
                          $hora = $evento['hora_evento'];
                          $hora_formato = date('h:i a', strtotime($hora));
                        
                        ?>
                        <div class="input-group date" id="timepicker" data-target="#timepicker" data-toggle="datetimepicker" data-target-input="nearest">
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                            </div>
                            <input type="text" class="form-control datetimepicker-input" data-target="#timepicker" name="hora_evento" value="<?= $hora_formato ?>">
                        </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="nombre">Invitado o Ponente</label>
                    <select name="invitado_evento" class="form-control seleccionar">
                        <option value="0">- Seleccionar -</option>
                        <?php 
                        try {
                          $invitado_actual = $evento['id_inv'];
                          $sql= "SELECT invitado_id, nombre_invitado, apellido_invitado FROM invitados";
                          $resultado = $conn->query($sql);
                          while($invitado = $resultado->fetch_assoc()){ 
                            if($invitado['invitado_id'] == $invitado_actual) { ?>
                              <option value="<?= $invitado['invitado_id'] ?>" selected>
                            <?php } else { ?>
                              <option value="<?= $invitado['invitado_id'] ?>">
                            <?php } ?> <!-- Fin del if -->

                                  <?= $invitado['nombre_invitado']. " ". $invitado['apellido_invitado'] ?>
                              </option>
                          <?php } // Fin del while
                        } catch(Exception $e) {
                          echo "Error: ". $e->getMessage();
                        }
                        ?>
                    </select>
                  </div>

                </div>
                <!-- /.card-body -->
        
                <div class="card-footer">
                  <input type="hidden" name="registro" value="actualizar">
                  <input type="hidden" name="id_registro" value="<?= $id ?>">
                  <button type="submit" class="btn btn-primary">Guardar</button>
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

