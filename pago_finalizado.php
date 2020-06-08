<?php include_once "includes/templates/header.php"; 

  use PayPal\Rest\ApiContext;
  use PayPal\Api\Payment;
  use PayPal\Api\PaymentExecution;
  require "includes/paypal.php";
?>

<section class="seccion contenedor">
    <h2>Resumen Registro</h2>
    <?php
      $paymentId = $_GET['paymentId'];
      $idPago = (int) $_GET['id_pago'];

      // Peticion a REST API
      $pago = Payment::get($paymentId, $apiContext);
      $execution = new PaymentExecution();
      $execution->setPayerId($_GET['PayerID']);

      // resultado tiene la informacion de la transaccion
      $resultado = $pago->execute($execution, $apiContext);

      $respuesta = $resultado->transactions[0]->related_resources[0]->sale->state;

      if($respuesta == "completed") {
          echo "
            <div class='resultado correcto'>
              El pago se realizo correctamente <br/>
              El id es: {$paymentId}
            </div>
          ";

          require_once('includes/funciones/bd_conexion.php');
          $stmt = $conn->prepare('UPDATE registrados SET pagado = ? WHERE ID_registrado = ?');
          $pagado = 1;
          $stmt->bind_param('ii', $pagado, $idPago);
          $stmt->execute();
          $stmt->close();
          $conn->close();
      } else {
        echo "
        <div class='resultado error'>
          El pago no se realizo
        </div>
      ";
      }
    ?>
    
</section>

<?php include_once "includes/templates/footer.php"; ?>