<template id="potreros">
    <div>
        <h3>Potreros</h3>
        <p v-if="bandera == 1"><strong>Nota.</strong>La informacion de los potreros fue tomado del <strong>Levantamiento de informacion Beneficio No @{{ infoProductivo.consecutivo }}</strong> del beneficiario <strong>@{{ nombre }} CC. @{{ documento }}.</strong>Por favor verifica su validez, y si es correcta Guarda, sino agrega el correspondiente.</p>
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-agregar-potrero" style="margin-bottom: 15px;">
            Agregar
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
        <table class="table">
            <tr>
                <th>Nombre</th>
                <th>Extension(ha)</th>
                <th>Descanso(dias)</th>
                <th>Ocupacion(dias)</th>
                <th>Uso</th>
                <th>Opciones</th>
            </tr>
            <tr v-for="potrero in potreros">
                <td>@{{ potrero.potrero_lote }}</td>
                <td>@{{ potrero.extension_has }}</td>
                <td>@{{ potrero.rotacional_dias_descanso }}</td>
                <td>@{{ potrero.rotacional_dias_ocupacion }}</td>
                <td>@{{ potrero.uso }}</td>
                <td v-if="bandera == 0">
                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" v-on:click="prepareToRemove(potrero)" data-target="#modal-confirm-delete-potrero" >Eliminar</button>
                </td>
                <td v-if="bandera == 1">
                    <button type="button" class="btn btn-default btn-sm" v-on:click="guardarPotreroAnterior(potrero)" >Guardar</button>
                    <button type="button" class="btn btn-default btn-sm" v-on:click="borrarTemporal(potrero)">Eliminar</button>
                </td>
            </tr>

        </table>

        @include('subsidios_productivos.diagnostico.modals.form_create_potreros')


    </div>
</template>


