<!-- Plantilla para la creacion del pdf de consulta por DNI -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Reporte RUC - <?= $ruc?></title>
    <link rel="stylesheet" href="<?= base_url() . '/public/css/plantillaPdf/styleruc.css'?>">
</head>
<body>
    <!-- <img alt="Insignia" src="<?= base_url(). '/public/img/logo.svg'?>" width="150px"/> -->
    <table class="titulo">
        <thead>
            <tr>
                <th><img alt="Insignia" src="<?= base_url(). '/public/img/logo.svg'?>" width="170px"/></th>
                <th>REPORTE RUC - <?= $ruc?></th>
                <th class="text-muted"><p><?= $Fecha['Fecha']?></p> <p><?= $Fecha['Hora']?></p></th>
            </tr>
        </thead>
    </table>

    <?php
        switch ($result) {
            case isset($result['getDatosPrincipales']):
                $data = $result['getDatosPrincipales'][0];
                $estado = $data['esActivo']?'ACTIVO':'INACTIVO';
                $habido = $data['esHabido']?'HABIDO':'NO HABIDO';
                echo '
                <h1 class="text-titulo">Datos Principales del Contribuyente</h1>
                <table class="table-contenido">
                    <thead>
                        <tr>
                            <th>Número de RUC</th>
                            <th>Nombre o Razón Social</th>
                            <th>Tipo de persona</th>
                            <th>Código de actividad económica</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> '.$data['ddp_numruc'].'</td>
                            <td> '.$data['ddp_nombre'].'</td>
                            <td> '.$data['desc_identi'].'</td>
                            <td> '.$data['ddp_ciiu'].'</td>
                        </tr>
                    </tbody>
                </table>
                
                <table class="table-contenido">
                    <thead>
                        <tr>
                            <th>Actividad económica</th>
                            <th>Contribuyente</th>
                            <th>Departamento</th>
                            <th>Provincia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> '.$data['desc_ciiu'].'</td>
                            <td> '.$data['desc_tpoemp'].'</td>
                            <td> '.$data['desc_dep'].'</td>
                            <td> '.$data['desc_prov'].'</td>
                        </tr>
                    </tbody>
                </table>
                
                <table class="table-contenido">
                    <thead>
                        <tr>
                            <th>Distrito</th>
                            <th>Estado del contribuyente</th>
                            <th>Fecha y hora de actualización</th>
                            <th>Fecha de alta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> '.$data['desc_dist'].'</td>
                            <td> '.$data['desc_estado'].'</td>
                            <td> '.$data['ddp_fecact'].'</td>
                            <td> '.$data['ddp_fecalt'].'</td>
                        </tr>
                    </tbody>
                </table>
                
                <table class="table-contenido">
                    <thead>
                        <tr>
                            <th>Fecha de baja</th>
                            <th>Tipo de vía</th>
                            <th>Nombre de la vía</th>
                            <th>Número</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> '.$data['ddp_fecbaj'].'</td>
                            <td> '.$data['desc_tipvia'].'</td>
                            <td> '.$data['ddp_nomvia'].'</td>
                            <td> '.$data['ddp_numer1'].'</td>
                        </tr>
                    </tbody>
                </table>
                
                <table class="table-contenido">
                    <thead>
                        <tr>
                            <th>Referencia de ubicación</th>
                            <th>Condición del domicilio</th>
                            <th>Dependencia</th>
                            <th>Interior</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> '.$data['ddp_refer1'].'</td>
                            <td> '.$data['desc_flag22'].'</td>
                            <td> '.$data['desc_numreg'].'</td>
                            <td> '.$data['ddp_inter1'].'</td>
                        </tr>
                    </tbody>
                </table>
                
                <table class="table-contenido">
                    <thead>
                        <tr>
                            <th>Nombre de la zona</th>
                            <th>Tipo de zona</th>
                            <th>Libreta Tributaria</th>
                            <th>Estado Activo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> '.$data['ddp_nomzon'].'</td>
                            <td> '.$data['desc_tipzon'].'</td>
                            <td> '.$data['ddp_lllttt'].'</td>
                            <td>'.$estado.'</td>
                        </tr>
                    </tbody>
                </table>
                
                <table class="table-contenido">
                    <thead>
                        <tr>
                            <th>Estado Habido</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>'.$habido.'</td>
                        </tr>
                    </tbody>
                </table>';
                break;
            case isset($result['getDatosSecundarios']):
                $data = $result['getDatosSecundarios'][0];
                echo '
                <h1 class="text-titulo">Datos Secundarios del Contribuyente</h1>
                <table class="table-contenido">
                    <thead>
                        <tr>
                            <th>Número de RUC</th>
                            <th>Nombre comercial</th>
                            <th>Origen de la entidad</th>
                            <th>Nacionalidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>'.$data['dds_numruc'].'</td>
                            <td>'.$data['dds_nomcom'].'</td>
                            <td>'.$data['desc_orient'].'</td>
                            <td>'.$data['dds_nacion'].'</td>
                        </tr>
                    </tbody>
                </table>
                
                <table class="table-contenido">
                    <thead>
                        <tr>
                            <th>Sexo</th>
                            <th>Número de pasaporte</th>
                            <th>Carnet patronal</th>
                            <th>Número de teléfono</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>'.$data['desc_sexo'].'</td>
                            <td>'.$data['dds_pasapo'].'</td>
                            <td>'.$data['dds_patron'].'</td>
                            <td>'.$data['dds_telef1'].'</td>
                        </tr>
                    </tbody>
                </table>
                
                <table class="table-contenido">
                    <thead>
                        <tr>
                            <th>Actividad Comercio E.</th>
                            <th>Tipo de contabilidad</th>
                            <th>Tipo de documento de identidad</th>
                            <th>Condición de domiciliado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>'.$data['desc_comext'].'</td>
                            <td>'.$data['desc_contab'].'</td>
                            <td>'.$data['desc_docide'].'</td>
                            <td>'.$data['desc_domici'].'</td>
                        </tr>
                    </tbody>
                </table>
                
                <table class="table-contenido">
                    <thead>
                        <tr>
                            <th>Tipo de facturación</th>
                            <th>Inicio de actividades</th>
                            <th>Licencia municipal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>'.$data['desc_factur'].'</td>
                            <td>'.$data['dds_inicio'].'</td>
                            <td>'.$data['dds_licenc'].'</td>
                        </tr>
                    </tbody>
                </table>
                ';
                break;
            case isset($result['getDatosT1144']):
                $data = $result['getDatosT1144'][0];
                echo '
                <h1 class="text-titulo">Datos Adicionales del Contribuyente</h1>
                <table class="table-contenido">
                    <thead>
                        <tr>
                            <th>Código de actividad económica II</th>
                            <th>Actividad económica II</th>
                            <th>Código de actividad económica III</th>
                            <th>Actividad económica III</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>'.$data['cod_ciiu2'].'</td>
                            <td>'.$data['des_ciiu2'].'</td>
                            <td>'.$data['cod_ciiu3'].'</td>
                            <td>'.$data['des_ciiu3'].'</td>
                        </tr>
                    </tbody>
                </table>
                <table class="table-contenido">
                <thead>
                    <tr>
                        <th>Correo electrónico</th>
                        <th>Descripción de departamento</th>
                        <th>Condición legal a domicilio</th>
                        <th>Fecha de confirmación de correo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>'.$data['cod_correo1'].'</td>
                        <td>'.$data['des_depar1'].'</td>
                        <td>'.$data['des_conleg'].'</td>
                        <td>'.$data['fec_confir1'].'</td>
                    </tr>
                </tbody>
            </table>
                ';
                break;
            case isset($result['getDatosT362']):
                $data = $result['getDatosT362'][0];
                echo '
                <h1 class="text-titulo">Datos Complementarios del Contribuyente</h1>
                <table class="table-contenido">
                <thead>
                    <tr>
                        <th>Número de RUC</th>
                        <th>Oficina RRPP</th>
                        <th>Fecha de actualización</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>'.$data['t362_numruc'].'</td>
                        <td>'.$data['desc_numreg'].'</td>
                        <td>'.$data['t362_fecact'].'</td>
                    </tr>
                </tbody>
            </table>
            
            <table class="table-contenido">
                <thead>
                    <tr>
                        <th>Fecha Baja</th>
                        <th>Número de índice</th>
                        <th>Nombre de la empresa</th>
                        <th>Número de registro</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>'.$data['t362_fecbaj'].'</td>
                        <td>'.$data['t362_indice'].'</td>
                        <td>'.$data['t362_nombre'].'</td>
                        <td>'.$data['t362_numreg'].'</td>
                    </tr>
                </tbody>
            </table>                
                ';
                break;
            case isset($result['getDomicilioLegal']):
                $data = $result['getDomicilioLegal'][0];
                echo '
                <h1 class="text-titulo">Domicilio Legal</h1>
                <table class="table-contenido">
                    <thead>
                        <tr>
                            <th>Domicilio legal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>'.$data['getDomicilioLegalReturn'].'</td>
                        </tr>
                    </tbody>
                </table>
                ';
                break;
            case isset($result['getRepLegales']):
                $data = $result['getRepLegales'];
                echo '<h1 class="text-titulo">Representantes Legales</h1>';
                foreach ($data as $key => $value) {
                    echo '
                    <h5>Representante:</h5>
                    <table class="table-contenido">
                        <thead>
                            <tr>
                                <th>Número de RUC Entidad</th>
                                <th>Nombre del representante</th>
                                <th>Cargo</th>
                                <th>Fecha ocupación del cargo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>'.$value['rso_numruc'].'</td>
                                <td>'.$value['rso_nombre'].'</td>
                                <td>'.$value['rso_cargoo'].'</td>
                                <td>'.$value['rso_vdesde'].'</td>
                            </tr>
                        </tbody>
                        </table>
                        <table class="table-contenido">
                            <thead>
                                <tr>
                                    <th>Tipo de documento</th>
                                    <th>Número de documento</th>
                                    <th>Fecha y hora de actualización</th>
                                    <th>Fecha de nacimiento</th>
                                </tr>
                            </thead>
                        <tbody>
                            <tr>
                                <td>'.$value['desc_docide'].'</td>
                                <td>'.$value['rso_nrodoc'].'</td>
                                <td>'.$value['rso_fecact'].'</td>
                                <td>'.$value['rso_fecnac'].'</td>
                            </tr>
                        </tbody>
                    </table>';
                }
                break;
            default:
                echo '<h1 class="text-titulo">No cuenta con registros</h1>';
                break;
        }
    
    ?>
</body>
</html>