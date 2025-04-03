'use strict';

$(document).ready(function () {
    // Configuración de DataTables
    $("#tablamet").DataTable({
        ajax: {
            url: "SegMetas/cargartabla", // Endpoint para obtener las metas
            type: "GET", // Método HTTP
            dataSrc: "data" // Propiedad del JSON que contiene los datos
        },
        columns: [
            { data: "codigo_meta" }, // Columna para el código de la meta
            { data: "codigo_actividad" }, // Columna para el código de la actividad
            { data: "nombre_meta" }, // Columna para el nombre de la actividad
            {
                data: "estado", // Columna para el estado de la meta
                render: function (data, type, row) {
                    if (data == 1) {
                        return '<span class="badge badge-success">Activo</span>';
                    } else {
                        return '<a href="SegMetas/activar/'+ row.id_meta +'" class="btn"><span class="badge badge-danger">Inactivo</span></a';
                    }
                }
            },
            {
                data: "id_meta", // Columna para las acciones
                render: function (data, type, row) {
                    return `
                        <div class="btn-group">
                            <button class="btn view-meta" data-id="${data}" data-toggle="modal" data-target="#formMetaVisual">
                                <i class="fas fa-eye text-warning"></i>
                            </button>
                            <button class="btn edit-meta" data-id="${data}" data-toggle="modal" data-target="#formMetaEdit">
                                <i class="fas fa-edit text-success"></i>
                            </button>
                            <button class="btn delete-meta" data-id="${data}">
                                <i class="fas fa-trash-alt text-danger"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        processing: true, // Muestra un mensaje de "Procesando..." mientras se cargan los datos
        serverSide: true, // Habilita el modo servidor para manejar grandes cantidades de datos
        pageLength: 25, // Número de registros por página
        language: {
            infoFiltered: "" // Personaliza el mensaje de "Filtrado"
        }
    });
});