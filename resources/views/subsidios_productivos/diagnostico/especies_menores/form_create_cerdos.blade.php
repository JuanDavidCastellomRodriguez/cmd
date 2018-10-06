<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-cerdo-especies"name="modal-agregar-cerdo-especies">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form" data-toggle="validator" v-on:submit.prevent="guardarCerdoEspecies()" >
                <div class="modal-header">

                    <h4 class="modal-title">Nuevos Cerdos</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-4 col-sm-12 col-md-6 ">
                            <label for="exampleInputName2">Tipo Produccion</label>
                            <select required="required" v-model="nuevoCerdo.id_tipo_produccion" class="form-control" >
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="item in tipoProduccionCerdo" :value="item.id">@{{ item.tipo_produccion }}</option>

                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Tipo Corral</label>
                            <select required="required" v-model="nuevoCerdo.id_tipo_corral" class="form-control" >
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="item in TipoCorrales" :value="item.id">@{{ item.tipo_corral }}</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Estado Instalación</label>
                            <select required="required" v-model="nuevoCerdo.id_estado_instalaciones" class="form-control" >
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="item in EstadoCorrales" :value="item.id">@{{ item.estado_instalaciones }}</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Metodo de Reproducción</label>
                            <select required="required" v-model="nuevoCerdo.id_metodo_reproduccion" class="form-control" >
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="item in TiposReproduccion" :value="item.id">@{{ item.metodo_reproduccion }}</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Cantidad Animales</label>
                            <input type="number" required="required" class="form-control" id="exampleInputName2" v-model="nuevoCerdo.cantidad_animales">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Cantidad Producidos (Kg)</label>
                            <input type="number" required="required" class="form-control" id="exampleInputName2" v-model="nuevoCerdo.kg_producidos">
                        </div>
                        <!--<div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Cantidad Comida (Kg)</label>
                            <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevoCerdo.kg_comida">
                        </div>-->
                        <div class="form-group col-sm-12">
                            <label for="exampleInputName2">Observaciones</label>
                            <textarea type="number" required="required" class="form-control" rows="5" id="exampleInputName2" v-model="nuevoCerdo.observaciones"></textarea>
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

<div class="modal fade" id="modal-confirm-delete-cerdo-especies" tabindex="-1" role="dialog" aria-labelledby="modal-confirm-delete-cerdo-especies">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Confirme</h4>
            </div>
            <div class="modal-body">
                <label for="">¿Esta seguro que desea quitar este registro de cerdos?</label>
            </div>
            <div class="modal-footer">
                    <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-default" v-on:click="eliminarCerdoEspecies()">Si</button>
            </div>
        </div>
    </div>
</div>



