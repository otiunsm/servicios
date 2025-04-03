'use strict';

$(document).ready(function () {
$("#tablacentrocostos").DataTable({
    ajax: {
        url: "SegCentrocostos/cargartabla",
        type: "GET",
        dataSrc: "data"
    },
    columns: [
        { data: "codigocen" },
        { data: "nombrecen" },
        { data: "descripcion" },
        {
            data: "estado",
            render: function (data, type, row) {
                if (data == 1) {
                    return '<span class="badge badge-success">Activo</span>';
                } else {
                    return '<a href="SegCentrocostos/activar/'+ row.idCentro +'" class="btn"><span class="badge badge-danger">Inactivo</span></a>';
                }
            }
        },
        {
            data: "idCentro",
            render: function (data, type, row) {
                return `
                    <div class="btn-group">
                        <button class="btn view-centro-costo" data-id="${data}" data-toggle="modal" data-target="#formCentroCostoVisual">
                            <i class="fas fa-eye text-warning"></i>
                        </button>
                        <button class="btn edit-centro-costo" data-id="${data}" data-toggle="modal" data-target="#formCentroCostoEdit">
                            <i class="fas fa-edit text-success"></i>
                        </button>
                        <button class="btn delete-centro-costo" data-id="${data}">
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
