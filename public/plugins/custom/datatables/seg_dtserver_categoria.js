'use strict';

$(document).ready(function () {
    $("#tablacat").DataTable({
        ajax: {
            url: "SegCategoria/cargartabla",
            type: "GET",
            dataSrc: "data"
        },
        columns: [
            { data: "codigo_categoria" },
            { data: "nombre_categoria" },
            {
                data: "estado",
                render: function (data, type, row) {
                    if (data == 1) {
                        return '<span class="badge badge-success">Activo</span>';
                    } else {
                        return '<a href="SegCategoria/activar/' + row.id_categoria + '" class="btn"><span class="badge badge-danger">Inactivo</span></a>';
                    }
                }
            },
            {
                data: "id_categoria",
                render: function (data, type, row) {
                    return `
                        <div class="btn-group">
                            <button class="btn view-categoria" data-id="${data}" data-toggle="modal" data-target="#formCatVisual">
                                <i class="fas fa-eye text-warning"></i>
                            </button>
                            <button class="btn edit-categoria" data-id="${data}" data-toggle="modal" data-target="#formCatEdit">
                                <i class="fas fa-edit text-success"></i>
                            </button>
                            <button class="btn delete-categoria" data-id="${data}">
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