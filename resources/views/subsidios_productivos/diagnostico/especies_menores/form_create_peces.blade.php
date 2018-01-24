<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-peces-especies"name="modal-agregar-peces-especies">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form" data-toggle="validator" v-on:submit.prevent="guardarPecesEspecies()" >
                <div class="modal-header">

                    <h4 class="modal-title">Nuevos Peces</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-4 col-sm-12 col-md-6 ">
                            <label for="exampleInputName2">Tipo Produccion</label>
                            <select v-model="nuevoPeces.id_tipo_produccion" class="form-control" >
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="item in TipoProducciones" :value="item.id">@{{ item.tipo_produccion }}</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Especie</label>
                            <select v-model="nuevoPeces.id_especie" class="form-control" >
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="item in TipoPeces" :value="item.id">@{{ item.especie }}</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Cantidad Estanques</label>
                            <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevoPeces.cantidad_estanques">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Cantidad Producción (Kg)</label>
                            <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevoPeces.kg_producidos">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Cantidad Comida (Kg)</label>
                            <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevoPeces.kg_comida">
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="exampleInputName2">Observaciones</label>
                            <textarea type="number" rows="5" required class="form-control" id="exampleInputName2" v-model="nuevoPeces.observaciones"></textarea>
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

<div class="modal fade" id="modal-confirm-delete-peces-especies" tabindex="-1" role="dialog" aria-labelledby="modal-confirm-delete-peces-especies">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Confirme</h4>
            </div>
            <div class="modal-body">
                <label for="">¿Esta seguro que desea quitar este registro de peces?</label>
            </div>
            <div class="modal-footer">
                    <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-default" v-on:click="eliminarPecesEspecies()">Si</button>
            </div>
        </div>
    </div>
</div>



