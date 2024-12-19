<div class="modal fade" id="modalsolic" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Formulario de Solicitante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" id="form_solicitante">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="hidden" id="id_solicitante" name="id_solicitante">
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
                                <input type="text" class="form-control" id="email_so" name="email_so" placeholder="Email" />
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Telefono</label>
                                <input type="text" class="form-control" id="telefono_so" name="telefono_so" placeholder="Ingrese número de celular" />
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Cargo</label>
                                <input type="text" class="form-control" id="cargo_so" name="cargo_so" placeholder="Ingrese la dirección" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success font-weight-bold" onclick="GuardarEditar()">Guardar</button>
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