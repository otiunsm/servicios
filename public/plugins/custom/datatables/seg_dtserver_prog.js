'use strict';

$(document).ready(function () {
    $("#tablaprog").DataTable({
        ajax: {
            url: "SegProgramas/cargartablap",
            type: "GET",
            dataSrc: "data"
        },
        columns: [
            { data: "codigo_programa" },
            { data: "nombre_programa" },
            {
                data: "estado",
                render: function (data, type, row) {
                    if (data == 1) {
                        return '<span class="badge badge-success">Activo</span>';
                    } else {
                        return '<a href="SegProgramas/activar/'+row.id_programa +'" class="btn"><span class="badge badge-danger">Inactivo</span></a>';
                    }
                }
            },
            {
                data: "id_programa",
                render: function (data, type, row) {
                    return `
                        <div class="btn-group">
                            <button class="btn view-programa" data-id="${data}" data-toggle="modal" data-target="#formProgVisual">
                                <i class="fas fa-eye text-warning"></i>
                            </button>
                            <button class="btn edit-programa" data-id="${data}" data-toggle="modal" data-target="#formProgEdit">
                                <i class="fas fa-edit text-success"></i>
                            </button>
                            <button class="btn delete-programa" data-id="${data}">
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