<template id="beneficiarios">
    <div>
        <h3>Persona quienes habitan la Vivienda</h3>
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-agregar-beneficiario" style="margin-bottom: 15px;">
            Agregar
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
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
                <td>
                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" v-on:click="prepareToRemove(beneficiario)" data-target="#modal-confirm-delete-beneficiario" >Eliminar</button>
                </td>
            </tr>

        </table>

        @include('vivienda.modals.form_create_beneficiario')


    </div>
</template>


