<template id="bovinos">
    <div>
        <h3>Bovinos</h3>
        <div class="panel-group" id="accordion-bovinos" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion-bovinos" href="#tab-bovinos" aria-expanded="true" aria-controls="collapseOne">
                            BOVINOS
                        </a>
                    </h4>
                </div>
                <div id="tab-bovinos" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <button style="margin-bottom: 10px" type="button"  class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-agregar-bovino" >Agregar</button>
                        <p v-if="banderaB == 1"><strong>Nota.</strong>La informacion de los bovinos fue tomada del <strong>Levantamiento de informacion Beneficio No @{{ infoProductivo.consecutivo }}</strong> del beneficiario <strong>@{{ nombre }} CC. @{{ documento }}.</strong>Por favor verifica su validez, y si es correcta Guarda, sino agrega nueva informacion.</p>
                        <table style="font-size: 12px" class="table table-responsive">
                            <tr>
                                <th>Tipo</th>
                                <th>Raza</th>
                                <th>Tenencia</th>
                                <th>Cantidad</th>
                                <th class="col-lg-1">Acciones</th>
                            </tr>
                            <tr v-for="bovino in bovinos">
                                <td>@{{ bovino.tipo_bovino.tipo_animal }}</td>
                                <td>@{{ bovino.raza.raza }}</td>
                                <td>@{{ bovino.tipo_propiedad.tipo_propiedad }}</td>
                                <td>@{{ bovino.cantidad }}</td>
                                <td v-if="banderaB == 0">
                                    <button type="button" class="btn btn-default btn-sm" v-on:click="prepareToDelete(bovino)" data-toggle="modal" data-target="#modal-confirm-delete-bovino" >Eliminar</button>
                                </td>
                                <td v-if="banderaB == 1">
                                    <button id="btnBovino" type="button" class="btn btn-default btn-sm" v-on:click="guardarBovinoAnterior(bovino)">Guardar</button>
                                    <button id="btnBovino" type="button" class="btn btn-default btn-sm" v-on:click="borralTemporalBovino(bovino)">Eliminar</button>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-bovinos" href="#manejo-animales" aria-expanded="false" aria-controls="collapseTwo">
                            MANEJO DE ANIMALES
                        </a>
                    </h4>
                </div>
                <div id="manejo-animales" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        <button style="margin-bottom: 10px" type="button"  class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-agregar-manejo-bovino" >Agregar</button>
                        <p v-if="banderaM == 1"><strong>Nota.</strong>La informacion del manejo de animales fue tomada del <strong>Levantamiento de informacion Beneficio No @{{ infoProductivo.consecutivo }}</strong> del beneficiario <strong>@{{ nombre }} CC. @{{ documento }}.</strong>Por favor verifica su validez, y si es correcta Guarda, sino agrega nueva informacion.</p>
                        <table style="font-size: 12px" class="table table-responsive">
                            <tr>
                                <th>Actividad</th>
                                <th>Producto</th>
                                <th>Periodicidad</th>
                                <th>Cantidad</th>
                                <th class="col-lg-1">Acciones</th>
                            </tr>
                            <tr v-for="manejo in manejoAnimales">
                                <td>@{{ manejo.actividad_manejo.nombre_actividad }}</td>
                                <td>@{{ manejo.producto_actividad }}</td>
                                <td>@{{ manejo.periodicidad }}</td>
                                <td>@{{ manejo.cantidad }}</td>
                                <td v-if="banderaM == 0">
                                    <button type="button" class="btn btn-default btn-sm" v-on:click="prepareToDeleteManejo(manejo)" data-toggle="modal" data-target="#modal-confirm-delete-manejo-bovino" >Eliminar</button>
                                </td>
                                <td v-if="banderaM == 1">
                                    <button id="btnManejo" type="button" class="btn btn-default btn-sm" v-on:click="guardarManejoAnterior(manejo)">Guardar</button>
                                    <button id="btnManejo" type="button" class="btn btn-default btn-sm" v-on:click="borralTemporalManejo(manejo)">Eliminar</button>
                                </td>
                            </tr>

                        </table>

                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-bovinos" href="#ordenio-bovinos" aria-expanded="false" aria-controls="collapseThree">
                            ORDEÑO
                        </a>
                    </h4>
                </div>
                <div id="ordenio-bovinos" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                        <button style="margin-bottom: 10px" type="button"  class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-agregar-ordenio-bovino" >Agregar</button>
                        <p v-if="banderaM == 1"><strong>Nota.</strong>La informacion del ordeño fue tomada del <strong>Levantamiento de informacion Beneficio No @{{ infoProductivo.consecutivo }}</strong> del beneficiario <strong>@{{ nombre }} CC. @{{ documento }}.</strong>Por favor verifica su validez, y si es correcta Guarda, sino agrega nueva informacion.</p>
                        <table style="font-size: 12px" class="table table-responsive">
                            <tr>
                                <th>Unidad</th>
                                <th>Frecuencia</th>
                                <th>Prod Diaria</th>
                                <th>Cantidad Autocomsumo</th>
                                <th>Cantidad Cuaja</th>
                                <th>Cantidad Venta</th>
                                <th class="col-lg-1">Acciones</th>
                            </tr>
                            <tr v-for="ordenio in ordenios">
                                <td>@{{ ordenio.unidad_ordenio.unidades_ordenio }}</td>
                                <td>@{{ ordenio.frecuencia_ordenio.frecuencia }}</td>
                                <td>@{{ ordenio.produccion_dia }}</td>
                                <td>@{{ ordenio.cantidad_autoconsumo }}</td>
                                <td>@{{ ordenio.cantidad_cuaja }}</td>
                                <td>@{{ ordenio.cantidad_venta }}</td>
                                <td v-if="banderaO == 0">
                                    <button type="button" class="btn btn-default btn-sm" v-on:click="prepareToDeleteOrdenio(ordenio)" data-toggle="modal" data-target="#modal-confirm-delete-ordenio-bovino" >Eliminar</button>
                                </td>
                                <td v-if="banderaO == 1">
                                    <button id="btnOrdenio" type="button" class="btn btn-default btn-sm" v-on:click="guardarOrdenioAnterior(ordenio)">Guardar</button>
                                    <button id="btnOrdenio" type="button" class="btn btn-default btn-sm" v-on:click="borralTemporalOrdenio(ordenio)">Eliminar</button>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
            <!--<div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-bovinos" href="#produccion-bovinos" aria-expanded="false" aria-controls="collapseThree">
                            PRODUCCIÓN
                        </a>
                    </h4>
                </div>
                <div id="produccion-bovinos" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                    </div>
                </div>
            </div>-->
        </div>



        @include('subsidios_productivos.diagnostico.bovinos.form_create_bovino')
        @include('subsidios_productivos.diagnostico.bovinos.form_create_manejo')
        @include('subsidios_productivos.diagnostico.bovinos.form_create_ordenio')
    </div>

</template>


