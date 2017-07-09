<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-fase"name="modal-agregar-fase">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form" v-on:submit.prevent="guardarFase()" >
                <div class="modal-header">

                    <h4 class="modal-title">Nueva Fase</h4>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-lg-12 modal-header" style="margin: 15px 0 0 0; padding: 0;">
                            <div class=" form-group col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Fecha Fase</label>
                                <input type="text" name="fecha_fase" id="fecha_fase" class="form-control" required v-model="nuevaFase.fecha_fase">
                            </div>

                            <div class="form-group has-feedback col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Orden de Servicio</label>
                                <select class="form-control" v-model="nuevaFase.id_orden_servicio" required>
                                    <option value="" disabled  >Seleccione...</option>
                                    <option v-for="orden in ordenes" :value="orden.id">@{{ orden.consecutivo  }}</option>
                                </select>
                                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                            </div>

                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Nombre Fase</label>
                                <input type="text" required class="form-control" id="exampleInputName2" v-model="nuevaFase.nombre_fase">
                            </div>

                            <div class="form-group has-feedback col-lg-12 col-sm-12">
                                <label for="exampleInputName2">Observaciones</label>
                                <textarea v-model="nuevaFase.observaciones" class="form-control"></textarea>
                                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                            </div>
                            <div class="form-group has-feedback col-lg-6 col-sm-12" v-if="editarFase">
                                <label for="exampleInputName2">Estado</label>
                                <select class="form-control" v-model="nuevaFase.estado">
                                    <option value="">Seleccione...</option>
                                    <option value="0">Inactiva</option>
                                    <option value="1">Activa</option>

                                </select>
                                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                            </div>
                        </div>

                        <div class="col-lg-12 " style="padding: 0">

                            <h4 class="col-lg-12" style="margin-top:20px;">Agregar Veredas</h4>

                            <div class="form-group has-feedback col-lg-4 col-sm-5">
                                <label for="exampleInputName2">Municipio</label>
                                <select class="form-control"  v-on:change="getVeredas($event.target.value)" required>
                                    <option value="" disabled selected  >Seleccione...</option>
                                    <option v-for="municipio in municipios" :value="municipio.id">@{{ municipio.municipio  }}</option>
                                </select>
                                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>

                            </div>
                            <div class="form-group has-feedback col-lg-4 col-sm-5">
                                <label for="exampleInputName2">Vereda</label>
                                <input type="text" id="autocomplete"  class="form-control typeaheads">
                                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                            </div>
                            <div class="form-group has-feedback col-lg-2 col-sm-2">
                                <label for="exampleInputName2"></label>
                                <a  class="btn btn-sm btn-default" title="Ver" style="margin-top: 30px" v-on:click="agregarVereda()" >Agregar</a>
                                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                            </div>



                            <table class="table table-responsive">
                                <tr>
                                    <th>Vereda</th>
                                    <th class="col-lg-2 col-sm-3">Opciones</th>
                                </tr>
                                <tr v-for="vereda in nuevaFase.veredas_fase">
                                    <td>@{{ vereda.vereda }}</td>
                                    <td><a  class="btn btn-sm btn-default" title="Ver" v-on:click="eliminarVereda(vereda)" >Eliminar</a></td>
                                </tr>
                            </table>
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


