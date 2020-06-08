<?php include_once 'includes/templates/header.php'; ?>

    <section class="seccion contenedor">
        <h2>Registro de usuarios</h2>
        <form id="registro" class="registro" action="pagar.php" method="POST">
            <div id="datos_usuario" class="registro caja clearfix">
                <div class="campo">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Tu nombre">
                </div>
                <div class="campo">
                    <label for="apellido">Apellido:</label>
                    <input type="text" id="apellido" name="apellido" placeholder="Tu apellido">
                </div>
                <div class="campo">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Tu email">
                </div>
                <div id="error"></div>

            </div> <!-- #datos_usuarios -->

            <div id="paquetes" class="paquetes">
                <h3>Elige el numero de boletos</h3>

                <ul class="lista-precios clearfix">
                    <li>
                        <div class="tabla-precio">
                            <h3>Pase por dia (viernes)</h3>
                            <p class="numero">$30</p>
                            <ul>
                                <li>Bocadillos gratis</li>
                                <li>Todas las conferencias</li>
                                <li>Todos los talleres</li>
                            </ul>
                            <div class="orden">
                                <label for="pase_dia">Boletos deseados:</label>
                                <input type="number" id="pase_dia" min="0" size="3" name="boletos[un_dia][cantidad]" placeholder="0">
                                <input type="hidden" value="30" name="boletos[un_dia][precio]">
                            </div>
                        </div>
                    </li>
                    
                    <li>
                        <div class="tabla-precio">
                            <h3>Todos los dias</h3>
                            <p class="numero">$50</p>
                            <ul>
                                <li>Bocadillos gratis</li>
                                <li>Todas las conferencias</li>
                                <li>Todos los talleres</li>
                            </ul>
                            <div class="orden">
                                <label for="pase_completo">Boletos deseados:</label>
                                <input type="number" id="pase_completo" min="0" size="3" name="boletos[completo][cantidad]" placeholder="0">
                                <input type="hidden" value="50" name="boletos[completo][precio]">
                            </div>
                        </div>
                    </li>
                    
                    <li>
                        <div class="tabla-precio">
                            <h3>Pase por 2 dias (viernes y sábado)</h3>
                            <p class="numero">$45</p>
                            <ul>
                                <li>Bocadillos gratis</li>
                                <li>Todas las conferencias</li>
                                <li>Todos los talleres</li>
                            </ul>
                            <div class="orden">
                                <label for="pase_dosdias">Boletos deseados:</label>
                                <input type="number" id="pase_dosdias" min="0" size="3" name="boletos[dos_dias][cantidad]" placeholder="0">
                                <input type="hidden" value="45" name="boletos[dos_dias][precio]">
                            </div>
                        </div>
                    </li>
                </ul>
            </div> <!-- #paquetes -->

            <div id="eventos" class="eventos clearfix">
                <h3>Elige tus talleres</h3>
                <div class="caja">
                    <?php 
                        try {
                            require_once('includes/funciones/bd_conexion.php');
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
                          <h4><?= $dia ?></h4>
                            <?php foreach($eventos['eventos'] as $tipo => $evento_dia): ?>
                              <div>
                                  <p><?= $tipo ?></p>
                                  <?php foreach($evento_dia as $evento)  { ?>
                                  <label>
                                    <input type="checkbox" name="registro[]" id="<?= $evento['id'] ?>" value="<?= $evento['clave'] ?>">
                                    <time><?= $evento['hora_evento'] ?></time> <?= $evento['nombre_evento'] ?>
                                    <br>
                                    <span class="autor"><?= $evento['nombre_invitado']. " ". $evento['apellido_invitado'] ?></span>
                                  </label>
                                  <?php } // Fin foreach ?>
                              </div>
                            <?php endforeach; ?>
                      </div> <!--.contenido-dia-->
                      <?php } // Fin foreach ?>
                  </div><!--.caja-->
            </div> <!--#eventos-->

            <div id="resumen" class="resumen clearfix">
                <h3>Pago y Extras</h3>
                <div class="caja clearfix">
                    <div class="extras">
                        <div class="orden">
                            <label for="camisa_evento">Camisa del evento $10 <small>(promoción 7% dto.)</small></label>
                            <input type="number" min="0" id="camisa_evento" name="pedido_extra[camisas][cantidad]" size="3" placeholder="0">
                            <input type="hidden" value="10" name="pedido_extra[camisas][precio]">
                        </div> <!-- .orden -->

                        <div class="orden">
                            <label for="etiquetas">Paquetes de 10 etiquetas $2 <small>(HTML5, CSS3, JavaScript, Chrome)</small></label>
                            <input type="number" min="0" id="etiquetas" name="pedido_extra[etiquetas][cantidad]" size="3" placeholder="0">
                            <input type="hidden" value="2" name="pedido_extra[etiquetas][precio]">
                        </div> <!-- .orden -->

                        <div class="orden">
                            <label for="regalo">Seleccione un regalo</label> <br>
                            <select id="regalo" name="regalo" required>
                                <option value="">- Seleccione un regalo -</option>
                                <option value="1">Pulseras</option>
                                <option value="2">Etiquetas</option>
                                <option value="3">Plumas</option>
                            </select>
                        </div> <!-- .orden -->

                        <input type="button" id="calcular" class="button" value="Calcular">
                        
                    </div> <!-- .extras -->

                    <div class="total">
                        <p>Resumen</p>
                        <div id="lista-productos">

                        </div>
                        <p>Total:</p>
                        <div id="suma-total">

                        </div>
                        <input type="hidden" name="total_pedido" id="total_pedido">
                        <input type="submit" name="submit" id="btnRegistro" class="button" value="Pagar">
                    </div> <!-- .total -->
                </div> <!-- .caja -->
            </div>
        </form>
    </section>
    
    <?php include_once 'includes/templates/footer.php'; ?>
