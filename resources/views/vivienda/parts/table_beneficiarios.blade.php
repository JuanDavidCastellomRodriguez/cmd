<template id="beneficiarios">
    <div>
        <h3>Persona quienes habitan la Vivienda</h3>
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-agregar-beneficiario" style="margin-bottom: 15px;">
            Agregar
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
        <div class="col-lg-12 col-sm-6">
            <p v-if="bandera == 1"><strong>Nota.</strong>La informacion de los habitantes fue tomada del <strong>Levantamiento de informacion Beneficio No @{{ viviendaAnterior.consecutivo }}</strong> del beneficiario <strong>@{{ nombre }} CC. @{{ documento }}.</strong>Por favor verifica su validez y si es correcta Guarda, sino crea un nuevo beneficiario.</p>
        </div>
        <table class="table">
            <tr>
                <th>Documento</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>¿Cabeza Hogar?</th>
                <th>Opciones</th>
            </tr>
            <tr v-for="beneficiario in beneficiarios">
                <td>@{{ beneficiario.no_cedula }}</td>
                <td>@{{ beneficiario.nombres }}</td>
                <td>@{{ beneficiario.apellidos }}</td>
                <td><input type="checkbox" disabled v-bind:checked="beneficiario.cabeza_hogar == 1" ></td>
                <td v-if="bandera == 0">
                    <button  type="button" class="btn btn-default btn-sm" data-toggle="modal" v-on:click="prepareToRemove(beneficiario)" data-target="#modal-confirm-delete-beneficiario" >Eliminar</button>
                </td>
                <td v-if="bandera == 1">
                    <button  type="button" class="btn btn-default btn-sm" v-on:click="guardarBeneficiarioAnterior(beneficiario.id)">Guardar</button>
                    <button  type="button" class="btn btn-default btn-sm" v-on:click="eliminarTempo(beneficiario)">Eliminar</button>
                </td>
            </tr>

        </table>

        @include('vivienda.modals.form_create_beneficiario')


    </div>
</template>


