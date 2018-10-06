<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-ordenio-bovino"name="modal-agregar-ordenio-bovino">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form" data-toggle="validator" v-on:submit.prevent="guardarOrdenioBovino()" >
                <div class="modal-header">

                    <h4 class="modal-title">Nuevo Ordeño</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-4 col-sm-12 col-md-6 ">
                            <label for="exampleInputName2">Unidad de Medida</label>
                            <select required="required" v-model="nuevoOrdenio.id_unidades_ordenio" class="form-control" >
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="unidad in unidadesOrdenios" :value="unidad.id" >@{{ unidad.unidades_ordenio }}</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6 ">
                            <label for="exampleInputName2">Frecuencia Ordeño</label>
                            <select required="required" v-model="nuevoOrdenio.id_frecuencia_ordenio" class="form-control" >
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="frecuencia in frecuenciasOrdenios" :value="frecuencia.id" >@{{ frecuencia.frecuencia }}</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Produccion Diaria</label>
                            <input type="number" required="required" class="form-control" id="exampleInputName2" v-model="nuevoOrdenio.produccion_dia">
                        </div>

                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Cantidad Autoconsumo</label>
                            <input type="number" required="required" class="form-control" id="exampleInputName2" v-model="nuevoOrdenio.cantidad_autoconsumo">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Cantidad Cuaja</label>
                            <input type="number" required="required" class="form-control" id="exampleInputName2" v-model="nuevoOrdenio.cantidad_cuaja">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Cantidad Venta</label>
                            <input type="number" required="required" class="form-control" id="exampleInputName2" v-model="nuevoOrdenio.cantidad_venta">
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

<div class="modal fade" id="modal-confirm-delete-ordenio-bovino" tabindex="-1" role="dialog" aria-labelledby="modal-confirm-delete-ordenio-bovino">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Confirme</h4>
            </div>
            <div class="modal-body">
                <label for="">¿Esta seguro que desea quitar este registro de ordeño?</label>
            </div>
            <div class="modal-footer">
                    <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-default" v-on:click="eliminarOrdenioBovino()">Si</button>
            </div>
        </div>
    </div>
</div>



