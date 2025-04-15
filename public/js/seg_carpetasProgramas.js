const $buscador = $('#buscador');

$buscador.on('keyup', function () {
    $.ajax({
        url: $buscador.data('url'),
        method: 'GET',
        data: {
            nombre: $buscador.val(),
            id_categoria: $buscador.data('categoria'),
            id_programa: $buscador.data('programa'),
            id_fuente: $buscador.data('fuente'),
            id_meta: $buscador.data('meta'),
            id_carpeta_padre: $buscador.data('padre')
        },
        dataType: 'json',
        success: function (data) {
            let cards = '';
            let tipoVista = $buscador.data('vista');

            if (data.length > 0) {
                data.forEach(function (carpeta) {
                    let urlVista = '';
                    let urlVista2 = '';
                    let encabezado = '';
                    let contenido = '';

                    if (tipoVista === 'programa') {
                        urlVista = `SegCarpetas/listarFuentes/${carpeta.id_categoria}/${carpeta.id_programa}/${carpeta.id_carpeta}`;
                        encabezado = `<i class="fas fa-folder fa-3x text-warning"></i>`;
                        contenido= `<p class="card-text"><strong>Programa:</strong> ${carpeta.nombre_programa}</p>
                                    <p class="card-text"><strong>Descripción:</strong> ${carpeta.descripcion ?? 'Sin descripción'}</p>
                                    <a href="${BASE_URL}${urlVista}" class="btn btn-primary btn-block">
                                        <i class="fas fa-eye"></i> Ver Fuentes
                                    </a>`   
                    } else if (tipoVista === 'fuente') {
                        urlVista = `SegCarpetas/listarMetas/${carpeta.id_carpeta}/${carpeta.id_categoria}/${carpeta.id_programa}/${carpeta.id_fuente}`;
                        encabezado = `<i class="fas fa-folder fa-3x text-warning"></i>`;
                        contenido= `<p class="card-text"><strong>Programa:</strong> ${carpeta.nombre_programa}</p>
                                    <p class="card-text"><strong>Fuente:</strong> ${carpeta.nombre_fuente}</p>
                                    <p class="card-text"><strong>Descripción:</strong> ${carpeta.descripcion ?? 'Sin descripción'}</p>
                                    <a href="${BASE_URL}${urlVista}" class="btn btn-primary btn-block">
                                        <i class="fas fa-eye"></i> Ver Metas
                                    </a>`
                    }else if (tipoVista === 'meta') {
                        urlVista = `SegCarpetas/ControlGastos/${carpeta.id_categoria}/${carpeta.id_programa}/${carpeta.id_fuente}/${carpeta.id_meta}`;
                        urlVista2 = `SegCarpetas/ResumenGastos/${carpeta.id_categoria}/${carpeta.id_programa}/${carpeta.id_fuente}/${carpeta.id_meta}`;                        
                        encabezado = `<i class="fas fa-file-excel fa-3x text-success"></i>`;
                        contenido= `<p class="card-text">
                                        <strong>Programa:</strong> ${carpeta.nombre_programa}<br>
                                        <strong>Fuente:</strong> ${carpeta.nombre_fuente}<br>
                                        <strong>Meta:</strong> ${carpeta.nombre_meta}
                                    </p>
                                    <div class="d-flex justify-content-center">
                                        <div class="btn-group mr-2">
                                            <a href="${BASE_URL}${urlVista}" class="btn btn-outline-primary" name="ingresar">
                                                Ingresar
                                            </a>
                                        </div>
                                            <div class="btn-group">
                                                <a href="${BASE_URL}${urlVista}" class="btn btn-outline-success" name="resumen">
                                                    Resumen
                                                </a>
                                            </div>
                                    </div>`
                    }

                    cards += `
                        <div class="col-md-3 mb-4">
                            <div class="card folder-card">
                                <div class="card-header folder-header">
                                    ${encabezado} 
                                    <h5 class="card-title mt-2">${carpeta.nombre_carpeta}</h5>
                                </div>
                                <div class="card-body">
                                    ${contenido}    
                                </div>
                            </div>
                        </div>`;
                });
            } else {
                cards = `<div class="col-12"><p class="text-center">No hay carpetas con ese nombre.</p></div>`;
            }

            $('#cardsContainer').html(cards);
        }
    });
});
