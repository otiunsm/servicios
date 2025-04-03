$(document).ready(function () {
    $('#agregar').on('click', function () {
        const categoriaID = $('#categoriaPresupuestal').val();
        const categoriaNombre = $('#categoriaPresupuestal option:selected').text();
        
        const programaID = $('#programaPresupuestal').val();
        const programaNombre = $('#programaPresupuestal option:selected').text();
        
        const fuenteID = $('#fuenteFinanciamiento').val();
        const fuenteNombre = $('#fuenteFinanciamiento option:selected').text();
        
        const metaID = $('#meta').val();
        const metaNombre = $('#meta option:selected').text();
        
        const clasificadoresIDs = $('#clasificadores').val();
        const clasificadoresNombres = $('#clasificadores option:selected')
            .map(function() { return $(this).text(); })
            .get()
            .join(', ');

        if (!categoriaID || !programaID || !fuenteID || !metaID || clasificadoresIDs.length === 0) {
            alert("Por favor selecciona todos los campos obligatorios.");
            return;
        }

        const rowCount = $('#tableBody tr').length;
        const newRow = `
            <tr class="text-center">
                <td>${rowCount + 1}</td>
                <td>${categoriaNombre}<input type="hidden" name="detalles[${rowCount}][id_categoria]" value="${categoriaID}"></td>
                <td>${programaNombre}<input type="hidden" name="detalles[${rowCount}][id_programa]" value="${programaID}"></td>
                <td>${fuenteNombre}<input type="hidden" name="detalles[${rowCount}][id_fuente]" value="${fuenteID}"></td>
                <td>${metaNombre}<input type="hidden" name="detalles[${rowCount}][id_meta]" value="${metaID}"></td>
                <td>${clasificadoresNombres}
                    ${clasificadoresIDs.map(id => `<input type="hidden" name="detalles[${rowCount}][clasificadores][]" value="${id}">`).join('')}
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row">Eliminar</button>
                </td>
            </tr>
        `;
        $('#tableBody').append(newRow);

        // Limpiar los campos seleccionados en el formulario
        document.getElementById('programaPresupuestal').disabled = true;
        document.getElementById('categoriaPresupuestal').disabled = true;
        $('#fuenteFinanciamiento').val('').selectpicker('refresh');
        $('#meta').val('').selectpicker('refresh');
        $('#clasificadores').val([]).selectpicker('refresh');
    });

    // Evento para eliminar una fila de la tabla cuando se hace clic en el botón "Eliminar"
    $(document).on('click', '.remove-row', function () {
        $(this).closest('tr').remove();
        // Reordenar el índice de fila
        $('#tableBody tr').each(function(index) {
            $(this).find('td:first').text(index + 1);
        });
    });
});
