document.addEventListener('DOMContentLoaded', function() {
    // Verificar jQuery y Bootstrap Select
    if (typeof jQuery == 'undefined' || typeof jQuery.fn.selectpicker == 'undefined') {
        console.error('jQuery o Bootstrap Select no están cargados');
        return;
    }

    const baseUrl = $('meta[name="base-url"]').attr('content') || window.location.origin;
    
    // Inicializar selectpickers
    $('.selectpicker').selectpicker();
    
    // Función para cargar programas
    function loadProgramas(id_categoria) {
        $.ajax({
            url: `${baseUrl}/SegDesglose/getProgramas/${id_categoria}`,
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#id_programa').empty().prop('disabled', true).selectpicker('refresh');
            },
            success: function(data) {
                
                if (data && data.length > 0) {
                    $.each(data, function(key, value) {
                        $('#id_programa').append(`<option value="${value.id_programa}">${value.nombre_programa}</option>`);
                    });
                    $('#id_programa').prop('disabled', false).selectpicker('refresh');
                } else {
                    $('#id_programa').append('<option value="">No hay programas disponibles</option>');
                }
                
                // Resetear selects dependientes
                $('#id_fuente, #id_meta').empty().prop('disabled', true).selectpicker('refresh');
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar programas:', error);
                $('#id_programa').empty().append('<option value="">Error al cargar programas</option>');
            }
        });
    }

    // Función para cargar fuentes
    function loadFuentes(id_programa) {
        $.ajax({
            url: `${baseUrl}/SegDesglose/getFuentes/${id_programa}`,
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#id_fuente').empty().prop('disabled', true).selectpicker('refresh');
            },
            success: function(data) {
                
                if (data && data.length > 0) {
                    $.each(data, function(key, value) {
                        $('#id_fuente').append(`<option value="${value.id_fuente}">${value.nombre_fuente}</option>`);
                    });
                    $('#id_fuente').prop('disabled', false).selectpicker('refresh');
                } else {
                    $('#id_fuente').append('<option value="">No hay fuentes disponibles</option>');
                }
                
                // Resetear meta
                $('#id_meta').empty().prop('disabled', true).selectpicker('refresh');
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar fuentes:', error);
                $('#id_fuente').empty().append('<option value="">Error al cargar fuentes</option>');
            }
        });
    }

    // Función para cargar metas
    function loadMetas(id_fuente) {
        $.ajax({
            url: `${baseUrl}/SegDesglose/getMetas/${id_fuente}`,
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#id_meta').empty().prop('disabled', true).selectpicker('refresh');
            },
            success: function(data) {
                
                if (data && data.length > 0) {
                    $.each(data, function(key, value) {
                        $('#id_meta').append(`<option value="${value.id_meta}">${value.nombre_meta}</option>`);
                    });
                    $('#id_meta').prop('disabled', false).selectpicker('refresh');
                } else {
                    $('#id_meta').append('<option value="">No hay metas disponibles</option>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar metas:', error);
                $('#id_meta').empty().append('<option value="">Error al cargar metas</option>');
            }
        });
    }

    // Eventos
    $('#id_categoria').on('changed.bs.select', function() {
        const id_categoria = $(this).val();
        if (id_categoria) {
            loadProgramas(id_categoria);
        } else {
            $('#id_programa, #id_fuente, #id_meta').empty().prop('disabled', true).selectpicker('refresh');
        }
    });

    $('#id_programa').on('changed.bs.select', function() {
        const id_programa = $(this).val();
        if (id_programa) {
            loadFuentes(id_programa);
        } else {
            $('#id_fuente, #id_meta').empty().prop('disabled', true).selectpicker('refresh');
        }
    });

    $('#id_fuente').on('changed.bs.select', function() {
        const id_fuente = $(this).val();
        if (id_fuente) {
            loadMetas(id_fuente);
        } else {
            $('#id_meta').empty().prop('disabled', true).selectpicker('refresh');
        }
    });
});

const $buscador = $('#buscadorDesglose');

$buscador.on('keyup', function () {
    let vista = $buscador.data('vista');

    $.ajax({
        url: $buscador.data('url'),
        method: 'GET',
        data: {
            nombre: $buscador.val(),
            id_categoria: $buscador.data('categoria'),
            id_programa: $buscador.data('programa'),
            id_fuente: $buscador.data('fuente'),
            id_meta: $buscador.data('meta'),
            vista: vista
        },
        dataType: 'json',
        success: function (data) {
            let cards = '';

            if (data.length > 0) {
                data.forEach(function (d) {
                    if (vista === 'centro') {
                        cards += `
                        <div class="col-md-3 mb-4">
                            <div class="card folder-card">
                                <div class="card-header folder-header">
                                    <i class="fas fa-file-excel fa-3x text-success"></i>
                                    <h5 class="card-title mt-2">${d.nombre_centro}</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <strong>Categoría:</strong> ${d.nombre_categoria}<br>
                                        <strong>Programa:</strong> ${d.nombre_programa}<br>
                                        <strong>Fuente:</strong> ${d.nombre_fuente}<br>
                                        <strong>Meta:</strong> ${d.nombre_meta}
                                    </p>
                                    <div class="d-flex justify-content-center">
                                        <div class="btn-group mr-2">
                                            <a href="${BASE_URL}SegDesglose/ControlGastos/${d.id_categoria}/${d.id_programa}/${d.id_fuente}/${d.id_meta}/${d.id_centro_costos}" class="btn btn-outline-primary">Ingresar</a>
                                        </div>
                                        <div class="btn-group">
                                            <a href="${BASE_URL}SegDesglose/ResumenGastos/${d.id_categoria}/${d.id_programa}/${d.id_fuente}/${d.id_meta}/${d.id_centro_costos}" class="btn btn-outline-success">Resumen</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    } else {
                        cards += `
                        <div class="col-md-3 mb-4">
                            <div class="card folder-card">
                                <div class="card-header folder-header">
                                    <i class="fas fa-folder fa-3x text-warning"></i>
                                    <h5 class="card-title mt-2">${d.nombre_desglose}</h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">
                                        <strong>Categoría:</strong> ${d.nombre_categoria}<br>
                                        <strong>Programa:</strong> ${d.nombre_programa}<br>
                                        <strong>Fuente:</strong> ${d.nombre_fuente}<br>
                                        <strong>Meta:</strong> ${d.nombre_meta}
                                    </p>
                                    <a href="${BASE_URL}SegDesglose/listar/${d.id_categoria}/${d.id_programa}/${d.id_fuente}/${d.id_meta}" class="btn btn-primary btn-block">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                </div>
                            </div>
                        </div>`;
                    }
                });
            } else {
                cards = `<div class="col-12"><p class="text-center">No hay resultados encontrados.</p></div>`;
            }

            $('#cardsContainer').html(cards);
        }
    });
});
