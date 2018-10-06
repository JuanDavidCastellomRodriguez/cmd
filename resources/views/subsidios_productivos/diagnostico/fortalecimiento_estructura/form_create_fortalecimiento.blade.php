<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-fortalecimiento" name="modal-agregar-fortalecimiento">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form" data-toggle="validator" v-on:submit.prevent="guardarFortalecimiento()" >
                <div class="modal-header">

                    <h4 class="modal-title">Nuevo Mejoramiento</h4>
                </div>

                <div class="modal-body">
                    <div class="row">                        
                        <div class="form-group col-sm-12">
                            <label for="exampleInputName2">Tipo de Infraestructura</label>
                            <textarea type="number" required class="form-control" id="exampleInputName2" v-model="nuevaInfraestructura.tipo" required></textarea>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="exampleInputName2">Descripcion de la Infraestructura</label>
                            <textarea type="number" required class="form-control" id="exampleInputName2" v-model="nuevaInfraestructura.descripcion" required></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"  v-on:click="formReset()" >Cancelar</button>
                        <button type="submit"  class="btn btn-default " data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando..."   id="btn-guardar">Guardar</button>

                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal-confirm-delete-fortalecimiento" tabindex="-1" role="dialog" aria-labelledby="modal-confirm-delete-fortalecimiento">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Confirme</h4>
            </div>
            <div class="modal-body">
                <label for="">¿Esta seguro que desea quitar este Fortalecimiento de Infraestructura?</label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-default" v-on:click="eliminarFortalecimiento()">Si</button>
            </div>
        </div>
    </div>
</div>