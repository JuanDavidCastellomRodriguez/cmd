<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-bovino"name="modal-agregar-bovino">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form" data-toggle="validator" v-on:submit.prevent="guardarBovino()" >
                <div class="modal-header">

                    <h4 class="modal-title">Nuevo Cultivo</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-4 col-sm-12 col-md-6 ">
                            <label for="exampleInputName2">Tipo de Bovino</label>
                            <select v-model="nuevoBovino.id_tipo_bovino" class="form-control" >
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="tipo in tipoBovino" :value="tipo.id" >@{{ tipo.tipo_animal }}</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6 ">
                            <label for="exampleInputName2">Raza</label>
                            <select v-model="nuevoBovino.id_raza" class="form-control" >
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="raza in razas" :value="raza.id" >@{{ raza.raza }}</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6 ">
                            <label for="exampleInputName2">Tenencia</label>
                            <select v-model="nuevoBovino.id_tipo_propiedad" class="form-control" >
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="propiedad in TipoPropiedades" :value="propiedad.id" >@{{ propiedad.tipo_propiedad }}</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Cantidad</label>
                            <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevoBovino.cantidad">
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

<div class="modal fade" id="modal-confirm-delete-bovino" tabindex="-1" role="dialog" aria-labelledby="modal-confirm-delete-bovino">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Confirme</h4>
            </div>
            <div class="modal-body">
                <label for="">¿Esta seguro que desea quitar estos bovinos?</label>
            </div>
            <div class="modal-footer">
                    <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-default" v-on:click="eliminarBovino()">Si</button>
            </div>
        </div>
    </div>
</div>



