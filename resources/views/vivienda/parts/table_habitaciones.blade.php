<template id="table-habitaciones">
    <div>
        <h3>Habitaciones</h3>
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-agregar-habitacion" style="margin-bottom: 15px;">
            Agregar
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
        <table class="table">
            <tr>
                <th>Nombre</th>
                <th>Vigas</th>
                <th>Columnas</th>
                <th>Observaciones</th>
                <th>Opciones</th>
            </tr>
            <tr v-for="habitacion in habitaciones">
                <td>@{{ habitacion.nombre }}</td>
                <td>@{{ habitacion.estructura_viga }}</td>
                <td>@{{ habitacion.estructura_columna }}</td>
                <td>@{{ habitacion.observaciones }}</td>
                <td>
                    <button class="btb btn-sm btn-default" v-on:click="editarHabitacion(habitacion)">Editar</button>
                    <button class="btb btn-sm btn-default" data-toggle="modal" v-on:click="prepareToRemove(habitacion)" data-target="#modal-confirm-delete-habitacion">Eliminar</button>
                </td>
            </tr>
        </table>
        @include('vivienda.modals.form_create_habitacion')

    </div>
</template>
