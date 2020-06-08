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
            <h1>Dashboard</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-10">
                <div id="grafica-registros" style="height: 250px;"></div>
            </div>
        </div>

        <h5 class="mt-4 mb-3">Resumen de Registros</h5>
        <div class="row">
            <div class="col-lg-3 col-6">
                <?php 
                    $sql = "SELECT COUNT(ID_registrado) AS registros FROM registrados";
                    $resultado = $conn->query($sql);
                    $registrados = $resultado->fetch_assoc();
                
                ?>
                <!-- small card -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= $registrados['registros'] ?></h3>
            
                        <p>Total registrados</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <a href="lista-registrados.php" class="small-box-footer">
                        Más información <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <?php 
                    $sql = "SELECT COUNT(ID_registrado) AS registros FROM registrados WHERE pagado = 1";
                    $resultado = $conn->query($sql);
                    $registrados = $resultado->fetch_assoc();
                
                ?>
                <!-- small card -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $registrados['registros'] ?></h3>
            
                        <p>Total pagados</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="lista-registrados.php" class="small-box-footer">
                        Más información <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <?php 
                    $sql = "SELECT COUNT(ID_registrado) AS registros FROM registrados WHERE pagado = 0";
                    $resultado = $conn->query($sql);
                    $registrados = $resultado->fetch_assoc();
                
                ?>
                <!-- small card -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= $registrados['registros'] ?></h3>
            
                        <p>Total sin pagar</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-times"></i>
                    </div>
                    <a href="lista-registrados.php" class="small-box-footer">
                        Más información <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <?php 
                    $sql = "SELECT SUM(total_pagado) AS ganancias FROM registrados WHERE pagado = 1";
                    $resultado = $conn->query($sql);
                    $registrados = $resultado->fetch_assoc();
                    $ganancias = round($registrados['ganancias'], 2);
                
                ?>
                <!-- small card -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>$ <?= $ganancias ?></h3>
            
                        <p>Ganancias totales</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-donate"></i>
                    </div>
                    <a href="lista-registrados.php" class="small-box-footer">
                        Más información <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <h5 class="mt-4 mb-3">Regalos</h5>
        <div class="row">
            <div class="col-lg-3 col-6">
                <?php 
                    $sql = "SELECT COUNT(*) AS pulseras FROM registrados WHERE pagado = 1 AND regalo = 1";
                    $resultado = $conn->query($sql);
                    $regalo = $resultado->fetch_assoc();
                
                ?>
                <!-- small card -->
                <div class="small-box bg-teal">
                    <div class="inner">
                        <h3><?= $regalo['pulseras'] ?></h3>
            
                        <p>Pulseras</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-gift"></i>
                    </div>
                    <a href="lista-registrados.php" class="small-box-footer">
                        Más información <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <?php 
                    $sql = "SELECT COUNT(*) AS etiquetas FROM registrados WHERE pagado = 1 AND regalo = 2";
                    $resultado = $conn->query($sql);
                    $regalo = $resultado->fetch_assoc();
                
                ?>
                <!-- small card -->
                <div class="small-box bg-purple">
                    <div class="inner">
                        <h3><?= $regalo['etiquetas'] ?></h3>
            
                        <p>Etiquetas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-gift"></i>
                    </div>
                    <a href="lista-registrados.php" class="small-box-footer">
                        Más información <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <?php 
                    $sql = "SELECT COUNT(*) AS plumas FROM registrados WHERE pagado = 1 AND regalo = 3";
                    $resultado = $conn->query($sql);
                    $regalo = $resultado->fetch_assoc();
                
                ?>
                <!-- small card -->
                <div class="small-box bg-orange">
                    <div class="inner">
                        <h3><?= $regalo['plumas'] ?></h3>
            
                        <p>Plumas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-gift"></i>
                    </div>
                    <a href="lista-registrados.php" class="small-box-footer">
                        Más información <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include_once "templates/footer.php"; ?>

