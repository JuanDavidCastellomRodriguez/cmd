<template id="especies">
    <div>
        <h3>ESPECIES MENORES</h3>
        <div class="panel-group" id="accordion-especies" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion-especies" href="#tab-aves" aria-expanded="true" aria-controls="collapseOne">
                            AVES
                        </a>
                    </h4>
                </div>
                <div id="tab-aves" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <button style="margin-bottom: 10px" type="button"  class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-agregar-ave-especies" >Agregar</button>
                        <p v-if="banderaA == 1"><strong>Nota.</strong>La informacion de las aves fue tomada del <strong>Levantamiento de informacion Beneficio No @{{ infoProductivo.consecutivo }}</strong> del beneficiario <strong>@{{ nombre }} CC. @{{ documento }}.</strong>Por favor verifica su validez, y si es correcta Guarda, sino agrega nueva informacion.</p>
                        <table style="font-size: 12px" class="table table-responsive">
                            <tr>
                                <th>Tipo</th>
                                <th>Cantidad</th>
                                <th>Produccion</th>
                                <th>Comida(Kg)</th>
                                <th>Tipo Produccion</th>
                                <th>Tipo Corral</th>
                                <th>Estado Corral</th>
                                <th class="col-lg-1">Acciones</th>
                            </tr>
                            <tr v-for="ave in aves">
                                <td>@{{ ave.id_tipo_aves }}</td>
                                <td>@{{ ave.cantidad_polluelos }}</td>
                                <td>@{{ ave.produccion }}</td>
                                <td>@{{ ave.kg_comida }}</td>
                                <td v-if="ave.id_produccion_aves == 1">Gallina ponedora</td>
                                <td v-else-if="ave.id_produccion_aves == 2">Pollo engorde</td>
                                <td>@{{ ave.tipo_corral.tipo_corral }}</td>
                                <td>@{{ ave.estado_instalacion.estado_instalaciones }}</td>
                                <td v-if="banderaA == 0">
                                    <button type="button" class="btn btn-default btn-sm" v-on:click="prepareToDeleteAve(ave)" data-toggle="modal" data-target="#modal-confirm-delete-ave-especies" >Eliminar</button>
                                </td>
                                <td v-if="banderaA == 1">
                                    <button type="button" class="btn btn-default btn-sm" v-on:click="guardarAvesAnterior(ave)" >Guardar</button>
                                    <button type="button" class="btn btn-default btn-sm" v-on:click="borrarTemporalAves(ave)" >Eliminar</button>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-especies" href="#tab-cerdos" aria-expanded="false" aria-controls="collapseTwo">
                            CERDOS
                        </a>
                    </h4>
                </div>
                <div id="tab-cerdos" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        <button style="margin-bottom: 10px" type="button"  class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-agregar-cerdo-especies" >Agregar</button>
                        <p v-if="banderaC == 1"><strong>Nota.</strong>La informacion de las aves fue tomada del <strong>Levantamiento de informacion Beneficio No @{{ infoProductivo.consecutivo }}</strong> del beneficiario <strong>@{{ nombre }} CC. @{{ documento }}.</strong>Por favor verifica su validez, y si es correcta Guarda, sino agrega nueva informacion.</p>
                        <table style="font-size: 12px" class="table table-responsive">
                            <tr>
                                <th>Metodo Reproducción</th>
                                <th>Tipo Producción</th>
                                <th>Tipo Corral</th>
                                <th>Estado Corral</th>
                                <th>Cantidad Animales</th>
                                <th>Kg Producidos</th>
                            </tr>
                            <tr v-for="cerdo in cerdos">
                                <td>@{{ cerdo.metodo_reproduccion.metodo_reproduccion }}</td>
                                <td>@{{ cerdo.tipo_produccion.tipo_produccion }}</td>
                                <td>@{{ cerdo.tipo_corral.tipo_corral }}</td>
                                <td>@{{ cerdo.estado_instalacion.estado_instalaciones }}</td>
                                <td>@{{ cerdo.cantidad_animales }}</td>
                                <td>@{{ cerdo.kg_producidos }}</td>
                                <td v-if="banderaC == 0">
                                    <button type="button" class="btn btn-default btn-sm" v-on:click="prepareToDeleteCerdo(cerdo)" data-toggle="modal" data-target="#modal-confirm-delete-cerdo-especies" >Eliminar</button>
                                </td>
                                <td v-if="banderaC == 1">
                                    <button type="button" class="btn btn-default btn-sm" v-on:click="guardarCerdoAnterior(cerdo)" >Guardar</button>
                                    <button type="button" class="btn btn-default btn-sm" v-on:click="borrarTemporalCerdo(cerdo)" >Eliminar</button>
                                </td>
                            </tr>

                        </table>

                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-especies" href="#tab-peces" aria-expanded="false" aria-controls="collapseThree">
                            PECES
                        </a>
                    </h4>
                </div>
                <div id="tab-peces" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                        <button style="margin-bottom: 10px" type="button"  class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-agregar-peces-especies" >Agregar</button>
                        <p v-if="banderaP == 1"><strong>Nota.</strong>La informacion de las aves fue tomada del <strong>Levantamiento de informacion Beneficio No @{{ infoProductivo.consecutivo }}</strong> del beneficiario <strong>@{{ nombre }} CC. @{{ documento }}.</strong>Por favor verifica su validez, y si es correcta Guarda, sino agrega nueva informacion.</p>
                        <table style="font-size: 12px" class="table table-responsive">
                            <tr>
                                <th>Tipo Produccion</th>
                                <th>Especie</th>
                                <th>Cantidad Estanques</th>
                                <th>Produccion (Kg)</th>
                                <th>Cantidad Comida (Kg)</th>
                                <th>Observaciones</th>
                                <th class="col-lg-1">Acciones</th>
                            </tr>
                            <tr v-for="pez in peces">
                                <td>@{{ pez.tipo_produccion.tipo_produccion  }}</td>
                                <td>@{{ pez.especie_peces.especie  }}</td>
                                <td>@{{ pez.cantidad_estanques }}</td>
                                <td>@{{ pez.kg_producidos }}</td>
                                <td>@{{ pez.kg_comida }}</td>
                                <td>@{{ pez.observaciones }}</td>
                                <td v-if="banderaP == 0">
                                    <button type="button" class="btn btn-default btn-sm" v-on:click="prepareToDeletePeces(pez)" data-toggle="modal" data-target="#modal-confirm-delete-peces-especies" >Eliminar</button>
                                </td>
                                <td v-if="banderaP == 1">
                                    <button type="button" class="btn btn-default btn-sm" v-on:click="guardarPezAnterior(pez)" >Guardar</button>
                                    <button type="button" class="btn btn-default btn-sm" v-on:click="borrarTemporalPez(pez)" >Eliminar</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-especies" href="#tab-otros" aria-expanded="false" aria-controls="collapseThree">
                            OTRAS ESPECIES
                        </a>
                    </h4>
                </div>
                <div id="tab-otros" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                        <button style="margin-bottom: 10px" type="button"  class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-agregar-otras-especies" >Agregar</button>
                        <p v-if="banderaO == 1"><strong>Nota.</strong>La informacion de las aves fue tomada del <strong>Levantamiento de informacion Beneficio No @{{ infoProductivo.consecutivo }}</strong> del beneficiario <strong>@{{ nombre }} CC. @{{ documento }}.</strong>Por favor verifica su validez, y si es correcta Guarda, sino agrega nueva informacion.</p>
                        <table style="font-size: 12px" class="table table-responsive">
                            <tr>
                                <th>Especie</th>
                                <th>Cantidad Animales</th>
                                <th>Observaciones</th>
                                <th class="col-lg-1">Acciones</th>
                            </tr>
                            <tr v-for="otra in otras">
                                <td>@{{ otra.especie }}</td>
                                <td>@{{ otra.cantidad_animales }}</td>
                                <td>@{{ otra.observaciones }}</td>
                                <td v-if="banderaO == 0">
                                    <button type="button" class="btn btn-default btn-sm" v-on:click="prepareToDeleteOtras(otra)" data-toggle="modal" data-target="#modal-confirm-delete-otras-especies" >Eliminar</button>
                                </td>
                                <td v-if="banderaO == 1">
                                    <button type="button" class="btn btn-default btn-sm" v-on:click="guardarOtraAnterior(otra)" >Guardar</button>
                                    <button type="button" class="btn btn-default btn-sm" v-on:click="borrarTemporalOtra(otra)" >Eliminar</button>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>



        @include('subsidios_productivos.diagnostico.especies_menores.form_create_ave')
        @include('subsidios_productivos.diagnostico.especies_menores.form_create_cerdos')
        @include('subsidios_productivos.diagnostico.especies_menores.form_create_peces')
        @include('subsidios_productivos.diagnostico.especies_menores.form_create_otras')

    </div>

</template>


