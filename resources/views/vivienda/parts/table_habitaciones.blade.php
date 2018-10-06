<template id="table-habitaciones">

    <div>
        <h3>Habitaciones</h3>
        <div class="col-lg-12 col-sm-6">
            <p v-if="bandera == 1"><strong>Nota.</strong>La informacion de esta habitacion fue tomada del <strong>Levantamiento de informacion Beneficio No @{{ infoVivienda.consecutivo }}</strong> del beneficiario <strong>@{{ nombre }} CC. @{{ documento }}.</strong>Por favor verifica su validez para este nueva habitacion, y si es correcta Guarda, sino crea una nueva Habitacion.</p>
        </div>
        <button v-if="bandera == 1" type="button" class="btn btn-default" @click="resetHabitacion()" style="margin-left: 86%;">
            Nuevo Habitacion
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
        <form class="form" v-on:submit.prevent="guardarHabitacion()" >
            <div class="modal-body">
                <div class="row">

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

                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaHabitacion.otra_estructura">
                                    Otra
                                </label>
                            </div>

                        </div>

                        <div class="form-group col-lg-4 col-sm-12 col-md-6" v-if="nuevaHabitacion.otra_estructura">
                                <label for="exampleInputName2">¿Cual?</label>
                                <input type="text" class="form-control" id="exampleInputName2" v-model="nuevaHabitacion.descripcion_otra_estructura">
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
                        <div class="form-group col-lg-4 col-sm-12 col-md-6" v-if="nuevaHabitacion.id_tipo_muro == 10">
                                <label for="exampleInputName2">¿Cual?</label>
                                <input type="text" class="form-control" id="exampleInputName2" v-model="nuevaHabitacion.descripcion_otro_muro">
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
                        <div class="form-group col-lg-4 col-sm-12 col-md-6" v-if="nuevaHabitacion.id_tipo_cubierta == 7">
                            <label for="exampleInputName2">¿Cual?</label>
                            <input type="text" class="form-control" id="exampleInputName2" v-model="nuevaHabitacion.descripcion_otra_cubierta">
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
                        <div class="form-group col-lg-4 col-sm-12 col-md-6" v-if="nuevaHabitacion.id_tipo_piso == 5">
                            <label for="exampleInputName2">¿Cual?</label>
                            <input type="text" class="form-control" id="exampleInputName2" v-model="nuevaHabitacion.descripcion_otro_piso">
                        </div>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label>
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
                                    ¿Ventanas externas?
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-left: 0;" v-if="nuevaHabitacion.ventanas">
                            <div class="form-group col-lg-4 col-sm-12 col-md-4">
                                <label for="exampleInputName2">Material Ventana externas</label>
                                <select required="required" v-model="nuevaHabitacion.id_material_ventanas" class="form-control">
                                    <option value="" disabled>Seleccione...</option>
                                    <option v-for="ventana in materialventanas" :value="ventana.id">@{{ ventana.material_ventanas }}</option>
                                </select>
                                <div class="form-group col-lg-12 col-sm-12 col-md-4" v-if="nuevaHabitacion.id_material_ventanas == 7">
                                    <label for="exampleInputName2">¿Cual?</label>
                                    <input type="text" class="form-control" id="exampleInputName2" v-model="nuevaHabitacion.descripcion_otra_ventana">
                                </div>
                            </div>
                            <div class="form-group col-lg-4 col-sm-12 col-md-4" v-if="nuevaHabitacion.ventanas">
                                <label for="exampleInputName2">Numero de Ventanas externas</label>
                                <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevaHabitacion.cantidad_ventanas">
                            </div>
                            <div class="form-group col-lg-4 col-sm-12 col-md-4">
                                <div class="checkbox" style="top: 20px;">
                                    <label>
                                        <input type="checkbox"  class="" v-model="nuevaHabitacion.ventana_externa_deteriorado">
                                        ¿Deteriorado?
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaHabitacion.ventanas_internas">
                                    ¿Ventanas internas?
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-left: 0;" v-if="nuevaHabitacion.ventanas_internas">
                            <div class="form-group col-lg-4 col-sm-12 col-md-4">
                                <label for="exampleInputName2">Material Ventana internas</label>
                                <select required="required" v-model="nuevaHabitacion.id_material_ventanas_internas" class="form-control">
                                    <option value="" disabled>Seleccione...</option>
                                    <option v-for="ventana in materialventanas" :value="ventana.id">@{{ ventana.material_ventanas }}</option>
                                </select>
                                <div class="form-group col-lg-12 col-sm-12 col-md-6" v-if="nuevaHabitacion.id_material_ventanas_internas == 7">
                                    <label for="exampleInputName2">¿Cual?</label>
                                    <input type="text" class="form-control" id="exampleInputName2" v-model="nuevaHabitacion.descripcion_otra_ventana_interna">
                                </div>
                            </div>
                            <div class="form-group col-lg-4 col-sm-12 col-md-4" v-if="nuevaHabitacion.ventanas_internas">
                                <label for="exampleInputName2">Numero de Ventanas internas</label>
                                <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevaHabitacion.cantidad_ventanas_internas">
                            </div>
                            <div class="form-group col-lg-4 col-sm-12 col-md-4">
                                <div class="checkbox" style="top: 20px;">
                                    <label>
                                        <input type="checkbox"  class="" v-model="nuevaHabitacion.ventana_interna_deteriorado">
                                        ¿Deteriorado?
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaHabitacion.puertas">
                                    ¿Puertas externas?
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-left: 0;" v-if="nuevaHabitacion.puertas">
                            <div class="form-group col-lg-4 col-sm-12 col-md-4">
                                <label for="exampleInputName2">Material Puertas externas</label>
                                <select required="required" v-model="nuevaHabitacion.id_material_puertas" class="form-control">
                                    <option value="" disabled>Seleccione...</option>
                                    <option v-for="puerta in materialpuertas" :value="puerta.id" >@{{ puerta.material_puertas }}</option>
                                </select>
                                <div class="form-group col-lg-12 col-sm-12 col-md-6" v-if="nuevaHabitacion.id_material_puertas == 7">
                                    <label for="exampleInputName2">¿Cual?</label>
                                    <input type="text" class="form-control" id="exampleInputName2" v-model="nuevaHabitacion.descripcion_otra_puerta">
                                </div>
                            </div>
                            <div class="form-group col-lg-4 col-sm-12 col-md-4" v-if="nuevaHabitacion.puertas">
                                <label for="exampleInputName2">Numero de Puertas externas</label>
                                <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevaHabitacion.cantidad_puertas">
                            </div>
                            <div class="form-group col-lg-4 col-sm-12 col-md-4">
                                <div class="checkbox" style="top: 20px;">
                                    <label>
                                        <input type="checkbox"  class="" v-model="nuevaHabitacion.puerta_externa_deteriorado">
                                        ¿Deteriorado?
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaHabitacion.puertas_internas">
                                    ¿Puertas internas?
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-left: 0;" v-if="nuevaHabitacion.puertas_internas">
                            <div class="form-group col-lg-4 col-sm-12 col-md-4">
                                <label for="exampleInputName2">Material Puertas internas</label>
                                <select required="required" v-model="nuevaHabitacion.id_material_puertas_internas" class="form-control">
                                    <option value="" disabled>Seleccione...</option>
                                    <option v-for="puerta in materialpuertas" :value="puerta.id" >@{{ puerta.material_puertas }}</option>
                                </select>
                                <div class="form-group col-lg-12 col-sm-12 col-md-6" v-if="nuevaHabitacion.id_material_puertas_internas == 7">
                                    <label for="exampleInputName2">¿Cual?</label>
                                    <input type="text" class="form-control" id="exampleInputName2" v-model="nuevaHabitacion.descripcion_otra_puerta_interna">
                                </div>
                            </div>
                            <div class="form-group col-lg-4 col-sm-12 col-md-4" v-if="nuevaHabitacion.puertas_internas">
                                <label for="exampleInputName2">Numero de Puertas internas</label>
                                <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevaHabitacion.cantidad_puertas_internas">
                            </div>
                            <div class="form-group col-lg-4 col-sm-12 col-md-4">
                                <div class="checkbox" style="top: 20px;">
                                    <label>
                                        <input type="checkbox"  class="" v-model="nuevaHabitacion.puerta_interna_deteriorado">
                                        ¿Deteriorado?
                                    </label>
                                </div>
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

    </div>
</template>
