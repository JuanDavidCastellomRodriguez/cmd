<template id="table-unidades-sanitarias">
    <div>
        <h3>Unidades Sanitarias</h3>
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-agregar-unidad" style="margin-bottom: 15px;">
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
            <tr v-for="unidad in unidadesSanitarias">
                <td>@{{ unidad.nombre }}</td>
                <td>@{{ unidad.estructura_viga }}</td>
                <td>@{{ unidad.estructura_columna }}</td>
                <td>@{{ unidad.observaciones }}</td>
                <td>
                    <button class="btb btn-sm btn-default" v-on:click="editarUnidadSanitaria(unidad)">Editar</button>
                    <button class="btb btn-sm btn-default" data-toggle="modal" v-on:click="prepareToRemove(unidad)" data-target="#modal-confirm-delete-unidad">Eliminar</button>
                </td>
            </tr>
        </table>
        @include('vivienda.modals.form_create_unidad_sanitaria')

    </div>
</template>