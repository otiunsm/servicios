<!-- Plantilla para la creacion del pdf de consulta por DNI -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Reporte DNI - <?= $datos['dni'] ?></title>
	<link href="<?= base_url() . '/public/css/plantillaPdf/milligram.css'?>" type="text/css" rel="stylesheet"/>
	<link href="<?= base_url() . '/public/css/plantillaPdf/milligram.css'?>" type="text/css" rel="stylesheet" media="mpdf"/>
	<link rel="stylesheet" href="<?= base_url()?>/public/css/plantillaPdf/planilla.css">
</head>
<body>
    <!-- Uso tabla para presentar los datos. El GRID de Milligram CSS no es compatible con MPDF -->
    <table class="encabezado">
      	<thead>
        	<tr>
          		<th style="border: none !important;" >
          			<img src="<?= base_url()?>/public/img/logo.svg" width = "200px" alt="">
          		</th>
          		<th style="border: none !important;"><h3 style="text-align: center; font-weight: bold; text-decoration: underline; font-size: 16px;" >FICHA DE CONSULTA DNI (RENIEC)</h3></th>
          		<th style="border: none !important; text-align: right; font-size: 12px; font-weight: normal;" >
          			<p><?php
				          date_default_timezone_set('America/Lima');
				          $fecha = new DateTime();
				          echo "</p>".$fecha->format('d/m/Y')." <br><p>".$fecha->format('H:i:s');
				          ?>
				          	
				    </p>
				</th>
        	</tr>
    	</thead>
    	<tbody></tbody>
	</table>
    <table>
	<thead>
	    <tr>
		<td style="font-weight: bold"> DATOS PERSONALES</td>
		<td></td>
	    </tr>
	</thead>

	<tbody>
	    <tr>
		<td>DNI</td>
		<td> <?= $datos['dni'] ?> </td>
	    </tr>

	    <tr>
		<td>APELLIDO PATERNO:</td>
		<td><?= $datos['apPrimer'] ?></td>
	    </tr>

	    <tr>
		<td>APELLIDO MATERNO:</td>
		<td> <?= $datos['apSegundo'] ?></td>
	    </tr>

	    <tr>
		<td>NOMBRE(S):</td>
		<td><?= $datos['prenombres'] ?></td>
	    </tr>

	    <tr>
		<td>ESTADO CIVIL:</td>
		<td><?= $datos['estadoCivil'] ?></td>
	    </tr>

	    <tr>
		<td>UBIGEO:</td>
		<td><?= $datos['ubigeo'] ?></td>
	    </tr>

	    <tr>
		<td>DIRECCIÓN:</td>
		<td><?= $datos['direccion'] ?></td>
	    </tr>

	</tbody>
    </table>

    <div style="text-align: center">
	<img src="<?= $datos['foto'] ?>" alt=""  width="250">
    </div>
	
</body>
</html>





