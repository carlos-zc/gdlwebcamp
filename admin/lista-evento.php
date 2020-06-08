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
            <h1>Listado de Eventos</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Maneja los eventos en esta sección</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="registros" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Fecha</th>
                  <th>Hora</th>
                  <th>Categoría</th>
                  <th>Invitado</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                    try {
                      $sql = "SELECT evento_id, nombre_evento, fecha_evento, hora_evento, cat_evento, nombre_invitado, apellido_invitado ";
                      $sql .= " FROM eventos ";
                      $sql .= " INNER JOIN categoria_evento ";
                      $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria ";
                      $sql .= " INNER JOIN invitados ";
                      $sql .= " ON eventos.id_inv = invitados.invitado_id ";
                      $sql .= " ORDER BY evento_id";
                      $resultado = $conn->query($sql);
                    } catch(Exception $e) {
                      echo "Error: ". $e.getMessage();
                    }
                    while($evento = $resultado->fetch_assoc()) { ?>
                      <tr>
                        <td><?= $evento['nombre_evento']?></td>
                        <td><?= $evento['fecha_evento']?></td>
                        <td><?= $evento['hora_evento']?></td>
                        <td><?= $evento['cat_evento']?></td>
                        <td><?= $evento['nombre_invitado']. " ". $evento['apellido_invitado']?></td>
                        <td>
                          <a href="editar-evento.php?id=<?= $evento['evento_id'] ?>" class="btn bg-orange btn-flat mr-3">
                            <i class="fas fa-edit text-white"></i>
                          </a>

                          <a href="#" data-id="<?= $evento['evento_id']?>" data-tipo="evento" class="btn bg-maroon btn-flat margin borrar-registro">
                            <i class="fas fa-trash text-white"></i>
                          </a>
                        </td>
                      </tr>
                  <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nombre</th>
                  <th>Fecha</th>
                  <th>Hora</th>
                  <th>Categoría</th>
                  <th>Invitado</th>
                  <th>Acciones</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include_once "templates/footer.php"; ?>

