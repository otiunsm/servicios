'use strict';

$(document).ready(function(){
	$("#kt_datatable").DataTable({
		ajax: '../user/listar',		
		columns: [
     {
                data: null, // No tiene datos directamente del servidor
                render: function (data, type, row, meta) {
                    // Calcula el número correlativo considerando la página actual
                    return meta.settings._iDisplayStart + meta.row + 1;
                }
            },
			{ data: 'nombre' },
			{ data: 'apellido' },
			{ data: 'usuario' },
			{ data: 'dni' },
			{ data: 'telefono' },
			{ data: 'nombreperfil' },
			{ data: 'accion', 
			  render: function (data, type, row) {
				  return '<button class="btn btn-sm" id="buttonUserEdit" itemButton="' + row.id_usuario + '"><i class="fa fa-user-edit text-success"></i></button>' +
						 '<button class="btn btn-sm" id="buttonDelete" itemButton="' + row.id_usuario + '"><i class="fas fa-user-times text-danger"></i></button>';
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