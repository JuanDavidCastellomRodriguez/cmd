<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-manejo-bovino"name="modal-agregar-manejo-bovino">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form" data-toggle="validator" v-on:submit.prevent="guardarManejoBovino()" >
                <div class="modal-header">

                    <h4 class="modal-title">Nuevo Manejo de Animales</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-4 col-sm-12 col-md-6 ">
                            <label for="exampleInputName2">Actividad</label>
                            <select v-model="nuevoManejo.id_actividad_manejo" class="form-control" >
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="manejo in actividadesManejo" :value="manejo.id" >@{{ manejo.nombre_actividad }}</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Producto</label>
                            <input type="text" required class="form-control" id="exampleInputName2" v-model="nuevoManejo.producto_actividad">
                        </div>

                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Cantidad</label>
                            <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevoManejo.cantidad">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Periodicidad</label>
                            <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevoManejo.periodicidad">
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

<div class="modal fade" id="modal-confirm-delete-manejo-bovino" tabindex="-1" role="dialog" aria-labelledby="modal-confirm-delete-manejo-bovino">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Confirme</h4>
            </div>
            <div class="modal-body">
                <label for="">¿Esta seguro que desea quitar este manejo de animales?</label>
            </div>
            <div class="modal-footer">
                    <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-default" v-on:click="eliminarManejoBovino()">Si</button>
            </div>
        </div>
    </div>
</div>



