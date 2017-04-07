<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-subsidio"name="modal-agregar-subsidio">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form" v-on:submit.prevent="guardarFase()" >
                <div class="modal-header">

                    <h4 class="modal-title">Nueva Fase</h4>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-12" style="margin: 15px 0 0 0; padding: 0;">
                            <div class=" form-group col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Fecha Fase</label>
                                <input type="text" name="fecha_subsidio" id="fecha_subsidio" class="form-control" required v-model="nuevaFase.fecha_fase">
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Nombre Fase</label>
                                <input type="text" required class="form-control" id="exampleInputName2" v-model="nuevaFase.nombre_fase">
                            </div>

                            <div class="form-group has-feedback col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Orden de Servicio</label>
                                <select class="form-control" v-model="nuevaFase.id_orden_servicio" required>
                                    <option value="" disabled  >Seleccione...</option>
                                    <option v-for="fase in fases" :value="fase.id">@{{ fase.nombre_fase  }}</option>
                                </select>
                                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                            </div>
                            <div class="form-group has-feedback col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Municipio</label>
                                <select class="form-control"  required>
                                    <option value="" disabled  >Seleccione...</option>
                                    <option v-for="fase in fases" :value="fase.id">@{{ fase.nombre_fase  }}</option>
                                </select>
                                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                            </div>
                            <div class="form-group has-feedback col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Vereda</label>
                                <select class="form-control" v-model="nuevaFase.id_vereda" required>
                                    <option value="" disabled  >Seleccione...</option>
                                    <option v-for="fase in fases" :value="fase.id">@{{ fase.nombre_fase  }}</option>
                                </select>
                                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                            </div>

                            <div class="form-group has-feedback col-lg-12 col-sm-12">
                                <label for="exampleInputName2">Observaciones</label>
                                <textarea v-model="nuevaFase.observaciones" class="form-control"></textarea>
                                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                            </div>
                        </div>




                    </div>
                </div>
                <div class="modal-footer">
                    <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="resetForm()" >Cancelar</button>
                    <button type="submit"  class="btn btn-default "  id="btn-guardar">Crear Fase</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


