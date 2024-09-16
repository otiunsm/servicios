<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BOLETA DE PAGO - PLANILLA <?= $Datos['codplanillaperiodo']?></title>
  <link rel="stylesheet" href="<?= base_url()?>/public/css/plantillaPdf/planilla.css">

</head>
<body>
    <table class="encabezado">
      <thead>
        <tr>
          <th><img src="<?= base_url()?>/public/img/logo.svg" width = "250px" alt=""></th>
          <th><h3>BOLETA DE PAGO - PLANILLA <?= $Datos['codplanillaperiodo']?></h3></th>
          <th>
              <p>00000</p>
              <p><?= $FechaReporte['Fecha']?></p>
              <p><?= $FechaReporte['Hora']?></p>
          </th>
        </tr>
        <tbody>
          <tr>
            <th colspan="3">Periodo: <?php
            $rest = substr( $Datos['periodo'], -2);
            echo searchMount($rest).' - '.substr( $Datos['periodo'],0,-2);?>
            </th>
          </tr>
        </tbody>
      </thead>
    </table>
    
    <table class="encabezado-info">
      <thead>
        <tr>
          <td>
            <p><strong>Entidad:</strong> Universidad Nacional de San Martin</p>
            <p><strong>Empleador:</strong> Universidad Nacional de San Martin</p>
            <p><strong>RUC:</strong> 20160766191</p>
          </td>
          <td>
            <p><strong>Rubro de Financiamiento:</strong> </p>
            <p><strong>Meta Presupuestal:</strong> <?= $Datos['codmeta']?></p>
            <p><strong>Unidad Orgánica:</strong></p>
          </td>
        </tr>
      </thead>
    </table>
    
    <table class="encabezado-info2">
      <thead>
        <tr>
          <td>
            <p><strong>Doc. Identidad:</strong> <?= $Datos['nrodocumento']?></p>
            <p><strong>Apellidos y Nombres:</strong> <?= $Datos['appaterno'].' '.$Datos['apmaterno'].' '.$Datos['nombre']?></p>
            <p><strong>Fecha de Ingreso:</strong> <?= $Datos['fechaingreso']?></p>
            <p><strong>Régimen Pensionario:</strong> </p>
            <p><strong>Administrador de Pensión:</strong> <?= $Datos['codigoairhsp']?></p>
            <p><strong>CUSPP:</strong> <?= $Datos['cuspp']?></p>
            <p><strong>Fracción y Tipo de Pensión:</strong> </p>
            <p style="color:white">-</p>
          </td>
          <td>
            <p><strong>Código AIRHSP:</strong> <?= $Datos['codigoairhsp']?></p>
            <p><strong>Establecimiento:</strong> </p>
            <p><strong>Régimen Laboral:</strong> <?= $Datos['regimenlaboral']?></p>
            
            <?php $situacion = ($Datos['codsituacion'] == '2') ? '-CESANTE' : ''; ?>
            
            <p><strong>Condición:</strong> <?= $Datos['destiposervidor'].' '.$Datos['descondicion'].' '.$situacion ?></p>
            <p><strong>Grupo Ocupacional:</strong> </p>
            <p><strong>Cargo Estructural:</strong> </p>
            <p><strong>Cargo:</strong> <?= $Datos['cargo']?></p>
            <p><strong>Jornada Laboral:</strong> <?= $Datos['jornada']?> Hrs.</p>
          </td>
        </tr>
      </thead>
    </table>
    
    <table class="encabezado-info3">
      <thead>
        <tr>
          <th> <p>Días Laborados: </p></th> 
          <th> <p>Días No Laborados:</p> </th> 
          <th> <p>Días Subsidiados: </p></th>
        </tr>
        <tr>
          <th><p>Periodo Vacacional: </p></th>
           <th><p></p></th>
          <th><p>Essalud: S/.<?= $Datos['totalpatronal']?></p></th>
        </tr>
      </thead>
    </table>
    
    <table class="table-conceptos">
      <thead>
        <tr>
          <th>CÓDIGO</th>
          <th>CONCEPTO</th>
          <th>MONTO</th>
          <th>CÓDIGO</th>
          <th>CONCEPTO</th>
          <th>MONTO</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><strong>INGRESOS</strong></td>
        </tr>
        <?php
        // SEPARAR ARRAY
        if( count( $Datos[ '0' ][ 'rem' ] ) == "0" ){
          echo
            '<tr>
              <td>    </td>
              <td>    </td>
              <td>    </td>
              <td>    </td>
              <td>    </td>
              <td>    </td>
            </tr>';
        }
        $countJH = 0;
        $totalIngreso = 0;
        foreach( $Datos['0']['rem'] as $key => $rem ){
          $totalIngreso += $rem['importe'];
          $countJH++;
          if( $countJH % 2 != 0 ){
            echo
            '<tr>';
            echo'
            <td>'.$rem['codremuneracion'].'</td>
            <td>'.$rem['desremuneracion'].'</td>
            <td>'.$rem['importe'].'</td>';
          }
          else{
            echo'
               <td>'.$rem['codremuneracion'].'</td>
              <td>'.$rem['desremuneracion'].'</td>
              <td>'.$rem['importe'].'</td>';
              echo
              '</tr>';
          }
        }
        if( $countJH % 2 != 0 ){
          echo
            ' <td>    </td>
              <td>    </td>
              <td>    </td>
            </tr>';
        }
        ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="5">TOTAL INGRESOS</th>
          <th style="border-top: 2px solid black;"><?= number_format($totalIngreso, 2, '.', ',') ?></th>
        </tr>
      </tfoot>
    </table>
    
    <table class="table-conceptos">
      <thead>
      </thead>
      <tbody>
        <tr>
          <td><strong>DESCUENTOS</strong></td>
        </tr>
        <?php
        // SEPARAR ARRAY
        $countJH2 = 0;
        $totalDescuento = 0;
        if( count( $Datos[ '1' ][ 'desc' ] ) == "0" ){
          echo
            '<tr>
              <td>    </td>
              <td>    </td>
              <td>    </td>
              <td>    </td>
              <td>    </td>
              <td>    </td>
            </tr>';
        }
        foreach( $Datos['1']['desc'] as $key => $des ){
          $totalDescuento += $des['importedescuento'];
          $countJH2++;
          if( $countJH2 % 2 != 0 ){
            echo
            '<tr>';
            echo'
            <td>'.$des['coddescuento'].'</td>
            <td>'.$des['desdescuento'].'</td>
            <td>'.$des['importedescuento'].'</td>';
          }
          else{
            echo'
              <td>'.$des['coddescuento'].'</td>
              <td>'.$des['desdescuento'].'</td>
              <td>'.$des['importedescuento'].'</td>';
              echo
              '</tr>';
          }
        }
        if( $countJH2 % 2 != 0 ){
          echo
            ' <td>    </td>
              <td>    </td>
              <td>    </td>
            </tr>';
        }
        ?>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="5">TOTAL DESCUENTOS</th>
          <th style="border-top: 2px solid black;"><?= number_format($totalDescuento, 2, '.', ',') ?></th>
        </tr>
      </tfoot>
    </table>
    
    <table class="table-conceptos">
      <thead>
      </thead>
      <!-- <tbody>
        <tr>
          <td><strong>APORTES</strong></td>
        </tr>
        <tr>
          <td>075</td>
          <td>ESSALUD</td>
          <td>116.55</td>
          <td class="text-white">-</td>
          <td class="text-white">-</td>
          <td class="text-white">-</td>
        </tr>
        <tr>
          <td>076</td>
          <td>EPS</td>
          <td>116.55</td>
          <td class="text-white">-</td>
          <td class="text-white">-</td>
          <td class="text-white">-</td>
        </tr>
        <tr>
          <th colspan="5" style="text-align: right;">TOTAL APORTES (40)</th>
          <th style="text-align: right;border-top: 2px solid black;">233.11</th>
        </tr>
        <tr>
          <td class="text-white">-</td>
          <td>MONTO IMPONIBLE</td>
          <td>400</td>
          
        </tr>
      </tbody> -->
      <tfoot>
        <tr>
          <th colspan="5">NETO A PAGAR</th>
          <th style="border-top: 2px solid black;border-bottom: 2px solid black"><?= number_format(($totalIngreso - $totalDescuento), 2, '.', ',') ?></th>
        </tr>
        <tr>
          <?php
              $Monto = $totalIngreso - $totalDescuento;
              $formatterES = new NumberFormatter("es-ES", NumberFormatter::SPELLOUT);
              $entero = intval(floor($Monto));
              $decimal = explode('.', $Monto);
              $valueJH = count( $decimal ) == 1 ? 0 : $decimal[ '1' ];
          ?>
          <td colspan="6" style="text-align: center;">NETO A PAGAR: <?= strtoupper($formatterES->format($entero).' con '.$valueJH.'/100 Soles ') ?></td>
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
          <td colspan="2" style="text-align: center;"><img src="<?= base_url()?>/filename.png" alt=""></td>
          <td colspan="2" class="text-white">-</td>
          <td colspan="2" style="text-align: center;"><img src="data:image/png;base64,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" alt="" width="130px"></td>
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
