// Función para mostrar alertas de error o advertencia
function AlertShowN(typeerror, error, msg) {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "2000",  // Cambia este valor si es necesario
        "timeOut": "10000",      // Cambia este valor para que sea más largo (10s en este caso)
        "extendedTimeOut": "5000", // Tiempo adicional si el usuario interactúa
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    
    if (typeerror) {
        toastr.warning(msg);
    } else {
        toastr.error("Error: " + error, msg);
    }
}


//alerta de verificacion para el siguete paso
function showConfirmationAlert(action, itemButton, successCallback) {
    Swal.fire({
        title: `¿Estás seguro de que deseas ${action} este registro?`,
        text: `Esta acción no se puede deshacer.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'No, cancelar',
        reverseButtons: true,
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return new Promise((resolve) => {
                // Simula un retraso en el procesamiento
                setTimeout(() => {
                    resolve();
                }, 1000);
            });
        },
        allowOutsideClick: () => !Swal.isLoading(),
    }).then((result) => {
        if (result.isConfirmed) {
            successCallback(itemButton);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire('Cancelado', 'La acción fue cancelada.', 'error');
        }
    });
}

// Función de confirmación de eliminación sin redireccionamiento adicional
function AlertSw(itemButton) {
    Swal.fire({
        title: "¿Estás seguro de eliminar este registro?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "No, cancelar",
        reverseButtons: true,
        showLoaderOnConfirm: true, // Mostrar cargando mientras se procesa
        preConfirm: () => {
            return new Promise((resolve) => {
                setTimeout(() => {
                    resolve();
                }, 1000);  // Simular espera de procesamiento
            });
        },
        allowOutsideClick: () => !Swal.isLoading() // Evitar cerrar al hacer clic fuera si está cargando
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirigir inmediatamente sin espera adicional y sin mostrar otra alerta
            window.location = window.location + '/eliminar/' + itemButton;
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire(
                'Cancelado',
                'La eliminación fue cancelada.',
                'error'
            );
        }
    });
}
