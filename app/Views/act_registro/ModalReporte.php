
<div class="modal fade" id="ModalReporte" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="kt_login2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">GENERAR REPORTE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form method="POST" id="">
                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>FECHA INICIO <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="" name="" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>FECHA FIN<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="" name="" />
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success font-weight-bold" onclick="GuardarEditar()">Reporte</button>
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>