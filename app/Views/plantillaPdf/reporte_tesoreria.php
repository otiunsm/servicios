<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= 'BOLETA - '.$Datos[0]['seriecomprobante'].' - '.$Datos[0]['numerocomprobante'] ?></title>
  <link rel="stylesheet" href="<?= base_url()?>/public/css/plantillaPdf/planilla.css">
</head>
<body>
  
<table class="encabezado_teso">
  <thead>
    <tr>
      <th><img src="<?= base_url()?>/public/img/logo.svg" width = "250px" alt=""></th>
      <th>
        <h3><?= 'BOLETA - '.$Datos[0]['seriecomprobante'].' - '.$Datos[0]['numerocomprobante'] ?></h3>
      </th>
      <th><p><?= $Datos[0]['nrooperacion'] ?></p> <p><?php
      date_default_timezone_set('America/Lima');
      $fecha = new DateTime();
    	//echo "</p>".$fecha->format('d/m/Y')." <br><p>".$fecha->format('H:i:s');
    	//$fecha1 = strtotime($Datos[0]['fecha']);
    	echo "</p> Fecha: ".strftime("%d/%m/%Y", strtotime($Datos[0]['fecha']));
      ?></th>
    </tr>
    </thead>
</table>

<table class="encabezado-info_teso">
  <thead>
    <tr>
      <td><p><strong>Entidad:</strong>  Universidad Nacional de San Martin</p></td>
      <td><p><strong>RUC:</strong>  20160766191</p></td>
    </tr>
    <tr>
      <td colspan="2"><strong>Unidad:</strong>  Unidad de Tesorería - Tarapoto</td>
    </tr>
  </thead>
</table>
<table class="encabezado-info_teso">
  <thead>
    <tr>
      <td><p><strong>Doc. Identidad:</strong>  <?= $Datos[0]['nrodoccliente'] ?></p></td>
      <td><p><strong>Apellidos y Nombres:</strong>  <?= $Datos[0]['nombrecliente'] ?></p></td>
    </tr>
  </thead>
</table>

<table class="table-conceptos_teso">
  <thead>
    <tr>
      <th>CÓDIGO</th>
      <th>CANTIDAD</th>
      <th>CONCEPTO</th>
      <th>MONTO</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      $Monto = 0;
      foreach ($Datos as $key => $data) {
        $Monto += $data['precio'];
        echo
        '<tr>
          <td>0000</td>
          <td>'.$data['cantidad'].'</td>
          <td>'.$data['concepto'].'</td>
          <td>'.$data['precio'].'</td>
        </tr>';
      }
    
    ?>
  </tbody>
  <tfoot>
    <tr>
      <th colspan="3">TOTAL MONTO</th>
      <th style="border-top: 2px solid black;"><?= number_format($Monto, 2, '.', ',') ?></th>
    </tr>
  </tfoot>
</table>

<table class="table-conceptos">
  <tfoot>
    <tr>
      <?php
          $formatterES = new NumberFormatter("es-ES", NumberFormatter::SPELLOUT);
          $entero = intval(floor($Monto));
          $decimal = explode('.', $Monto);
          $valueJH = count( $decimal ) == 1 ? 0 : $decimal[ '1' ];
          
      ?>
      <td colspan="6" style="text-align: center;">NETO A PAGAR: <?= strtoupper($formatterES->format($entero).' con '.$valueJH.'/100 Soles ')?></td>
    </tr>
  </tfoot>
</table>

<table class="table-conceptos">
  <thead>
  </thead>
  <tbody>
    <tr>
      <td style="text-align: left;"><strong>OBSERVACIÓN</strong></td>
      <td class="text-white">-</td>
      <td class="text-white">-</td>
      <td class="text-white">-</td>
      <td class="text-white">-</td>
      <td class="text-white">-</td>
    </tr>
    <tr>
      <td class="text-white">-</td>
    </tr>
    <tr>
      <td colspan="2" style="text-align: center;"><img src="<?= base_url()?>/filename2.png" alt=""></td>
      <td colspan="2" class="text-white">-</td>
      <td colspan="2" style="text-align: center;font-size: 12px">--------------------------------------------------------------------------- <br> RECIBI CONFORME<br></td>
    </tr>
</table>
<?php
  function searchMount($mes){
    switch ($mes) {
      case '01':
      $stringMes = 'ENERO';
      break;
      case '02':
      $stringMes = 'FEBRERO';
      break;
      case '03':
      $stringMes = 'MARZO';
      break;
      case '04':
      $stringMes = 'ABRIL';
      break;
      case '05':
      $stringMes = 'MAYO';
      break;
      case '06':
      $stringMes = 'JUNIO';
      break;
      case '07':
      $stringMes = 'JULIO';
      break;
      case '08':
      $stringMes = 'AGOSTO';
      break;
      case '09':
      $stringMes = 'SEPTIEMBRE';
      break;
      case '10':
      $stringMes = 'OCTUBRE';
      break;
      case '11':
      $stringMes = 'NOVIEMBRE';
      break;
      case '12':
      $stringMes = 'DICIEMBRE';
      break;
      default:
      $stringMes = 'DESCONOCIDO';
      break;
    }
    return $stringMes;
  }
?>
</body>
</html>

