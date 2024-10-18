
function alertShow(typeerror, error, msg) {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "500",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      };
      if( typeerror ){
        toastr.warning( msg );
      }
      else{
        toastr.error("Error: "+error, msg);
      }
}

function AlertSw(itemButton) {
    Swal.fire({
        title: "¿Desea eliminar este registro?",
        text: "Esta acción es irreversible",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, cancelar!",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {
            window.location = window.location+'/eliminar/'+itemButton;
        }
    });
}