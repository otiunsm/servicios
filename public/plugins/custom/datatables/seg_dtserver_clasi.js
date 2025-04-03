'use strict';

$(document).ready(function () {
    $("#tablaclasi").DataTable({
        ajax: {
            url: "SegClasificadores/cargartabla",
            type: "GET",
            dataSrc: "data"
        },
        columns: [
            { data: "codigo_clasificador" },
            { data: "nombre_clasificador" },
            {
                data: "estado",
                render: function (data, type, row) {
                    if (data == 1) {
                        return '<span class="badge badge-success">Activo</span>';
                    } else {
                        return '<a href="SegClasificadores/activar/'+ row.id_clasificador +'" class="btn"><span class="badge badge-danger">Inactivo</span></a>';
                    }
                }
            },
            {
                data: "id_clasificador",
                render: function (data, type, row) {
                    return `
                        <div class="btn-group">
                            <button class="btn view-clasificador" data-id="${data}" data-toggle="modal" data-target="#formClasificadorVisual">
                                <i class="fas fa-eye text-warning"></i>
                            </button>
                            <button class="btn edit-clasificador" data-id="${data}" data-toggle="modal" data-target="#formClasificadorEdit">
                                <i class="fas fa-edit text-success"></i>
                            </button>
                            <button class="btn delete-clasificador" data-id="${data}">
                                <i class="fas fa-trash-alt text-danger"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        processing: true,
        serverSide: true,
        pageLength: 25,
        language: {
            infoFiltered: ""
        }
    });
});