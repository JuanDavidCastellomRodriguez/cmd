<template id="table-unidades-sanitarias">
    <div>
        <h3>Unidades Sanitarias</h3>
        <div class="col-lg-12 col-sm-6">
            <p v-if="bandera == 1"><strong>Nota.</strong>La informacion de esta unidad sanitaria fue tomada del <strong>Levantamiento de informacion Beneficio No @{{ infoVivienda.consecutivo }}</strong> del beneficiario <strong>@{{ nombre }} CC. @{{ documento }}.</strong>Por favor verifica su validez para este nueva cocina, y si es correcta Guarda, sino crea una nueva Cocina.</p>
        </div>
        <button v-if="bandera == 1" type="button" class="btn btn-default" @click="resetUnidad()" style="margin-left: 86%;">
            Nueva Cocina
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
        <form class="form" v-on:submit.prevent="guardarUnidadSanitaria()"  >
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 modal-header" style="padding-top: 0; padding-bottom: 0">
                        <h4>Estructura</h4>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaUnidadSanitaria.estructura_viga">
                                    Vigas
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaUnidadSanitaria.estructura_columna">
                                    Columnas
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaUnidadSanitaria.otra_estructura">
                                    Otra
                                </label>
                            </div>

                        </div>

                        <div class="form-group col-lg-4 col-sm-12 col-md-6" v-if="nuevaUnidadSanitaria.otra_estructura">
                            <label for="descripcion_otra_estructura">Otra estructura ¿Cuál?</label>
                            <input type="text" class="form-control" id="descripcion_otra_estructura" v-model="nuevaUnidadSanitaria.descripcion_estructura">
                        </div>
                        
                    </div>
                    <div class="col-lg-12 modal-header" style="padding-top: 0; padding-bottom: 0">
                        <h4>Muros</h4>
                        <div class="col-lg-12" style="padding-left: 0; ">
                            <div class="form-group col-lg-6 col-sm-12 col-md-6">
                                <label for="id_tipo_muro">Material</label>
                                <select required="required" v-model="nuevaUnidadSanitaria.id_tipo_muro" class="form-control">
                                    <option value="" disabled>Seleccione...</option>
                                    <option v-for="muro in tipomuro" :value="muro.id" >@{{ muro.tipo_muro }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-lg-4 col-sm-12 col-md-6" v-if="nuevaUnidadSanitaria.id_tipo_muro == 10">
                            <label for="descripcion_otro_muro">¿Cual?</label>
                            <input type="text" class="form-control" id="descripcion_otro_muro" v-model="nuevaUnidadSanitaria.descripcion_muro">
                        </div>
                        
                        <div class="col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaUnidadSanitaria.panete_interno">
                                    Pañete Interno
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaUnidadSanitaria.panete_externo">
                                    Pañete Externo
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaUnidadSanitaria.estuco">
                                    Estuco
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaUnidadSanitaria.pintura">
                                    Pintura
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaUnidadSanitaria.muros_enchapado">
                                    Enchapado
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 modal-header" style="padding-top: 0; padding-bottom: 0">
                        <h4>Cubierta</h4>
                        <div class="col-lg-12" style="padding-left: 0; ">
                            <div class="form-group col-lg-6 col-sm-12 col-md-6">
                                <label for="exampleInputName2">Material</label>
                                <select required="required" v-model="nuevaUnidadSanitaria.id_tipo_cubierta" class="form-control">
                                    <option value="" disabled>Seleccione...</option>
                                    <option v-for="cubierta in tipocubierta" :value="cubierta.id" >@{{ cubierta.tipo_cubierta }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6" v-if="nuevaUnidadSanitaria.id_tipo_cubierta == 7">
                            <label for="exampleInputName2">¿Cual?</label>
                            <input type="text" class="form-control" id="exampleInputName2" v-model="nuevaUnidadSanitaria.descripcion_cubierta">
                        </div>
                    </div>
                    <div class="col-lg-12 modal-header">
                        <h4>Pisos</h4>
                        <div class="col-lg-12" style="padding-left: 0; ">
                            <div class="form-group col-lg-6 col-sm-12 col-md-6">
                                <label for="exampleInputName2">Material</label>
                                <select required="required" v-model="nuevaUnidadSanitaria.id_tipo_piso" class="form-control">
                                    <option value="" disabled>Seleccione...</option>
                                    <option v-for="piso in tipopiso" :value="piso.id" >@{{ piso.tipo_piso }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6" v-if="nuevaUnidadSanitaria.id_tipo_piso == 5">
                            <label for="exampleInputName2">¿Cual?</label>
                            <input type="text" class="form-control" id="exampleInputName2" v-model="nuevaUnidadSanitaria.descripcion_piso">
                        </div>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaUnidadSanitaria.piso_deteriorado">
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
                                    <input type="checkbox"  class="" v-model="nuevaUnidadSanitaria.ventanas">
                                    ¿Ventanas?
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-left: 0;" v-if="nuevaUnidadSanitaria.ventanas">
                            <div class="form-group col-lg-4 col-sm-12 col-md-4">
                                <label for="exampleInputName2">Material Ventana</label>
                                <select required="required" v-model="nuevaUnidadSanitaria.id_material_ventanas" class="form-control">
                                    <option value="" disabled>Seleccione...</option>
                                    <option v-for="ventana in materialventanas" :value="ventana.id">@{{ ventana.material_ventanas }}</option>
                                </select>
                                <div class="form-group col-lg-12 col-sm-12 col-md-6" v-if="nuevaUnidadSanitaria.id_material_ventanas == 7">
                                    <label for="exampleInputName2">¿Cual?</label>
                                    <input type="text" class="form-control" id="exampleInputName2" v-model="nuevaUnidadSanitaria.descripcion_ventana">
                                </div>
                            </div>
                            <div class="form-group col-lg-4 col-sm-12 col-md-4" v-if="nuevaUnidadSanitaria.ventanas">
                                <label for="exampleInputName2">Numero de Ventanas</label>
                                <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevaUnidadSanitaria.cantidad_ventanas">
                            </div>
                            <div class="form-group col-lg-4 col-sm-12 col-md-4">
                                <div class="checkbox">
                                    <label >
                                        <input type="checkbox"  class="" v-model="nuevaUnidadSanitaria.ventana_deteriorado">
                                        ¿Deteriorado?
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaUnidadSanitaria.puertas">
                                    ¿Puertas?
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-left: 0;" v-if="nuevaUnidadSanitaria.puertas">
                            <div class="form-group col-lg-4 col-sm-12 col-md-4">
                                <label for="exampleInputName2">Material Puertas</label>
                                <select required="required" v-model="nuevaUnidadSanitaria.id_material_puertas" class="form-control">
                                    <option value="" disabled>Seleccione...</option>
                                    <option v-for="puerta in materialpuertas" :value="puerta.id" >@{{ puerta.material_puertas }}</option>
                                </select>
                                <div class="form-group col-lg-12 col-sm-12 col-md-6" v-if="nuevaUnidadSanitaria.id_material_puertas == 7">
                                    <label for="exampleInputName2">¿Cual?</label>
                                    <input type="text" class="form-control" id="exampleInputName2" v-model="nuevaUnidadSanitaria.descripcion_puerta">
                                </div>
                            </div>
                            <div class="form-group col-lg-4 col-sm-12 col-md-4" v-if="nuevaUnidadSanitaria.puertas">
                                <label for="exampleInputName2">Numero de Puertas</label>
                                <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevaUnidadSanitaria.cantidad_puertas">
                            </div>
                            <div class="form-group col-lg-4 col-sm-12 col-md-4">
                                <div class="checkbox">
                                    <label >
                                        <input type="checkbox"  class="" v-model="nuevaUnidadSanitaria.puerta_deteriorado">
                                        ¿Deteriorado?
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-12 modal-header" style="padding-top: 0; padding-bottom: 0">
                        <h4>Especificos</h4>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3" v-for=" elemento in ElementosSanitario">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox" :value="elemento.id"  class="" v-model="nuevaUnidadSanitaria.elementos">
                                    @{{ elemento.elementos_sanitarios }}
                                </label>
                            </div>
                        </div>


                        <div class="form-group col-lg-12">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaUnidadSanitaria.tanque_elevado">
                                    ¿Tanque Elevado?
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-left: 0; " v-if="nuevaUnidadSanitaria.tanque_elevado">
                            <div class="form-group col-lg-6 col-sm-12 col-md-6">
                                <label for="exampleInputName2">Material</label>
                                <select required="required" v-model="nuevaUnidadSanitaria.id_materiales_tanques_elevados" class="form-control">
                                    <option value="" disabled>Seleccione...</option>
                                    <option v-for="material in materialesTanqueElevado" :value="material.id" >@{{ material.material_tanque_elevado }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-lg-12">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaUnidadSanitaria.tanque_lavadero">
                                    ¿Tanque Lavadero?
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-left: 0; " v-if="nuevaUnidadSanitaria.tanque_lavadero">
                            <div class="form-group col-lg-6 col-sm-12 col-md-6">
                                <label for="exampleInputName2">Material</label>
                                <select required="required" v-model="nuevaUnidadSanitaria.id_materiales_tanques_lavaderos" class="form-control">
                                    <option value="" disabled>Seleccione...</option>
                                    <option v-for="material in materialesTanqueLavadero" :value="material.id" >@{{ material.material_tanque_lavadero }}</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12 col-md-6">
                                <label for="exampleInputName2">Acabados</label>
                                <select required="required" v-model="nuevaUnidadSanitaria.id_acabados_tanques_lavaderos" class="form-control">
                                    <option value="" disabled>Seleccione...</option>
                                    <option v-for="material in acabadosTanqueLavadero" :value="material.id" >@{{ material.acabados_tanque }}</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-12" style="padding-left: 0;margin-top: 20px; " >
                        <div class="form-group col-lg-6 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Tipo Unidad</label>
                            <select required="required" v-model="nuevaUnidadSanitaria.id_tipo_unidad_sanitaria" class="form-control">
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="tipo in tipoUnidadesSanitarias" :value="tipo.id" >@{{ tipo.tipo_unidad_sanitaria }}</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-6 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Estado General</label>
                            <select required="required" v-model="nuevaUnidadSanitaria.id_estado_vivienda" class="form-control">
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="estado in estadovivienda" :value="estado.id" >@{{ estado.estado_vivienda }}</option>
                            </select>
                        </div>

                    </div>
                    <div class="form-group col-lg-12" style="margin-top: 10px">
                        <label for="exampleInputName2">Observaciones</label>
                        <textarea required class="form-control" id="exampleInputName2" v-model="nuevaUnidadSanitaria.observaciones"></textarea>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="submit"  class="btn btn-default " data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando..."   id="btn-guardar">Guardar</button>
            </div>
        </form>

    </div>
</template>