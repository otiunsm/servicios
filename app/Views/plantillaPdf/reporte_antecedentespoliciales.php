<!-- Plantilla para la creacion del pdf de consulta por DNI -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Reporte Antecedentes Penales - <?= $datos['tipoDocumento']  == NULL ? 'SIN REGISTRO':$datos['tipoDocumento'].' - '.$datos['nroDocumento'] ?></title>
	<link href="<?= base_url() . '/public/css/plantillaPdf/milligram.css'?>" type="text/css" rel="stylesheet"/>
	<link href="<?= base_url() . '/public/css/plantillaPdf/milligram.css'?>" type="text/css" rel="stylesheet" media="mpdf"/>
	<link rel="stylesheet" href="<?= base_url()?>/public/css/plantillaPdf/planilla.css">
</head>
<body>
    <table class="encabezado">
      	<thead>
        	<tr>
          		<th style="border: none !important;" >
          			<img src="<?= base_url()?>/public/img/logo.svg" width = "200px" alt="">
          		</th>
          		<th style="border: none !important;"><h3 style="text-align: center; font-weight: bold; text-decoration: underline; font-size: 16px;" >FICHA DE ANTECEDENTES POLICIALES</h3></th>
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

    <!-- Uso tabla para presentar los datos. El GRID de Milligram CSS no es compatible con MPDF -->
    <p style="text-align: center; font-size: 15px;" >SE REGISTRA LOS SIGUIENTES DATOS</p>
    <table>
	<thead>
	    <tr>
		<td style="font-weight: bold"> DATOS PERSONALES</td>
		<td></td>
	    </tr>
	</thead>

	<tbody>
		<tr>
		<td>TIPO DE DOCUMENTO</td>
		<td> <?= $datos['tipoDocumento']  == NULL ? 'SIN REGISTRO':$datos['tipoDocumento'] ?> </td>
	    </tr>

	    <tr>
		<td>N° DE DOCUMENTO</td>
		<td> <?= $datos['nroDocumento'] ?> </td>
	    </tr>

	    <tr>
		<td>CÓDIGO DE PERSONA</td>
		<td> <?= $datos['codigoPersona'] == NULL ? 'SIN REGISTRO':$datos['codigoPersona'] ?> </td>
	    </tr>

	    <tr>
		<td>APELLIDO PATERNO:</td>
		<td><?= $datos['apellidoPaterno'] == NULL ? 'SIN REGISTRO':$datos['apellidoPaterno'] ?></td>
	    </tr>

	    <tr>
		<td>APELLIDO MATERNO:</td>
		<td> <?= $datos['apellidoMaterno'] == NULL ? 'SIN REGISTRO':$datos['apellidoMaterno'] ?></td>
	    </tr>

	    <tr>
		<td>NOMBRE(S):</td>
		<td><?= $datos['nombres'] == NULL ? 'SIN REGISTRO':$datos['nombres'] ?></td>
	    </tr>

	    <tr>
		<td>NOMBRE DEL PADRE:</td>
		<td><?= $datos['nombrePadre'] == NULL ? 'SIN REGISTRO':$datos['nombrePadre'] ?></td>
	    </tr>

	    <tr>
		<td>NOMBRE DE LA MADRE:</td>
		<td><?= $datos['nombreMadre'] == NULL ? 'SIN REGISTRO':$datos['nombreMadre'] ?></td>
	    </tr>

	    <tr>
		<td>DOBLE IDENTIDAD:</td>
		<td><?= $datos['dobleIdentidad'] == NULL ? 'SIN REGISTRO':$datos['dobleIdentidad'] ?></td>
	    </tr>

	    <tr>
		<td>HOMONIMIA:</td>
		<td><?= $datos['homonimia'] == NULL ? 'SIN REGISTRO':$datos['homonimia'] ?></td>
	    </tr>

	    <tr>
		<td>LUGAR DE NACIMIENTO:</td>
		<td><?= $datos['lugarNacimiento'] == NULL ? 'SIN REGISTRO':$datos['lugarNacimiento'] ?></td>
	    </tr>

	    <tr>
		<td>FECHA DE NACIMIENTO:</td>
		<td><?= $datos['fechaNacimiento'] == NULL ? 'SIN REGISTRO':$datos['fechaNacimiento'] ?></td>
	    </tr>

	    <tr>
		<td>SEXO:</td>
		<td><?= $datos['sexo'] == NULL ? 'SIN REGISTRO':$datos['sexo'] ?></td>
	    </tr>

	    <tr>
		<td>TALLA:</td>
		<td><?= $datos['talla'] == NULL ? 'SIN REGISTRO':$datos['talla'].' CM' ?></td>
	    </tr>
	</tbody>
    </table>
   
	
</body>
</html>





