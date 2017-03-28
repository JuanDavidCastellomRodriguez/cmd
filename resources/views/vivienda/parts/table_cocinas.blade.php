<template id="table-cocinas">
    <div>
        <h3>Cocina</h3>
        <form class="form" v-on:submit.prevent="guardarCocina()"  >
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 modal-header" style="padding-top: 0; padding-bottom: 0">

                        <h4>Estructura</h4>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaCocina.estructura_viga">
                                    Vigas
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaCocina.estructura_columna">
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
                                <select v-model="nuevaCocina.id_tipo_muro" class="form-control">
                                    <option value="" disabled>Seleccione...</option>
                                    <option v-for="muro in tipomuro" :value="muro.id" >@{{ muro.tipo_muro }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaCocina.panete_interno">
                                    Pañete Interno
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaCocina.panete_externo">
                                    Pañete Externo
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaCocina.estuco">
                                    Estuco
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaCocina.pintura">
                                    Pintura
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaCocina.muros_enchapado">
                                    Enchapado
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 modal-header" style="padding-top: 0; padding-bottom: 0">
                        <h4>Cubierta</h4>
                        <div class="col-lg-12" style="padding-left: 0; ">
                            <div class="form-group col-lg-4 col-sm-12 col-md-6">
                                <label for="exampleInputName2">Material</label>
                                <select v-model="nuevaCocina.id_tipo_cubierta" class="form-control">
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
                                <select v-model="nuevaCocina.id_tipo_piso" class="form-control">
                                    <option value="" disabled>Seleccione...</option>
                                    <option v-for="piso in tipopiso" :value="piso.id" >@{{ piso.tipo_piso }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaCocina.piso_deteriorado">
                                    ¿Deteriorado?
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 modal-header">
                        <h4>General</h4>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaCocina.ventanas">
                                    ¿Ventanas?
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-left: 0;" v-if="nuevaCocina.ventanas">
                            <div class="form-group col-lg-4 col-sm-12 col-md-6">
                                <label for="exampleInputName2">Material Ventana</label>
                                <select v-model="nuevaCocina.id_material_ventanas" class="form-control">
                                    <option value="" disabled>Seleccione...</option>
                                    <option v-for="ventana in materialventanas" :value="ventana.id">@{{ ventana.material_ventanas }}</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-4 col-sm-12 col-md-6" v-if="nuevaCocina.ventanas">
                                <label for="exampleInputName2">Numero de Ventanas</label>
                                <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevaCocina.cantidad_ventanas">
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaCocina.puertas">
                                    ¿Puertas?
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-left: 0;" v-if="nuevaCocina.puertas">
                            <div class="form-group col-lg-4 col-sm-12 col-md-6">
                                <label for="exampleInputName2">Material Puertas</label>
                                <select v-model="nuevaCocina.id_material_puertas" class="form-control">
                                    <option value="" disabled>Seleccione...</option>
                                    <option v-for="puerta in materialpuertas" :value="puerta.id" >@{{ puerta.material_puertas }}</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-4 col-sm-12 col-md-6" v-if="nuevaCocina.puertas">
                                <label for="exampleInputName2">Numero de Puertas</label>
                                <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevaCocina.cantidad_puertas">
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-12 modal-header" style="padding-top: 0; padding-bottom: 0">
                        <h4>Especifico</h4>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaCocina.estufa">
                                    Estufa
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-left: 0; " v-if="nuevaCocina.estufa">
                            <div class="form-group col-lg-4 col-sm-12 col-md-6">
                                <label for="exampleInputName2">Tipo</label>
                                <select v-model="nuevaCocina.id_fuente_energia_cocinas" class="form-control">
                                    <option value="" disabled>Seleccione...</option>
                                    <option v-for="estufas in elementosCocina" :value="estufas.id" >@{{ estufas.elemento_cocina }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaCocina.meson">
                                    Meson
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12" style="padding-left: 0; " v-if="nuevaCocina.meson">
                            <div class="form-group col-lg-4 col-sm-12 col-md-6">
                                <label for="exampleInputName2">Material Meson</label>
                                <select v-model="nuevaCocina.id_tipo_meson" class="form-control">
                                    <option value="" disabled>Seleccione...</option>
                                    <option v-for="meson in tiposMeson" :value="meson.id" >@{{ meson.tipo_meson }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-sm-4 col-md-3">
                            <div class="checkbox">
                                <label >
                                    <input type="checkbox"  class="" v-model="nuevaCocina.lavaplatos">
                                    Lavaplatos
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12" style="padding-left: 0;margin-top: 20px; ">
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Estado General de la Cocina</label>
                            <select v-model="nuevaCocina.id_estado_vivienda" class="form-control">
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="estado in estadovivienda" :value="estado.id" >@{{ estado.estado_vivienda }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-lg-12" style="margin-top: 10px">
                        <label for="exampleInputName2">Observaciones</label>
                        <textarea required class="form-control" id="exampleInputName2" v-model="nuevaCocina.observaciones"></textarea>
                    </div>


                </div>
            </div>
            <div class="col-lg-12">
                <button type="submit"  class="btn btn-default pull-right" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando..."   id="btn-guardar">Guardar</button>
            </div>
        </form>

    </div>
</template>

