<template id="cultivos">
    <div>
        <h3>Actividades Agricolas</h3>
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-agregar-cultivo" style="margin-bottom: 15px;">
            Agregar
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
        <table class="table">
            <tr>
                <th>Producto</th>
                <th>Descripcion</th>
                <th>Fecha Establecimiento</th>
                <th>Fecha Renovación</th>
                <th>Opciones</th>
            </tr>
            <tr v-for="cultivo in cultivos">
                <td>@{{ cultivo.nombre_producto }}</td>
                <td>@{{ cultivo.descripcion_cultivo }}</td>
                <td>@{{ cultivo.fecha_establecimiento_cultivo }}</td>
                <td>@{{ cultivo.fecha_renovacion }}</td>
                <td>
                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" v-on:click="prepareToDetalle(cultivo)" data-target="#modal-detalle-cultivo" >Detalle</button>
                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" v-on:click="prepareToEdit(cultivo)" data-target="#modal-agregar-cultivo" >Editar</button>
                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" v-on:click="prepareToRemove(cultivo)" data-target="#modal-confirm-delete-cultivo" >Eliminar</button>

                </td>
            </tr>

        </table>

        @include('subsidios_productivos.diagnostico.cultivos.form_create_cultivos')


    </div>
</template>


