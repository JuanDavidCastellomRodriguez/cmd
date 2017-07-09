<template id="mano-obra">
    <div>
        <h3>Flujo de Mano de Obra</h3>
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-agregar-mano-obra" style="margin-bottom: 15px;">
            Agregar
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
        <table class="table">
            <tr>
                <th>Mes</th>
                <th>Jornal Vendido</th>
                <th>Actividad J. Vendido</th>
                <th>Jornal Contratado</th>
                <th>Actividad J. Contratado</th>
                <th>Opciones</th>
            </tr>
            <tr v-for="mano in manosObra">
                <td>@{{ mano.mes }}</td>
                <td>@{{ mano.jornal_vendido }}</td>
                <td>@{{ mano.actividad_jornal_vendido }}</td>
                <td>@{{ mano.jornal_contratado }}</td>
                <td>@{{ mano.actividad_jornal_vendido }}</td>
                <td>
                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" v-on:click="prepareToRemove(mano)" data-target="#modal-confirm-delete-mano-obra" >Eliminar</button>
                </td>
            </tr>

        </table>

        @include('subsidios_productivos.diagnostico.modals.form_create_mano_obra')


    </div>
</template>


