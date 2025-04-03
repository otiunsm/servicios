'use strict';

$(document).ready(function () {
    $("#tablafue").DataTable({
        ajax: {
            url: "SegFuentes/cargartabla",
            type: "GET",
            dataSrc: "data"
        },
        columns: [
            { data: "codigo_fuente" },
            { data: "nombre_fuente" },
            {
                data: "estado",
                render: function (data, type, row) {
                    if (data == 1) {
                        return '<span class="badge badge-success">Activo</span>';
                    } else {
                        return '<a href="SegFuentes/activar/'+row.id_fuente+'" class="btn"><span class="badge badge-danger">Inactivo</span></a>';
                    }
                }
            },
            {
                data: "id_fuente",
                render: function (data, type, row) {
                    return `
                        <div class="btn-group">
                            <button class="btn view-fuente" data-id="${data}" data-toggle="modal" data-target="#formFuenteVisual">
                                <i class="fas fa-eye text-warning"></i>
                            </button>
                            <button class="btn edit-fuente" data-id="${data}" data-toggle="modal" data-target="#formFuenteEdit">
                                <i class="fas fa-edit text-success"></i>
                            </button>
                            <button class="btn delete-fuente" data-id="${data}">
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