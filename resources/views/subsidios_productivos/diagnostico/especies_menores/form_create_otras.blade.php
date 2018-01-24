<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-otras-especies"name="modal-agregar-otras-especies">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form" data-toggle="validator" v-on:submit.prevent="guardarOtrasEspecies()" >
                <div class="modal-header">

                    <h4 class="modal-title">Nueva Otras Especies</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-6 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Especie</label>
                            <input type="text"  class="form-control" v-model="nuevaOtras.especie">
                        </div>

                        <div class="form-group col-lg-6 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Cantidad</label>
                            <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevaOtras.cantidad_animales">
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="exampleInputName2">Observaciones</label>
                            <textarea rows="5" required class="form-control" id="exampleInputName2" v-model="nuevaOtras.observaciones"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                        <button type="button" class="btn btn-default" data-dismiss="modal"  v-on:click="formReset()" >Cancelar</button>
                        <button type="submit"  class="btn btn-default " data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando..."   id="btn-guardar">Guardar</button>

                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal-confirm-delete-otras-especies" tabindex="-1" role="dialog" aria-labelledby="modal-confirm-delete-otras-especies">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Confirme</h4>
            </div>
            <div class="modal-body">
                <label for="">¿Esta seguro que desea quitar este registro de otras especies?</label>
            </div>
            <div class="modal-footer">
                    <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-default" v-on:click="eliminarOtrasEspecies()">Si</button>
            </div>
        </div>
    </div>
</div>



