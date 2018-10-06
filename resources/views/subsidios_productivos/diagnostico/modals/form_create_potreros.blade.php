<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-potrero"name="modal-agregar-potrero">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form" data-toggle="validator" v-on:submit.prevent="guardarPotrero()" >
                <div class="modal-header">

                    <h4 class="modal-title">Nuevo Potrero</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Nombre Potrero</label>
                            <input type="text" required="required" class="form-control" id="exampleInputName2" v-model="nuevoPotrero.potrero_lote">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Extension (Hectareas)</label>
                            <input type="number" required="required" class="form-control" id="exampleInputName2" v-model="nuevoPotrero.extension_has" step="0.1">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Dias de Descanso</label>
                            <input type="number" required="required" class="form-control" id="exampleInputName2" v-model="nuevoPotrero.rotacional_dias_descanso">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Dias Ocupado</label>
                            <input type="number" required="required" class="form-control" id="exampleInputName2" v-model="nuevoPotrero.rotacional_dias_ocupacion">
                        </div>

                        <div class="form-group col-lg-4 col-sm-12 col-md-6 ">
                            <label for="exampleInputName2">Tipo Cobertura</label>
                            <select required="required" v-model="nuevoPotrero.id_tipo_cobertura" class="form-control" v-on:change="coberturaSelected($event.target.value, $event.target[$event.target.selectedIndex].text)">
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="tipo in tipoCobertura" :value="tipo.id">@{{ tipo.tipo_cobertura }}</option>


                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6 ">
                            <label for="exampleInputName2">Subtipo Cobertura</label>
                            <select required="required" v-model="nuevoPotrero.id_subtipo_cobertura" class="form-control" v-on:change="subcoberturaSelected($event.target[$event.target.selectedIndex].text)">
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="subtipos in subtipoCobertura" :value="subtipos.id" >@{{ subtipos.subtipo_cobertura }}</option>


                            </select>
                        </div>

                        <div class="form-group col-lg-4 col-sm-12 col-md-6 ">
                            <label for="exampleInputName2">Fuente Hidrica</label>
                            <select required="required" v-model="nuevoPotrero.id_fuente_hidrica" class="form-control" v-on:change="fuenteSelected($event.target[$event.target.selectedIndex].text)">
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="fuente in fuentesHidricas" :value="fuente.id" >@{{ fuente.tipo_fuentes_hidricas }}</option>


                            </select>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputName2">Uso</label>
                            <textarea  required="required" class="form-control" id="exampleInputName2" v-model="nuevoPotrero.uso"></textarea>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputName2">Observaciones</label>
                            <textarea  required="required" class="form-control" id="exampleInputName2" v-model="nuevoPotrero.observaciones"></textarea>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                    <button type="button" class="btn btn-default" data-dismiss="modal"  v-on:click="formReset()" >Cancelar</button>
                    <button type="submit"  class="btn btn-default " data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando..."   id="btn-guardar">Agregar</button>

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal-confirm-delete-potrero" tabindex="-1" role="dialog" aria-labelledby="modal-confirm-delete-potrero">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Confirme</h4>
            </div>
            <div class="modal-body">
                <label for="">¿Esta seguro que desea quitar este Potrero?</label>
            </div>
            <div class="modal-footer">
                    <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-default" v-on:click="eliminarPotrero()">Si</button>
            </div>
        </div>
    </div>
</div>


