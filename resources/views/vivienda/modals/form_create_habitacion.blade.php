<div id="modales">
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-habitacion"name="modal-agregar-habitacion">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form class="form" v-on:submit.prevent="guardarHabitacion()" >
                    <div class="modal-header">
                        <h4 class="modal-title">Nueva Habitacion</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-lg-12 col-sm-12 col-md-12">
                                <label for="exampleInputName2">Nombre Habitacion</label>
                                <input type="text" required class="form-control" id="exampleInputName2" v-model="nuevaHabitacion.nombre">
                            </div>
                            <div class="col-lg-12 modal-header" style="padding-top: 0; padding-bottom: 0">

                                <h4>Estructura</h4>
                                <div class="form-group col-lg-2 col-sm-4 col-md-3">
                                    <div class="checkbox">
                                        <label >
                                            <input type="checkbox"  class="" v-model="nuevaHabitacion.estructura_viga">
                                            Vigas
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-lg-2 col-sm-4 col-md-3">
                                    <div class="checkbox">
                                        <label >
                                            <input type="checkbox"  class="" v-model="nuevaHabitacion.estructura_columna">
                                            Columnas
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-12 modal-header" style="padding-top: 0; padding-bottom: 0">
                                <h4>Muros</h4>
                                <div class="col-lg-12" style="padding-left: 0; ">
                                    <div class="form-group col-lg-4 col-sm-12 col-md-6">
                                        <label for="exampleInputName2">Material</label>
                                        <select required="required" v-model="nuevaHabitacion.id_tipo_muro" class="form-control">
                                            <option value="" disabled>Seleccione...</option>
                                            <option v-for="muro in tipomuro" :value="muro.id" >@{{ muro.tipo_muro }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-4 col-md-3">
                                    <div class="checkbox">
                                        <label >
                                            <input type="checkbox"  class="" v-model="nuevaHabitacion.panete_interno">
                                            Pañete Interno
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-lg-2 col-sm-4 col-md-3">
                                    <div class="checkbox">
                                        <label >
                                            <input type="checkbox"  class="" v-model="nuevaHabitacion.panete_externo">
                                            Pañete Externo
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-lg-2 col-sm-4 col-md-3">
                                    <div class="checkbox">
                                        <label >
                                            <input type="checkbox"  class="" v-model="nuevaHabitacion.estuco">
                                            Estuco
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-lg-2 col-sm-4 col-md-3">
                                    <div class="checkbox">
                                        <label >
                                            <input type="checkbox"  class="" v-model="nuevaHabitacion.pintura">
                                            Pintura
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 modal-header" style="padding-top: 0; padding-bottom: 0">
                                <h4>Cubierta</h4>
                                <div class="col-lg-12" style="padding-left: 0; ">
                                    <div class="form-group col-lg-4 col-sm-12 col-md-6">
                                        <label for="exampleInputName2">Material</label>
                                        <select required="required" v-model="nuevaHabitacion.id_tipo_cubierta" class="form-control">
                                            <option value="" disabled>Seleccione...</option>
                                            <option v-for="cubierta in tipocubierta" :value="cubierta.id" >@{{ cubierta.tipo_cubierta }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 modal-header">
                                <h4>Pisos</h4>
                                <div class="col-lg-12" style="padding-left: 0; ">
                                    <div class="form-group col-lg-4 col-sm-12 col-md-6">
                                        <label for="exampleInputName2">Material</label>
                                        <select required="required" v-model="nuevaHabitacion.id_tipo_piso" class="form-control">
                                            <option value="" disabled>Seleccione...</option>
                                            <option v-for="piso in tipopiso" :value="piso.id" >@{{ piso.tipo_piso }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-lg-2 col-sm-4 col-md-3">
                                    <div class="checkbox">
                                        <label >
                                            <input type="checkbox"  class="" v-model="nuevaHabitacion.piso_deteriorado">
                                            ¿Deteriorado?
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <h4>General</h4>
                                <div class="form-group col-lg-2 col-sm-4 col-md-3">
                                    <div class="checkbox">
                                        <label >
                                            <input type="checkbox"  class="" v-model="nuevaHabitacion.ventanas">
                                            ¿Ventanas?
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-12" style="padding-left: 0;" v-if="nuevaHabitacion.ventanas">
                                    <div class="form-group col-lg-4 col-sm-12 col-md-6">
                                        <label for="exampleInputName2">Material Ventana</label>
                                        <select required="required" v-model="nuevaHabitacion.id_material_ventanas" class="form-control">
                                            <option value="" disabled>Seleccione...</option>
                                            <option v-for="ventana in materialventanas" :value="ventana.id">@{{ ventana.material_ventanas }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4 col-sm-12 col-md-6" v-if="nuevaHabitacion.ventanas">
                                        <label for="exampleInputName2">Numero de Ventanas</label>
                                        <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevaHabitacion.cantidad_ventanas">
                                    </div>
                                </div>
                                <div class="form-group col-lg-2 col-sm-4 col-md-3">
                                    <div class="checkbox">
                                        <label >
                                            <input type="checkbox"  class="" v-model="nuevaHabitacion.puertas">
                                            ¿Puertas?
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-12" style="padding-left: 0;" v-if="nuevaHabitacion.puertas">
                                    <div class="form-group col-lg-4 col-sm-12 col-md-6">
                                        <label for="exampleInputName2">Material Puertas</label>
                                        <select required="required" v-model="nuevaHabitacion.id_material_puertas" class="form-control">
                                            <option value="" disabled>Seleccione...</option>
                                            <option v-for="puerta in materialpuertas" :value="puerta.id" >@{{ puerta.material_puertas }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4 col-sm-12 col-md-6" v-if="nuevaHabitacion.puertas">
                                        <label for="exampleInputName2">Numero de Puertas</label>
                                        <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevaHabitacion.cantidad_puertas">
                                    </div>
                                </div>
                                <div class="col-lg-12" style="padding-left: 0; ">
                                    <div class="form-group col-lg-4 col-sm-12 col-md-6">
                                        <label for="exampleInputName2">Estado General de la Habitación</label>
                                        <select required="required" v-model="nuevaHabitacion.id_estado_vivienda" class="form-control">
                                            <option value="" disabled>Seleccione...</option>
                                            <option v-for="estado in estadovivienda" :value="estado.id" >@{{ estado.estado_vivienda }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-lg-12">
                                    <label for="exampleInputName2">Observaciones</label>
                                    <textarea required class="form-control" id="exampleInputName2" v-model="nuevaHabitacion.observaciones"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" @click="formReset()" >Cancelar</button>
                        <button type="submit"  class="btn btn-default " data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando..."   id="btn-guardar">Guardar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="modal-confirm-delete-habitacion" tabindex="-1" role="dialog" aria-labelledby="modal-confirm-delete-habitacion">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Confirme</h4>
                </div>
                <div class="modal-body">
                    <label for="">¿Esta seguro que desea la habitación?</label>
                </div>
                <div class="modal-footer">
                    <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-default" v-on:click="eliminarHabitacion()">Si</button>
                </div>
            </div>
        </div>
    </div>

</div>




