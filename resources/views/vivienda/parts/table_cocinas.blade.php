<template id="table-cocinas">
    <div>
        <h3>Cocina</h3>
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-agregar-cocina" style="margin-bottom: 15px;">
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
            <tr v-for="cocina in cocinas">
                <td>@{{ cocina.nombre }}</td>
                <td>@{{ cocina.estructura_viga }}</td>
                <td>@{{ cocina.estructura_columna }}</td>
                <td>@{{ cocina.observaciones }}</td>
                <td>
                    <button class="btb btn-sm btn-default" v-on:click="editarCocina(cocina)">Editar</button>
                    <button class="btb btn-sm btn-default" data-toggle="modal" v-on:click="prepareToRemove(cocina)" data-target="#modal-confirm-delete-cocina">Eliminar</button>
                </td>
            </tr>
        </table>
        @include('vivienda.modals.form_create_cocina')

    </div>
</template>

