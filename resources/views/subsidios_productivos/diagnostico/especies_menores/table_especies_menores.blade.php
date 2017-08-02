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
                        <table style="font-size: 12px" class="table table-responsive">
                            <tr>
                                <th>Tipo</th>
                                <th>Raza</th>
                                <th>Tenencia</th>
                                <th>Cantidad</th>
                                <th class="col-lg-1">Acciones</th>
                            </tr>
                            <tr v-for="ave in aves">
                                <td>@{{ ave.tipo_bovino.tipo_animal }}</td>
                                <td>@{{ ave.raza.raza }}</td>
                                <td>@{{ ave.tipo_propiedad.tipo_propiedad }}</td>
                                <td>@{{ ave.cantidad }}</td>
                                <td>
                                    <button type="button" class="btn btn-default btn-sm" v-on:click="prepareToDeleteAve(ave)" data-toggle="modal" data-target="#modal-confirm-delete-ave-especies" >Eliminar</button>
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
                        <button style="margin-bottom: 10px" type="button"  class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-agregar-manejo-bovino" >Agregar</button>
                        <table style="font-size: 12px" class="table table-responsive">
                            <tr>
                                <th>Actividad</th>
                                <th>Producto</th>
                                <th>Periodicidad</th>
                                <th>Cantidad</th>
                                <th class="col-lg-1">Acciones</th>
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
                        <button style="margin-bottom: 10px" type="button"  class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-agregar-ordenio-bovino" >Agregar</button>
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
                        <button style="margin-bottom: 10px" type="button"  class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-agregar-ordenio-bovino" >Agregar</button>
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


                        </table>
                    </div>
                </div>
            </div>
        </div>



        @include('subsidios_productivos.diagnostico.especies_menores.form_create_ave')

    </div>

</template>


