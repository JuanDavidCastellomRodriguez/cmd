<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-orden"name="modal-agregar-orden">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form" v-on:submit.prevent="guardarOrden()" >
                <div class="modal-header">

                    <h4 class="modal-title">Nueva Orden de Servicios</h4>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-12" style="margin: 15px 0 0 0; padding: 0;">
                            <div class=" form-group col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Fecha Inicio</label>
                                <input type="text" name="fecha_inicio" id="fecha_inicio" class="form-control" required v-model="nuevaOrden.fecha_inicio">
                            </div><div class=" form-group col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Fecha Fin</label>
                                <input type="text" name="fecha_fin" id="fecha_fin" class="form-control" required v-model="nuevaOrden.fecha_final">
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Codigo/Numero</label>
                                <input type="text" required class="form-control" id="exampleInputName2" v-model="nuevaOrden.consecutivo">
                            </div>

                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Presupuesto</label>
                                <input type="text" required class="form-control" id="presupuesto" v-model="nuevaOrden.presupuesto">
                            </div>

                            <div class="form-group has-feedback col-lg-12 col-sm-12">
                                <label for="exampleInputName2">Objeto</label>
                                <textarea v-model="nuevaOrden.objeto" class="form-control"></textarea>
                                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                            </div>

                            <div class="form-group has-feedback col-lg-12 col-sm-12">
                                <label for="exampleInputName2">Observaciones</label>
                                <textarea v-model="nuevaOrden.observaciones" class="form-control"></textarea>
                                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                            </div>
                            <div class="form-group has-feedback col-lg-6 col-sm-12" v-if="editarOrden">
                                <label for="exampleInputName2">Estado</label>
                                <select class="form-control" v-model="nuevaOrden.estado">
                                    <option value="">Seleccione...</option>
                                    <option value="0">Inactiva</option>
                                    <option value="1">Activa</option>

                                </select>
                                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
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
</div><!-- /.modal -->


