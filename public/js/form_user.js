$(document).on('click', '#buttonUserEdit', function () {
    const item_user = $(this).attr('itemButton');
    const url = 'user/listar_user';
    const data = { item_user };

    $.get(url, data, function (response) {
        if (response.Status === '200') {
            const { id_usuario, dni, nombre, apellido, telefono, direccion, idperfil_usuario, correo, usuario } = response.Mensaje;

            $('[name="id_item"]').val(id_usuario);
            $('[name="dni"]').val(dni);
            $('[name="nombre"]').val(nombre);
            $('[name="apellidos"]').val(apellido);
            $('[name="celular"]').val(telefono);
            $('[name="direccion"]').val(direccion);
            $('[name="perfil"]').val(idperfil_usuario);
            $('[name="correo"]').val(correo);
            $('[name="usuario"]').val(usuario);
            $('#formUser').modal('show');
            console.log('Correcto', response);
        } else {
            alertShow(response.Status, response.Mensaje);
        }
    }, 'json');
});

$(document).on('click', '#buttonDelete', function () {
    const itemButton = $(this).attr('itemButton');
    AlertSw(itemButton);
});

$('[name="dni"]').focusout(function() {
  const dni = $('[name="dni"]').val();
  const url = '../apis/api_personal';
  const data = { dni };

  $.get(url, data, function(result) {
    const persona = JSON.parse(result);

    if (persona.message) {
      console.log(persona.message);
      return;
    }

    const { nombre, appaterno, apmaterno, nrodocumento } = persona[0];
    $('[name="nombre"]').val(nombre);
    $('[name="apellidos"]').val(`${appaterno} ${apmaterno}`);
    $('[name="usuario"]').val(nrodocumento);
  }, 'json');
});

$(document).on('click', '#testp', function () {
    const dni = $('[name="dni"]').val();
    const url = '../apis/api_personal';
    const data = { dni };

    $.get(url, data, function (result) {
        console.log(result);
    }, 'json');
});

$(document).on('click', '#buttonPerEdit', function () {
    $('#form_per_edit').trigger('reset');
    const id = $(this).attr('itemButton');
    const url = 'perfiles/listar_perfil';
    const data = { id };

    $.post(url, data, function (respuesta) {
        console.log('respuesta:', respuesta);
        const { id_perfil, nombreperfil } = respuesta[0];

        $('#formPerEdit [name="id_item"]').val(id_perfil);
        $('#formPerEdit [name="nomPerfil"]').val(nombreperfil);

        respuesta[1].forEach(function (element) {
            $(`#formPerEdit .check-${element.idmodulo}`).prop('checked', true);
        });

        $('#formPerEdit').modal('show');
    }, 'json');
});