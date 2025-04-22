"use strict";

document.addEventListener("DOMContentLoaded", function () {
    const table = $('#tablaconst').DataTable({
        ajax: {
            url: `${base_url}/constanciacontroller/listar`,
            type: "GET",
            data: function (d) {
                d.expediente = $('#filtroExpediente').val();
                d.escuela = $('#filtroEscuela').val();
            }
        },
        processing: true,
        serverSide: true,
        pageLength: 25,
        language: {
            search: "Buscar:",
            searchPlaceholder: "Código o Nombre..."
        },
        columns: [
            {
                data: null,
                render: (data, type, row) => {
                    return `<span style="color: blue; text-decoration: underline;">
                                ${row.NroExpedienteConstancia} - ${row.NroExpedienteTramite}
                            </span>`;
                }
            },
            { data: 'CodigoAlumnoSira' },
            { data: 'Alumno' },
            { data: 'TipoConstancia' },
            { data: 'EscuelaProfesional' },
            {
                data: 'FechaAtencion',
                render: (data) => {
                    const fecha = new Date(data);
                    return fecha.toLocaleDateString('es-PE');
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    return `<a href="${base_url}/constanciacontroller/generarPDF/${row.CodigoTramite}/${row.CodigoTipoConstancia}" 
                                target="_blank" class="btn btn-light">
                                <i class="fas fa-file-pdf text-danger"></i> Ver
                            </a>`;
                }
            }
        ]
    });

    table.on('processing.dt', function (e, settings, processing) {
        const loader = document.getElementById('loading-indicator');
        loader.style.display = processing ? 'block' : 'none';
    });

    $('#filtroExpediente, #filtroEscuela').on('input change', function () {
        table.ajax.reload();
    });
});
