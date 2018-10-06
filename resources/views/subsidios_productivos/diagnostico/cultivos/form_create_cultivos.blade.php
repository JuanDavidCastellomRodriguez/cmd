<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-cultivo"name="modal-agregar-cultivo">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form" data-toggle="validator" v-on:submit.prevent="guardarCultivo()" >
                <div class="modal-header">

                    <h4 class="modal-title">Nuevo Cultivo</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label for="exampleInputName2">Descripcion del Cultivo</label>
                            <textarea  required="required" class="form-control" id="exampleInputName2" v-model="nuevoCultivo.descripcion_cultivo"></textarea>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Nombre del Producto</label>
                            <input type="text" required="required" class="form-control" id="exampleInputName2" v-model="nuevoCultivo.nombre_producto">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Fecha establecimiento del Cultivo</label>
                            <input type="text" id="fecha_establecimiento" required="required" class="form-control" id="exampleInputName2" v-model="nuevoCultivo.fecha_establecimiento_cultivo">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Fecha Renovacion</label>
                            <input type="text" id="fecha_renovacion" required="required" class="form-control" id="exampleInputName2" v-model="nuevoCultivo.fecha_renovacion">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6 ">
                            <label for="exampleInputName2">Unidad del Producto</label>
                            <select required="required" v-model="nuevoCultivo.id_unidad_producto" class="form-control" >
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="unidad in unidadesProducto" :value="unidad.id" >@{{ unidad.descripcion_unidad+ '('+unidad.unidad_producto+')' }}</option>

                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6 ">
                            <label for="exampleInputName2">Sitio de Venta</label>
                            <select required="required" v-model="nuevoCultivo.id_sitio_venta" class="form-control" >
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="sitio in  sitiosVenta" :value="sitio.id" >@{{ sitio.sitio_venta }}</option>

                            </select>
                        </div>
                        <div class="col-lg-12">
                            <h4>Meses de actividades del cultivo</h4>
                            <table class="table table-responsive" style="font-size: 11px">
                                <tr>
                                    <th>Actividad</th>
                                    <th>Enero</th>
                                    <th>Febrero</th>
                                    <th>Marzo</th>
                                    <th>Abril</th>
                                    <th>Mayo</th>
                                    <th>Junio</th>
                                    <th>Julio</th>
                                    <th>Agosto</th>
                                    <th>Septiembre</th>
                                    <th>Octubre</th>
                                    <th>Noviembre</th>
                                    <th>Diciembre</th>
                                </tr>
                                <tr>
                                    <td>Preparación</td>
                                    <td v-for="mes in meses"><input  type="checkbox" v-model="nuevoCultivo.actividades.preparacion" :value="mes.id" name="meses"></td>
                                </tr>
                                <tr>
                                    <td>Siembra</td>
                                    <td v-for="mes in meses"><input  type="checkbox" v-model="nuevoCultivo.actividades.siembra" :value="mes.id" name="meses"></td>
                                </tr>
                                <tr>
                                    <td>Deshierbado</td>
                                    <td v-for="mes in meses"><input  type="checkbox" v-model="nuevoCultivo.actividades.deshierbado" :value="mes.id" name="meses"></td>
                                </tr>
                                <tr>
                                    <td>Abonado</td>
                                    <td v-for="mes in meses"><input  type="checkbox" v-model="nuevoCultivo.actividades.abonado" :value="mes.id" name="meses"></td>
                                </tr>
                                <tr>
                                    <td>Cosecha</td>
                                    <td v-for="mes in meses"><input  type="checkbox" v-model="nuevoCultivo.actividades.cosecha" :value="mes.id" name="meses"></td>
                                </tr>

                            </table>

                        </div>
                        <div class="col-lg-12">
                            <h4>Semillas
                                <button type="button" v-if="!agregandoSemilla"v-on:click="showAgregarSemilla('1')" class="btn btn-sm btn-success">Agregar</button>
                                <button type="button" v-if="agregandoSemilla" v-on:click="showAgregarSemilla('0')" class="btn btn-sm btn-danger">Cancelar</button>
                            </h4>
                            <div class="form" v-if="agregandoSemilla" style="font-size: 12px">
                                <div class="form-group col-lg-2">
                                    <label for="exampleInputName2">Variedad</label>
                                    <input type="text" class="form-control" v-model="nuevaSemilla.variedad" >
                                </div>
                                <div class="form-group col-lg-5">
                                    <label for="exampleInputEmail2">Densidad</label>
                                    <input type="text" class="form-control" v-model="nuevaSemilla.densidad">
                                </div>
                                <div class="form-group col-lg-2">
                                    <label for="exampleInputName2">Procedencia</label>
                                    <input type="text" required class="form-control" id="exampleInputName2" v-model="nuevaSemilla.otra_procedencia">
                                </div>
                                <div class="form-group col-lg-2">
                                    <label for="exampleInputEmail2">Semilla Certificada</label>
                                    <div style="padding-top:10px;">
                                        <input  type="checkbox" v-model="nuevaSemilla.certificado_ica"  >
                                    </div>
                                </div>
                                <div class="form-group" style="text-align: right">

                                    <button type="button" v-on:click="agregarSemilla()" style="margin-top: 24px;" class="btn btn-sm btn-success" >Agregar</button>
                                </div>

                            </div>
                            <table style="font-size: 12px" class="table table-responsive">
                                <tr>
                                    <th>Variedad</th>
                                    <th>Densidad</th>
                                    <th>Procedencia</th>
                                    <th>Certificada</th>
                                    <th>Eliminar</th>
                                </tr>
                                <tr v-for="semilla in nuevoCultivo.semillas">
                                    <td><input class="edit" type="text" v-model="semilla.variedad" ></td>
                                    <td><input class="edit" type="text" v-model="semilla.densidad" ></td>
                                    <td><input class="edit" type="text" v-model="semilla.otra_procedencia" ></td>
                                    <td><input class="edit" type="checkbox" v-model="semilla.certificado_ica" :value="semilla.certificado_ica"></td>
                                    <td>
                                        <span  class="glyphicon glyphicon-remove btn-dlt" v-on:click="borrarSemilla(semilla)" title="Eliminar" aria-hidden="true"></span>
                                    </td>                     
                                </tr>

                            </table>
                        </div>





                    </div>
                </div>
                <div class="modal-footer">
                    <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                    <button type="button" class="btn btn-default" data-dismiss="modal"  v-on:click="formReset()" >Cancelar</button>
                    <button type="submit"  class="btn btn-default " data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando..."   id="btn-guardar">Guardar</button>

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal-confirm-delete-cultivo" tabindex="-1" role="dialog" aria-labelledby="modal-confirm-delete-cultivo">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Confirme</h4>
            </div>
            <div class="modal-body">
                <label for="">¿Esta seguro que desea quitar este Cultivo?</label>
            </div>
            <div class="modal-footer">
                    <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-default" v-on:click="eliminarCultivo()">Si</button>
            </div>
        </div>
    </div>
</div>

<detalle-cultivo :idcultivo="cultivoToDetalle.id"></detalle-cultivo>

