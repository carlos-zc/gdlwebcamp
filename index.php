<?php include_once 'includes/templates/header.php'; ?>
    
    <section class="seccion contenedor">
        <h2>La Mejor Conferencia de Diseño Web en Español</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi optio suscipit voluptate earum error fuga inventore vero eligendi id magni fugiat doloremque omnis, possimus mollitia nemo. Porro ipsa, dolore accusamus! Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate corrupti eum a necessitatibus? Expedita pariatur nisi facilis temporibus nesciunt eaque aperiam quibusdam est cum, eveniet in nihil laboriosam corporis atque.</p>
    </section><!--.seccion-->
    
    <section class="programa">
        <div class="contenedor-video">
            <video autoplay loop poster="img/bg-talleres.jpg">
                <source src="video/video.mp4" type="video/mp4">
                <source src="video/video.webm" type="video/webm">
                <source src="video/video.ogv" type="video/ovg">
            </video>
        </div><!--.contenedor-video-->
        
        <div class="contenido-programa">
            <div class="contenedor">
                <div class="programa-evento">
                    <h2>Programa del Evento</h2>
                    <?php
                        try {
                            require_once('includes/funciones/bd_conexion.php');
                            $sql = 'SELECT * FROM categoria_evento ';
                            $resultado = $conn->query($sql);
                        } catch(Exception $e) {
                            echo $e->getMessage(); // mensaje de error en caso de no conectar db
                        }
                    ?>
                    <nav class="menu-programa">
                        <?php while($cat = $resultado->fetch_array(MYSQLI_ASSOC)){ ?>
                            <?php $categoria = $cat['cat_evento'] ?>
                            <a href="#<?php echo strtolower($categoria)?>">
                                <i class="fas <?php echo $cat['icono'] ?>"></i> <?php echo $categoria ?>
                            </a>
                        <?php } ?>
                    </nav>

                    <?php
                        try {
                            require_once('includes/funciones/bd_conexion.php');
                            $sql = 'SELECT evento_id, nombre_evento, fecha_evento, hora_evento, cat_evento, icono, nombre_invitado, apellido_invitado ';
                            $sql .= ' FROM eventos ';
                            $sql .= ' INNER JOIN categoria_evento '; // INNER JOIN relaciona otra tabla
                            $sql .= ' ON eventos.id_cat_evento = categoria_evento.id_categoria ';
                            $sql .= ' INNER JOIN invitados ';
                            $sql .= ' ON eventos.id_inv = invitados.invitado_id ';
                            $sql .= ' AND eventos.id_cat_evento = 1';
                            $sql .= ' ORDER BY evento_id LIMIT 2;';
                            // Multiconsulta
                            $sql .= 'SELECT evento_id, nombre_evento, fecha_evento, hora_evento, cat_evento, icono, nombre_invitado, apellido_invitado ';
                            $sql .= ' FROM eventos ';
                            $sql .= ' INNER JOIN categoria_evento '; // INNER JOIN relaciona otra tabla
                            $sql .= ' ON eventos.id_cat_evento = categoria_evento.id_categoria ';
                            $sql .= ' INNER JOIN invitados ';
                            $sql .= ' ON eventos.id_inv = invitados.invitado_id ';
                            $sql .= ' AND eventos.id_cat_evento = 2';
                            $sql .= ' ORDER BY evento_id LIMIT 2;';
                            $sql .= 'SELECT evento_id, nombre_evento, fecha_evento, hora_evento, cat_evento, icono, nombre_invitado, apellido_invitado ';
                            $sql .= ' FROM eventos ';
                            $sql .= ' INNER JOIN categoria_evento '; // INNER JOIN relaciona otra tabla
                            $sql .= ' ON eventos.id_cat_evento = categoria_evento.id_categoria ';
                            $sql .= ' INNER JOIN invitados ';
                            $sql .= ' ON eventos.id_inv = invitados.invitado_id ';
                            $sql .= ' AND eventos.id_cat_evento = 3';
                            $sql .= ' ORDER BY evento_id LIMIT 2;';
                        } catch(Exception $e) {
                            echo $e->getMessage(); // mensaje de error en caso de no conectar db
                        }
                    ?>

                    <?php $conn->multi_query($sql); // multiconsulta?>
                    <?php do {
                        $resultado = $conn->store_result();
                        $row = $resultado->fetch_all(MYSQLI_ASSOC); 
                        
                        $i = 0;
                        foreach ($row as $evento): 
                            if($i % 2 == 0){ ?>
                                <div id="<?php echo strtolower($evento['cat_evento']) ?>" class="info-curso ocultar clearfix">
                            <?php } ?>
                                <div class="detalle-evento">
                                    <h3><?php echo $evento['nombre_evento']; ?></h3>
                                    <p><i class="far fa-clock"></i> <?php echo $evento['hora_evento'] ?></p>
                                    <p><i class="far fa-calendar-alt"></i> <?php echo $evento['fecha_evento'] ?></p>
                                    <p><i class="fas fa-user"></i> <?php echo $evento['nombre_invitado'].' '.$evento['apellido_invitado'] ?></p>
                                </div><!--.detalle-evento-->
                                
                            <?php if($i % 2 == 1): ?>
                                <a href="calendario.php" class="button float-right">Ver todos</a>
                            </div><!--#talleres-->
                            <?php endif; ?>
                        <?php 
                        $i++;
                        endforeach; 
                        $resultado->free(); ?>

                    <?php } while($conn->more_results() && $conn->next_result()); ?>

                </div><!--.programa-evento-->
            </div><!--.contenedor-->
        </div><!--.contenido-programa-->
        
    </section><!--.programa-->
    
    <?php include_once 'includes/templates/invitados.php'; ?>
    
    <div class="contador parallax">
        <div class="contenedor">
            <ul class="resumen-evento clearfix">
                <li><p class="numero"></p> Invitados</li>
                <li><p class="numero"></p> Talleres</li>
                <li><p class="numero"></p> Dias</li>
                <li><p class="numero"></p> Conferencias</li>
            </ul>
        </div>
    </div>
    
    <section class="precios seccion">
        <h2>Precios</h2>
        <div class="contenedor">
            <ul class="lista-precios clearfix">
                <li>
                    <div class="tabla-precio">
                        <h3>Pase por dia</h3>
                        <p class="numero">$30</p>
                        <ul>
                            <li>Bocadillos gratis</li>
                            <li>Todas las conferencias</li>
                            <li>Todos los talleres</li>
                        </ul>
                        <a href="#" class="button hollow">Comprar</a>
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
                        <a href="#" class="button">Comprar</a>
                    </div>
                </li>
                
                <li>
                    <div class="tabla-precio">
                        <h3>Pase por 2 dias</h3>
                        <p class="numero">$45</p>
                        <ul>
                            <li>Bocadillos gratis</li>
                            <li>Todas las conferencias</li>
                            <li>Todos los talleres</li>
                        </ul>
                        <a href="#" class="button hollow">Comprar</a>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    
    <div id="mapa" class="mapa"></div>
    
    <section class="seccion">
        <h2>Testimoniales</h2>
        <div class="testimoniales contenedor clearfix">
            <div class="testimonial">
                <blockquote>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe impedit magni aspernatur expedita excepturi voluptates assumenda provident architecto.</p>
                    <footer class="info-testimonial clearfix">
                        <img src="img/testimonial.jpg" alt="Imagen Testimonial">
                        <cite>Oswaldo Aponte Escobedo <span>Diseñador en @prisma</span></cite>
                    </footer>
                </blockquote>
            </div><!--.testimonial-->

            <div class="testimonial">
                <blockquote>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe impedit magni aspernatur expedita excepturi voluptates assumenda provident architecto.</p>
                    <footer class="info-testimonial clearfix">
                        <img src="img/testimonial.jpg" alt="Imagen Testimonial">
                        <cite>Oswaldo Aponte Escobedo <span>Diseñador en @prisma</span></cite>
                    </footer>
                </blockquote>
            </div><!--.testimonial-->

            <div class="testimonial">
                <blockquote>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe impedit magni aspernatur expedita excepturi voluptates assumenda provident architecto.</p>
                    <footer class="info-testimonial clearfix">
                        <img src="img/testimonial.jpg" alt="Imagen Testimonial">
                        <cite>Oswaldo Aponte Escobedo <span>Diseñador en @prisma</span></cite>
                    </footer>
                </blockquote>
            </div><!--.testimonial-->
        </div>
    </section>
    
    <div class="newsletter parallax">
        <div class="contenido contenedor">
            <p> Registrate al newsletter:</p>
            <h3>gdlwebcam</h3>
            <a href="#mc_embed_signup" class="boton_newsletter button transparente">Registro</a>
        </div>
    </div>
    
    <section class="seccion">
        <h2>Faltan</h2>
        <div class="cuenta-regresiva contenedor">
            <ul class="clearfix">
                <li><p class="numero" id="dias"></p> días</li>
                <li><p class="numero" id="horas"></p> horas</li>
                <li><p class="numero" id="minutos"></p> minutos</li>
                <li><p class="numero" id="segundos"></p> segundos</li>
            </ul>
        </div>
    </section>

<?php include_once 'includes/templates/footer.php'; ?>