<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-visita"name="modal-agregar-visita">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form" v-on:submit.prevent="guardarVisita()" >
                <div class="modal-header">

                    <h4 class="modal-title">Nueva Visita</h4>

                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class=" form-group col-lg-6 col-sm-12">
                            <label for="exampleInputName2">Fecha Visita</label>
                            <input type="text"  id="fecha_visita" class="form-control" required v-model="nuevaVisita.fecha">
                        </div>
                        <div class="form-group has-feedback col-lg-6 col-sm-12">
                            <label for="exampleInputName2">Tipo de Visita</label>
                            <select class="form-control" v-model="nuevaVisita.id_tipo_visita" required>
                                <option value="" disabled  >Seleccione...</option>

                            </select>
                            <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                        </div>

                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="exampleInputName2">Observaciones</label>
                            <textarea  required class="form-control"  v-model.number="nuevaVisita.observaciones"></textarea>
                        </div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="resetForm()" >Cancelar</button>
                    <button type="submit"  class="btn btn-default " data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando..."   id="btn-guardar">Guardar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


