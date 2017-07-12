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
                            <textarea  required class="form-control" id="exampleInputName2" v-model="nuevoCultivo.descripcion_cultivo"></textarea>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Nombre del Producto</label>
                            <input type="text" required class="form-control" id="exampleInputName2" v-model="nuevoCultivo.nombre_producto">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Fecha establecimiento del Cultivo</label>
                            <input type="text" id="fecha_establecimiento" required class="form-control" id="exampleInputName2" v-model="nuevoCultivo.fecha_establecimiento_cultivo">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Fecha Renovacion</label>
                            <input type="text" id="fecha_renovacion" required class="form-control" id="exampleInputName2" v-model="nuevoCultivo.fecha_renovacion">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6 ">
                            <label for="exampleInputName2">Unidad del Producto</label>
                            <select v-model="nuevoCultivo.id_unidad_producto" class="form-control" >
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="unidad in unidadesProducto" :value="unidad.id" >@{{ unidad.descripcion_unidad+ '('+unidad.unidad_producto+')' }}</option>

                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6 ">
                            <label for="exampleInputName2">Sitio de Venta</label>
                            <select v-model="nuevoCultivo.id_sitio_venta" class="form-control" >
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

<div class="modal fade" tabindex="-1" role="dialog" id="modal-detalle-cultivo"name="modal-detalle-cultivo">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form" data-toggle="validator" v-on:submit.prevent="guardarDetalle()" >
                <div class="modal-header">

                    <h4 class="modal-title">Nuevo Cultivo</h4>
                </div>
                <div class="modal-body">
                    <div class="row">





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


