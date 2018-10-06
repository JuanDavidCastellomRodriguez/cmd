<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-vereda" name="modal-agregar-vereda">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form" v-on:submit.prevent="guardarVereda()" >
                <div class="modal-header">
                    <h4 class="modal-title">Nueva Vereda</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 modal-header" style="margin: 15px 0 0 0; padding: 0;">
                            <div class=" form-group col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Municipio</label>
                                <select class="form-control" v-model="nuevaVereda.municipio_id" required>
                                    <option value="" disabled >Seleccione...</option>
                                    <option v-for="municipio in municipios" :value="municipio.id">@{{ municipio.municipio  }}</option>
                                </select>
                                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                            </div>
                            <div class=" form-group col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Campo</label>
                                <select class="form-control" v-model="nuevaVereda.campo_id" required>
                                    <option value="" disabled  >Seleccione...</option>
                                    <option v-for="campo in campos" :value="campo.id">@{{ campo.nombre_campo  }}</option>
                                </select>
                                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                            </div>
                            <div class=" form-group col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Nombre de la Vereda</label>
                                <input type="text" name="vereda" id="vereda" class="form-control" required v-model="nuevaVereda.vereda">
                            </div>                                
                        </div>
                    </div>
                </div>            
                <div class="modal-footer">
                    <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="formReset()" >Cancelar</button>
                    <button type="submit"  class="btn btn-default "  id="btn-guardar">Guardar</button>
                </div>
            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>