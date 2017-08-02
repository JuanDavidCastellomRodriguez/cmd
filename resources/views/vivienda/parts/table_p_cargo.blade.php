<template id="personas-cargo">
    <div>
        <h3>Persona a Cargo</h3>
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-agregar-persona" style="margin-bottom: 15px;">
            Agregar
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
        <table class="table">
            <tr>
                <th>Edad (Años)</th>
                <th>Genero</th>
                <th>Nivel Educativo</th>
                <th>Tipo</th>
                <th>Opciones</th>
            </tr>
            <tr v-for="persona in personasCargo ">
                <td>@{{ persona.edad }}</td>
                <td>@{{ persona.genero }}</td>
                <td>@{{ persona.educacion }}</td>
                <td>@{{ persona.tipo }}</td>
                <td>
                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" v-on:click="prepareToRemove(persona)" data-target="#modal-confirm-delete-persona" >Eliminar</button>
                </td>
            </tr>
        </table>

        @include('vivienda.modals.form_create_persona_cargo')
    </div>
</template>

