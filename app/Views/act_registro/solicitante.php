<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <h5 class="text-dark font-weight-bold my-1 mr-5">Gestionar Usuarios</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url() ?>" class="text-muted">Panel de Control</a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
        </div>
    </div>
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="card-title">
                        <h3 class="card-label">Lista de Solicitantes</h3>
                    </div>
                    <div class="card-toolbar">
                        <div class="dropdown dropdown-inline mr-2">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#formSoli"><i class="fas fa-user-plus"></i> Nuevo Solicitante</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-separate table-head-custom table-checkable table-sm" id="kt_datatable">
                        <thead>
                            <tr>
                                <th class="text-center">Item</th>
                                <th>N° Documento</th>
                                <th>Nombre(s)</th>
                                <th>Email</th>
                                <th>Celular</th>
                                <th>Dirección</th>
                                <th>Cargo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($Act_solicitante) {
                                foreach ($Act_solicitante as $key => $soli) {
                                    echo '
                                    <tr>
                                        <td class="text-center">' . ($key + 1) . '</td>
                                        <td>' . $soli['dni_so'] . '</td>
                                        <td>' . $soli['nombre_so'] . '</td>
                                        <td>' . $soli['email_so'] . '</td>
                                        <td>' . $soli['telefono_so'] . '</td>          
                                        <td>' . $soli['direccion_so'] . '</td>
                                        <td>' . $soli['cargo_so'] . '</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button class="btn btn-sm" id="buttonSoliEdit" itemButton="' . $soli['id_solicitante'] . '"><i class="fa fa-user-edit text-success"></i></button>
                                                <button class="btn btn-sm" id="buttonDelete" itemButton="' . $soli['id_solicitante'] . '"><i class="fas fa-user-times text-danger"></i></button>
                                            </div>
                                        </td>
                                    </tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->

<!-- Modal-->
<div class="modal fade" id="formSoli" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Formulario de Solicitante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" action="Act_solicitante/formData" id="form_solicitante">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>DNI <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="dni_so" name="dni_so" placeholder="DNI" />
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-success btn-flat" onclick="buscarDni()">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Nombres y Apellidos <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nombre_so" name="nombre_so" placeholder="Ingrese el nombre"
                                    onfocus="this.placeholder=''" />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Dirección</label>
                                <input type="text" class="form-control" id="direccion_so" name="direccion_so" placeholder="Ingrese la dirección" />
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Correo</label>
                                <input type="text" class="form-control" name="email_so" placeholder="Email" />
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Telefono</label>
                                <input type="text" class="form-control" name="telefono_so" placeholder="Ingrese número de celular" />
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Cargo</label>
                                <input type="text" class="form-control" name="cargo_so" placeholder="Ingrese la dirección" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submitButton2" class="btn btn-success font-weight-bold">Guardar</button>
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function buscarDni() {
        const dni = $("#dni_so").val(); // Obtener el valor del campo DNI
        if (dni === "") { // Validar si se ha ingresado un DNI
            alert("Por favor, ingrese un DNI.");
            return;
        }
        $.ajax({
            type: 'get',
            url: "../apis/apis_reniec",
            data: {
                dni_consult: dni
            },
            success: function(response) {
                try {
                    var datos = JSON.parse(response);
                    var data = datos.result[0]
                    $('#nombre_so').val(data.apPrimer + ' ' + data.apSegundo + ' ' + data.prenombres);
                    $('#direccion_so').val(data.direccion);

                    //alerta.
                   /* Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Datos cargados correctamente.',
                        confirmButtonText: 'Aceptar'
                    });*/
                   
                } catch (e) {
                    console.error("Error al procesar la respuesta: ", e);
                    alertShow('error', e.message, "Error al procesar la respuesta del servidor.");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX: ", textStatus, errorThrown);
                alert("Ocurrió un error al consultar el DNI. Inténtelo de nuevo.");
            }
        });
    }
</script>

<!--consumo de ampis-->


<!--<script>
    function buscarDni() {
        // Obtener el DNI ingresado por el usuario
        const dni = document.getElementById("dni_so").value;

        // Validar que se haya ingresado el DNI
        if (dni === "") {
            alert("Por favor, ingrese un DNI.");
            return;
        }

        // Hacer la solicitud a la API de RENIEC
        fetch(`https://soporte.unsm.edu.pe/wsdl/wsdl_reniec.php?dni=${dni}`)
            .then(response => response.json())
            .then(data => {
                // Verificar si los datos fueron encontrados
                if (data.apPrimer && data.prenombres) {
                    // Concatenar nombres y apellidos
                    const nombresYApellidos = `${data.prenombres} ${data.apPrimer} ${data.apSegundo}`;

                    // Asignar los valores a los campos correspondientes
                    document.getElementById("nombre_so").value = nombresYApellidos;
                    document.getElementById("direccion_so").value = data.direccion;
                } else {
                    alert("No se encontraron datos para el DNI ingresado.");
                }
            })
            .catch(error => {
                console.error("Error al consultar el DNI:", error);
                alert("Hubo un error al consultar el DNI. Por favor, inténtelo nuevamente.");
            });
    }
</script>-->