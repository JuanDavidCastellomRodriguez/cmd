<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-ave-especies"name="modal-agregar-ave-especies">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form" data-toggle="validator" v-on:submit.prevent="guardarAveEspecies()" >
                <div class="modal-header">

                    <h4 class="modal-title">Nuevas Aves</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-4 col-sm-12 col-md-6 ">
                            <label for="exampleInputName2">Tipo Producción</label>
                            <select required="required" v-model="nuevaAve.id_tipo_produccione" class="form-control">
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="item in TipoProducciones" :value="item.id">@{{ item.tipo_produccion_aves }}</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6 ">
                            <label for="exampleInputName2">Tipo Ave</label>
                            <select v-model="nuevaAve.id_tipo_ave" class="form-control" required="required">
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="item in TipoAves" :value="item.id">@{{ item.tipo_ave }}</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Tipo Corral</label>
                            <select v-model="nuevaAve.id_tipo_corral" class="form-control" required="required" >
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="item in TipoCorrales" :value="item.id">@{{ item.tipo_corral }}</option>
                            </select>
                        </div>


                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Estado Instalación</label>
                            <select v-model="nuevaAve.id_estado_instalaciones" class="form-control" required="required">
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="item in EstadoCorrales" :value="item.id">@{{ item.estado_instalaciones }}</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Cantidad</label>
                            <input type="number"  class="form-control" id="exampleInputName2" v-model="nuevaAve.cantidad_polluelos" required="required">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Produccion</label>
                            <textarea type="number"  class="form-control" id="exampleInputName2" v-model="nuevaAve.produccion" required="required"></textarea>
                        </div>
                        <!--<div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Cantidad Ponedoras</label>
                            <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevaAve.cantidad_ponedoras" required>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Cantidad Huevos</label>
                            <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevaAve.cantidad_huevos" required>
                        </div>-->
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Cantidad Comida</label>
                            <input type="number" required="required" class="form-control" id="exampleInputName2" v-model="nuevaAve.kg_comida" >
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="exampleInputName2">Observaciones</label>
                            <textarea type="number" required="required" class="form-control" id="exampleInputName2" v-model="nuevaAve.observaciones" ></textarea>
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

<div class="modal fade" id="modal-confirm-delete-ave-especies" tabindex="-1" role="dialog" aria-labelledby="modal-confirm-delete-ave-especies">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Confirme</h4>
            </div>
            <div class="modal-body">
                <label for="">¿Esta seguro que desea quitar este registro de aves?</label>
            </div>
            <div class="modal-footer">
                    <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-default" v-on:click="eliminarAveEspecies()">Si</button>
            </div>
        </div>
    </div>
</div>



