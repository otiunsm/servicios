// EDITAR ARTICULO
$(document).on('click', '#btn_editar',function() {
    let id = $(this).attr('itemButton');
    $.ajax({
        type: "get",
        url: 'inventario/listar',
        data:{id},
        dataType: "json",
        success: function(response){
            if (response.Status == '200') {
                $('[name="id_item"]').val(response.Mensaje.id);
                $('[name="equipo"]').val(response.Mensaje.id_equipo);
                $('[name="descripcion"]').val(response.Mensaje.descripcion);
                $('[name="responsable"]').val(response.Mensaje.id_responsable);
                $('[name="marca"]').val(response.Mensaje.id_marca);
                $('[name="modelo"]').val(response.Mensaje.id_modelo);
                 $('[name="condicion"]').val(response.Mensaje.id_condicion);
                $('[name="sede"]').val(response.Mensaje.id_sede);
                $('[name="dependencia"]').val(response.Mensaje.id_dependencia);
                $('#formularioArticulo').modal('show');
                console.log('Correcto', response);
            }else{
                    alertShow(response.Status, response.Mensaje);
            }
        }
    })
})

// DELETE
$(document).on('click', '#buttonDelete', function() {
    var itemButton = $(this).attr('itemButton');
    AlertSw(itemButton);
})


// //Cargar datos ingresando DNI
//   $('[name="dni"]').focusout(function(){
      
//     let dni =  $('[name="dni"]').val();
	
//     $.ajax({
// 		type: "get",
//         url: '../apis/api_personal',
// 		data:{dni},
//         contentType: "application/json",
//         dataType: 'json',
//         success: function(result){
//             let persona = JSON.parse(result);
//             if (persona.message === undefined){
//                 $('[name="nombre"]').val(persona[0].nombre);
//                 $('[name="apellidos"]').val(persona[0].appaterno +" "+ persona[0].apmaterno );
//                 $('[name="usuario"]').val(persona[0].nrodocumento);
//             } else {
//                 console.log(persona.message);
//             }
//         }
//     })
    
//   });
  


// EDITAR PERFIL
$(document).on('click', '#buttonPerEdit', function(){
    $('#form_per_edit').trigger('reset');
	let id = $(this).attr('itemButton');
	$.ajax({
	  type: "post",
	  url: 'perfiles/listar_perfil',
	  data:{id},
	  dataType: "json",
	  success: function(respuesta){
        console.log('respuesta :', respuesta);
	  	$('#formPerEdit [name="id_item"]').val(respuesta[0]['id_perfil']);
	  	$('#formPerEdit [name="nomPerfil"]').val(respuesta[0]['nombreperfil']);
		respuesta[1].forEach( function(element, index) {
			$('#formPerEdit .check-'+element['idmodulo']).prop('checked', true);
		});
        $('#formPerEdit').modal('show');
	  }
	})
})