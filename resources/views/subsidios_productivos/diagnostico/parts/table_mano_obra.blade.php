<template id="mano-obra">
    <div>
        <h3>Flujo de Mano de Obra</h3>
        <p v-if="bandera == 1"><strong>Nota.</strong>El flujo de mano de obra fue tomado del <strong>Levantamiento de informacion Beneficio No @{{ infoProductivo.consecutivo }}</strong> del beneficiario <strong>@{{ nombre }} CC. @{{ documento }}.</strong>Por favor verifica su validez, y si es correcta Guarda, sino agrega el correspondiente.</p>
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
                <td v-if="bandera == 0">
                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" v-on:click="prepareToRemove(mano)" data-target="#modal-confirm-delete-mano-obra" >Eliminar</button>
                </td>
                <td v-if="bandera == 1">
                    <button type="button" class="btn btn-default btn-sm" v-on:click="guardarManoAnterior(mano)" >Guardar</button>
                    <button type="button" class="btn btn-default btn-sm" v-on:click="borrarTemporal(mano)">Eliminar</button>
                </td>
            </tr>

        </table>

        @include('subsidios_productivos.diagnostico.modals.form_create_mano_obra')


    </div>
</template>


