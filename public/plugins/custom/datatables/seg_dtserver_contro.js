'use strict';

$(document).ready(function () {
    $("#tablacont").DataTable({
        ajax: {
            url: "ControlPresupuestal/cargartabla",
            type: "GET",
            dataSrc: "data"
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.settings._iDisplayStart + meta.row + 1; // Número correlativo
                }
            },
            { data: "nombre_categoria" },
            { data: "nombre_programa" },
            { data: "nombre_fuente" },
            { data: "nombre_meta" },
            {
                
                render: function (data, type, row) {
                    return `
                        <div class="btn-group">
                            <a href="ControlPresupuestal/ControlGastos/${row.id_categoria}/${row.id_programa}/${row.id_fuente}/${row.id_meta}" class="btn btn-outline-primary" name="ingresar">
                                Ingresar
                            </a>
                        </div>
                        <div class="btn-group">
                            <a href="ControlPresupuestal/ResumenGastos/${row.id_categoria}/${row.id_programa}/${row.id_fuente}/${row.id_meta}" class="btn btn-outline-success" name="resumen">
                                Resumen
                            </a>
                        </div>
                    `;
                }
            },
            {
                render: function (data, type, row) {
                    return `
                        <button class="btn" onclick="eliminarControl(${row.id_categoria}, ${row.id_programa}, ${row.id_fuente}, ${row.id_meta})">
                            <i class="fas fa-trash-alt text-danger"></i>
                        </button>
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