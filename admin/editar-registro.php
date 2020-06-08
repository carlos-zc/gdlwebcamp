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
            <h1>Editar Registro de Visitante Manual</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <div class="row ml-md-1 mr-0">
      <div class="col-md-10">
        <!-- Main content -->
        <section class="content">
        
          <!-- Default box -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Editar Registro</h3>
            </div>
            <div class="card-body">
              <?php 
                $sql = "SELECT * FROM registrados WHERE ID_registrado = $id";
                $resultado = $conn->query($sql);
                $registrado = $resultado->fetch_assoc();
              ?>
              <form role="form" name="guardar-registro" id="guardar-registro" method="POST" action="modelo-registrado.php">
                <div class="card-body">
                
                  <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?= $registrado['nombre_registrado'] ?>">
                  </div>

                  <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" value="<?= $registrado['apellido_registrado'] ?>">
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?= $registrado['email_registrado'] ?>">
                  </div>
                  <div id="error"></div>
                  <?php 
                    $pedido = $registrado['pases_articulos'];
                    $boletos = json_decode($pedido, true);
                  
                  ?>
                  <br>

                  <div class="form-group">
                    <div class="box-header with-border">
                        <h4 class="box-title">Elige el número de boletos</h4>
                    </div>
                    <br>
                    <div id="paquetes" class="paquetes">
                        <ul class="lista-precios clearfix row">
                            <li class="col-md-4">
                                <div class="tabla-precio text-center">
                                    <h3>Pase por dia (viernes)</h3>
                                    <p class="numero">$30</p>
                                    <ul>
                                        <li>Bocadillos gratis</li>
                                        <li>Todas las conferencias</li>
                                        <li>Todos los talleres</li>
                                    </ul>
                                    <div class="orden">
                                        <label for="pase_dia">Boletos deseados:</label>
                                        <input type="number" class="form-control" id="pase_dia" min="0" size="3" name="boletos[un_dia][cantidad]" placeholder="0" value="<?= $boletos['un_dia'] ?>">
                                        <input type="hidden" value="30" name="boletos[un_dia][precio]">
                                    </div>
                                </div>
                            </li>
                            
                            <li class="col-md-4">
                                <div class="tabla-precio text-center">
                                    <h3>Todos los dias</h3>
                                    <p class="numero">$50</p>
                                    <ul>
                                        <li>Bocadillos gratis</li>
                                        <li>Todas las conferencias</li>
                                        <li>Todos los talleres</li>
                                    </ul>
                                    <div class="orden">
                                        <label for="pase_completo">Boletos deseados:</label>
                                        <input type="number" class="form-control" id="pase_completo" min="0" size="3" name="boletos[completo][cantidad]" placeholder="0" value="<?= $boletos['pase_completo'] ?>">
                                        <input type="hidden" value="50" name="boletos[completo][precio]">
                                    </div>
                                </div>
                            </li>
                            
                            <li class="col-md-4">
                                <div class="tabla-precio text-center">
                                    <h3>Pase por 2 dias (viernes y sábado)</h3>
                                    <p class="numero">$45</p>
                                    <ul>
                                        <li>Bocadillos gratis</li>
                                        <li>Todas las conferencias</li>
                                        <li>Todos los talleres</li>
                                    </ul>
                                    <div class="orden">
                                        <label for="pase_dosdias">Boletos deseados:</label>
                                        <input type="number" class="form-control" id="pase_dosdias" min="0" size="3" name="boletos[dos_dias][cantidad]" placeholder="0" value="<?= $boletos['pase_2dias'] ?>">
                                        <input type="hidden" value="45" name="boletos[dos_dias][precio]">
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div> <!-- #paquetes -->
                  </div><!-- .form-group -->

                  <div class="form-group">
                    <div class="box-header whith-border">
                      <h4 class="box-title">Elige los Talleres</h4>
                    </div>
                    <br>
                    <div id="eventos" class="eventos clearfix">
                        <div class="caja">
                          <?php 
                              $eventos = $registrado['talleres_registrados'];
                              $id_eventos_registrados = json_decode($eventos, true);

                              try {
                                  $sql = "SELECT eventos.*, categoria_evento.cat_evento, invitados.nombre_invitado, invitados.apellido_invitado";
                                  $sql .= " FROM eventos JOIN categoria_evento";
                                  $sql .= " ON eventos.id_cat_evento = categoria_evento.id_categoria";
                                  $sql .= " JOIN invitados";
                                  $sql .= " ON eventos.id_inv = invitados.invitado_id";
                                  $sql .= " ORDER BY eventos.fecha_evento, eventos.id_cat_evento, eventos.hora_evento";
                                  $resultado = $conn->query($sql);
                              } catch(Exception $e) {
                                  echo 'Error: '. $e-getMessage();
                              }

                              $eventos_dia = [];
                              while ($eventos = $resultado->fetch_assoc()) {
                                  $fecha = $eventos['fecha_evento'];
                                  // cambia el idioma para las fechas
                                  setlocale(LC_ALL, 'es-ES');
                                  // utf-8 para quitar problemas con acentos
                                  // srtftime para cambiar el formato de la fecha
                                  $dia_semana = utf8_encode(strftime("%A", strtotime($fecha)));

                                  $categoria = $eventos['cat_evento'];
                                  $dia = [
                                      'nombre_evento' => $eventos['nombre_evento'],
                                      'hora_evento' => $eventos['hora_evento'],
                                      'id' => $eventos['evento_id'],
                                      'clave' => $eventos['clave'],
                                      'nombre_invitado' => $eventos['nombre_invitado'],
                                      'apellido_invitado' => $eventos['apellido_invitado']
                                  ];
                                  $eventos_dia[$dia_semana]['eventos'][$categoria][] = $dia;
                              }
                          
                            ?>
                            <?php foreach($eventos_dia as $dia => $eventos) { ?>
                            <div id="<?= str_replace('á', 'a', $dia) ?>" class="contenido-dia clearfix">
                                <h4 class="text-center nombre-dia"><?= $dia ?></h4>
                                  <div class="row">
                                    <?php foreach($eventos['eventos'] as $tipo => $evento_dia): ?>
                                      <div class="col-md-4">
                                          <p><?= $tipo ?></p>
                                          <?php foreach($evento_dia as $evento)  { ?>
                                            <div class="icheck-primary d-inline">
                                              <input <?php echo (in_array($evento['clave'], $id_eventos_registrados['eventos']) ? 'checked' : '') ?> type="checkbox" name="registro_evento[]" id="<?= $evento['id'] ?>" value="<?= $evento['clave'] ?>">
                                              <label for="<?= $evento['id'] ?>">
                                                <time><?= $evento['hora_evento'] ?></time> <?= $evento['nombre_evento'] ?>
                                                <br>
                                                <span class="autor"><?= $evento['nombre_invitado']. " ". $evento['apellido_invitado'] ?></span>
                                              </label>
                                            </div>
                                          
                                          <?php } // Fin foreach ?>
                                      </div>
                                    <?php endforeach; ?>
                                  </div>
                            </div> <!--.contenido-dia-->
                            <?php } // Fin foreach ?>
                        </div><!--.caja-->
                    </div> <!--#eventos-->
                  </div>

                  <div class="form-group">
                    <div class="box-header with-border">
                        <h4 class="box-title">Pago y Extras</h4>
                    </div>
                    <br>
                    <div id="resumen" class="resumen clearfix">
                        <div class="caja clearfix row">
                            <div class="extras col-md-6">
                                <div class="orden">
                                    <label for="camisa_evento">Camisa del evento $10 <small>(promoción 7% dto.)</small></label>
                                    <input type="number"class="form-control" min="0" id="camisa_evento" name="pedido_extra[camisas][cantidad]" size="3" placeholder="0" value="<?= $boletos['camisas'] ?>">
                                    <input type="hidden" value="10" name="pedido_extra[camisas][precio]">
                                </div> <!-- .orden -->

                                <div class="orden">
                                    <label for="etiquetas">Paquetes de 10 etiquetas $2 <small>(HTML5, CSS3, JavaScript, Chrome)</small></label>
                                    <input type="number"class="form-control" min="0" id="etiquetas" name="pedido_extra[etiquetas][cantidad]" size="3" placeholder="0" value="<?= $boletos['etiquetas'] ?>">
                                    <input type="hidden" value="2" name="pedido_extra[etiquetas][precio]">
                                </div> <!-- .orden -->

                                <div class="orden col-md-6">
                                    <label for="regalo">Seleccione un regalo</label> <br>
                                    <select id="regalo" name="regalo" class="form-control seleccionar" required>
                                        <option value="">- Seleccione un regalo -</option>
                                        <option value="1" <?= ($registrado['regalo'] == 1 ) ? 'selected' : '' ?> >Pulseras</option>
                                        <option value="2" <?= ($registrado['regalo'] == 2 ) ? 'selected' : '' ?> >Etiquetas</option>
                                        <option value="3" <?= ($registrado['regalo'] == 3 ) ? 'selected' : '' ?> >Plumas</option>
                                    </select>
                                </div> <!-- .orden -->
                                <br>
                                <input type="button" id="calcular" class="btn btn-success" value="Calcular">
                                
                            </div> <!-- .extras -->

                            <div class="total ml-5 mt-3 mt-md-0">
                                <p>Resumen</p>
                                <div id="lista-productos"></div>

                                <p>Total ya pagado: <?= $registrado['total_pagado'] ?></p>
                                <p>Total:</p>
                                <div id="suma-total"></div>

                            </div> <!-- .total -->
                        </div> <!-- .caja -->
                    </div>
                  </div>

                </div>
                <!-- /.card-body -->
        
                <div class="card-footer">
                  <input type="hidden" name="total_pedido" id="total_pedido">
                  <input type="hidden" name="registro" value="actualizar">
                  <input type="hidden" name="id_registro" value="<?= $id ?>">
                  <input type="hidden" name="fecha_registro" value="<?= $registrado['fecha_registro'] ?>">
                  <button type="submit" class="btn btn-primary" id="btnRegistro">Guardar</button>
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

