<template id="detalle-cultivo">
    @{{ $data }}
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-detalle-cultivo"name="modal-detalle-cultivo">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form class="form" data-toggle="validator" v-on:submit.prevent="guardarDetalle()" >
                    <div class="modal-header">

                        <h4 class="modal-title">Detalle del Cultivo</h4>
                    </div>
                    <div class="modal-body">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingOne">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            PLAGAS O ENFERMEDADES
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                    <div class="panel-body">

                                        <button style="margin-bottom: 10px" type="button" v-if="!agregandoPlaga"v-on:click="showAgregarPlaga(1)" class="btn btn-sm btn-success">Agregar</button>
                                        <button style="margin-bottom: 10px" type="button" v-if="agregandoPlaga" v-on:click="showAgregarPlaga(0)" class="btn btn-sm btn-danger">Cancelar</button>

                                        @include('subsidios_productivos.diagnostico.cultivos.detalle.form_nueva_plaga')
                                        <table style="font-size: 12px" class="table table-responsive">
                                            <tr>
                                                <th>Tipo</th>
                                                <th>Control</th>
                                                <th>Frecuencia</th>
                                                <th class="col-lg-1">Acciones</th>
                                            </tr>
                                            <tr v-for="plaga in plagas">
                                                <td>@{{ plaga.tipo_plaga }}</td>
                                                <td>@{{ plaga.caracteristicas_control }}</td>
                                                <td>@{{ plaga.frecuencia }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-default btn-sm" v-on:click="eliminarPlaga(plaga)">Eliminar</button>
                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingTwo">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            PREPARACION Y SIEMBRA
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <div class="panel-body">
                                        <h4>
                                            Actividades
                                            <button type="button" v-if="!agregandoActividad"v-on:click="showAgregar(1,1)" class="btn btn-sm btn-success">Agregar</button>
                                            <button type="button" v-if="agregandoActividad" v-on:click="showAgregar(0,1)" class="btn btn-sm btn-danger">Cancelar</button>
                                        </h4>
                                        @include('subsidios_productivos.diagnostico.cultivos.detalle.form_nuevo_detalle')
                                        <table style="font-size: 12px" class="table table-responsive">
                                            <tr>
                                                <th>Componente</th>
                                                <th>Actividades</th>
                                                <th>Frecuencia</th>
                                                <th>Mano de Obra</th>
                                                <th class="col-lg-1">Acciones</th>
                                            </tr>
                                            <tr v-for="detalle in detalles" v-if="detalle.id_etapa == 1">
                                                <td>@{{ detalle.componente.componente }}</td>
                                                <td>@{{ detalle.actividades }}</td>
                                                <td>@{{ detalle.frecuencia }}</td>
                                                <td>@{{ detalle.mano_obra }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-default btn-sm" v-on:click="eliminarActividad(detalle)">Eliminar</button>
                                                </td>
                                            </tr>

                                        </table>
                                        <h4>
                                            Insumos
                                            <button type="button" v-if="!agregandoInsumo"v-on:click="showAgregarInsumo(1,1)" class="btn btn-sm btn-success">Agregar</button>
                                            <button type="button" v-if="agregandoInsumo" v-on:click="showAgregarInsumo(0,1)" class="btn btn-sm btn-danger">Cancelar</button>
                                        </h4>
                                        @include('subsidios_productivos.diagnostico.cultivos.detalle.form_nuevo_insumo')
                                        <table style="font-size: 12px" class="table table-responsive">
                                            <tr>
                                                <th>Insumo</th>
                                                <th>Cantidad</th>
                                                <th>Frecuencia</th>
                                                <th class="col-lg-1">Acciones</th>
                                            </tr>
                                            <tr v-for="insumo in insumos" v-if="insumo.id_etapa == 1">
                                                <td>@{{ insumo.insumo }}</td>
                                                <td>@{{ insumo.cantidad }}</td>
                                                <td>@{{ insumo.frecuencia }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-default btn-sm" v-on:click="eliminarInsumo(insumo)">Eliminar</button>
                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingThree">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            MANEJO EN PERIODO DE ESTABLECIMIENTO
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                    <div class="panel-body">
                                        <h4>
                                            Actividades
                                            <button type="button" v-if="!agregandoActividad"v-on:click="showAgregar(1,2)" class="btn btn-sm btn-success">Agregar</button>
                                            <button type="button" v-if="agregandoActividad" v-on:click="showAgregar(0,2)" class="btn btn-sm btn-danger">Cancelar</button>
                                        </h4>
                                        @include('subsidios_productivos.diagnostico.cultivos.detalle.form_nuevo_detalle')
                                        <table style="font-size: 12px" class="table table-responsive">
                                            <tr>
                                                <th>Componente</th>
                                                <th>Actividades</th>
                                                <th>Frecuencia</th>
                                                <th>Mano de Obra</th>
                                                <th class="col-lg-1">Acciones</th>
                                            </tr>
                                            <tr v-for="detalle in detalles" v-if="detalle.id_etapa == 2">
                                                <td>@{{ detalle.componente.componente }}</td>
                                                <td>@{{ detalle.actividades }}</td>
                                                <td>@{{ detalle.frecuencia }}</td>
                                                <td>@{{ detalle.mano_obra }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-default btn-sm" v-on:click="eliminarActividad(detalle)">Eliminar</button>
                                                </td>
                                            </tr>

                                        </table>
                                        <h4>
                                            Insumos
                                            <button type="button" v-if="!agregandoInsumo"v-on:click="showAgregarInsumo(1,2)" class="btn btn-sm btn-success">Agregar</button>
                                            <button type="button" v-if="agregandoInsumo" v-on:click="showAgregarInsumo(0,2)" class="btn btn-sm btn-danger">Cancelar</button>
                                        </h4>
                                        @include('subsidios_productivos.diagnostico.cultivos.detalle.form_nuevo_insumo')
                                        <table style="font-size: 12px" class="table table-responsive">
                                            <tr>
                                                <th>Tipo</th>
                                                <th>Control</th>
                                                <th>Frecuencia</th>
                                                <th class="col-lg-1">Acciones</th>
                                            </tr>
                                            <tr v-for="insumo in insumos" v-if="insumo.id_etapa == 2">
                                                <td>@{{ insumo.insumo }}</td>
                                                <td>@{{ insumo.cantidad }}</td>
                                                <td>@{{ insumo.frecuencia }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-default btn-sm" v-on:click="eliminarInsumo(insumo)">Eliminar</button>
                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingFour">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            MANEJO Y MANTENIMIENTO
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                    <div class="panel-body">
                                        <h4>
                                            Actividades
                                            <button type="button" v-if="!agregandoActividad"v-on:click="showAgregar(1,3)" class="btn btn-sm btn-success">Agregar</button>
                                            <button type="button" v-if="agregandoActividad" v-on:click="showAgregar(0,3)" class="btn btn-sm btn-danger">Cancelar</button>
                                        </h4>
                                        @include('subsidios_productivos.diagnostico.cultivos.detalle.form_nuevo_detalle')
                                        <table style="font-size: 12px" class="table table-responsive">
                                            <tr>
                                                <th>Componente</th>
                                                <th>Actividades</th>
                                                <th>Frecuencia</th>
                                                <th>Mano de Obra</th>
                                                <th class="col-lg-1">Acciones</th>
                                            </tr>
                                            <tr v-for="detalle in detalles" v-if="detalle.id_etapa == 3">
                                                <td>@{{ detalle.componente.componente }}</td>
                                                <td>@{{ detalle.actividades }}</td>
                                                <td>@{{ detalle.frecuencia }}</td>
                                                <td>@{{ detalle.mano_obra }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-default btn-sm" v-on:click="eliminarActividad(detalle)">Eliminar</button>
                                                </td>
                                            </tr>

                                        </table>
                                        <h4>
                                            Insumos
                                            <button type="button" v-if="!agregandoInsumo"v-on:click="showAgregarInsumo(1,3)" class="btn btn-sm btn-success">Agregar</button>
                                            <button type="button" v-if="agregandoInsumo" v-on:click="showAgregarInsumo(0,3)" class="btn btn-sm btn-danger">Cancelar</button>
                                        </h4>
                                        @include('subsidios_productivos.diagnostico.cultivos.detalle.form_nuevo_insumo')
                                        <table style="font-size: 12px" class="table table-responsive">
                                            <tr>
                                                <th>Tipo</th>
                                                <th>Control</th>
                                                <th>Frecuencia</th>
                                                <th class="col-lg-1">Acciones</th>
                                            </tr>
                                            <tr v-for="insumo in insumos" v-if="insumo.id_etapa == 3">
                                                <td>@{{ insumo.insumo }}</td>
                                                <td>@{{ insumo.cantidad }}</td>
                                                <td>@{{ insumo.frecuencia }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-default btn-sm" v-on:click="eliminarInsumo(insumo)">Eliminar</button>
                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingFive">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                            VENTAS
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                                    <div class="panel-body">
                                        <button style="margin-bottom: 10px" type="button" v-if="!agregandoVenta"v-on:click="showAgregarVenta(1)" class="btn btn-sm btn-success">Agregar</button>
                                        <button style="margin-bottom: 10px" type="button" v-if="agregandoVenta" v-on:click="showAgregarVenta(0)" class="btn btn-sm btn-danger">Cancelar</button>

                                        @include('subsidios_productivos.diagnostico.cultivos.detalle.form_nueva_venta')
                                        <table style="font-size: 12px" class="table table-responsive">
                                            <tr>
                                                <th>Mes</th>
                                                <th>Cant. Venta</th>
                                                <th>Cant. Autoconsumo</th>
                                                <th>Cant. 1ª Calidad</th>
                                                <th>Cant. 2ª Calidad</th>
                                                <th>Cant. 3ª Calidad</th>
                                                <th class="col-lg-1">Acciones</th>
                                            </tr>
                                            <tr v-for="venta in ventas">
                                                <td>@{{ venta.mes.mes }}</td>
                                                <td>@{{ venta.cantidad_venta }}</td>
                                                <td>@{{ venta.cantidad_autoconsumo }}</td>
                                                <td>@{{ venta.cantidad_primera_calidad }}</td>
                                                <td>@{{ venta.cantidad_segunda_calidad }}</td>
                                                <td>@{{ venta.cantidad_tercera_calidad }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-default btn-sm" v-on:click="eliminarVenta(venta)">Eliminar</button>
                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-default" data-dismiss="modal"  v-on:click="formReset()" >Cerrar</button>


                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</template>