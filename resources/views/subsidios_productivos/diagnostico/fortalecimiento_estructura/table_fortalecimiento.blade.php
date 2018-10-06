<template id="fortalecimiento-infraestructura">
	<div>
		<h3>Fortalecimiento de Infraestructura Agropecuaria</h3>
		<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-agregar-fortalecimiento" style="margin-bottom: 15px;">
            Agregar
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
        <p v-if="bandera == 1"><strong>Nota.</strong>La informacion de los fortalecimientos de inrfaestructura agropecuaria fue tomada del <strong>Levantamiento de informacion Beneficio No @{{ infoProductivo.consecutivo }}</strong> del beneficiario <strong>@{{ nombre }} CC. @{{ documento }}.</strong>Por favor verifica su validez, y si es correcta Guarda, sino agrega el cultivo correspondiente.</p>
        <table class="table">
            <tr>
                <th>Tipo de Infraestructura</th>
                <th>Descripcion del Fortalecimiento</th>
                <th>Opciones</th>
            </tr>
            <tr v-for="fortalecimiento in fortalecimientos">
                <td>@{{ fortalecimiento.tipo }}</td>
                <td>@{{ fortalecimiento.descripcion }}</td>
                <td v-if="bandera == 0">
                    <button type="button" class="btn btn-default btn-sm" data-toggle="modal" v-on:click="prepareToDeleteOrEdit(1, fortalecimiento)" data-target="#modal-agregar-fortalecimiento" >Editar</button>
                    <button type="button" class="btn btn-default btn-sm" v-on:click="prepareToDeleteOrEdit(2, fortalecimiento)" data-toggle="modal" data-target="#modal-confirm-delete-fortalecimiento" >Eliminar</button>
                    <!--<button type="button" class="btn btn-default btn-sm" data-toggle="modal" v-on:click="prepareToRemove(cultivo)" data-target="#modal-confirm-delete-cultivo" >Eliminar</button>-->
                </td>
                <td v-if="bandera == 1">
                    <button type="button" class="btn btn-default btn-sm" v-on:click="guardarCultivoAnterior(cultivo)" >Guardar</button>
                    <button type="button" class="btn btn-default btn-sm" v-on:click="borrarTemporal(cultivo)" >Eliminar</button>                    
                </td>
            </tr>

        </table>

       @include('subsidios_productivos.diagnostico.fortalecimiento_estructura.form_create_fortalecimiento')
		
	</div>
</template>