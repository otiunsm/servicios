"use strict";
var KTDatatablesBasicPaginations = {
    init: function() {
        $("#kt_datatable").DataTable({
            deferRender: true,
            responsive: !0,
            pageLength: 25,
            pagingType: "full_numbers",
        })
    }
};
jQuery(document).ready((function() {
    KTDatatablesBasicPaginations.init()
}));