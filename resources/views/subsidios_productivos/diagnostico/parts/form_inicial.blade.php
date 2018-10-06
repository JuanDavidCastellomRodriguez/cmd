
<h3>Informacion Inicial</h3>
<form v-on:submit.prevent="guardarGeneral()" class="form">
    <div class=" form-group col-lg-6 col-sm-12">
        <label for="exampleInputName2">Fecha Encuesta</label>
        <input type="text" name="fecha_encuesta" id="fecha_encuesta" class="form-control datepicker" required v-model="infoProductivo.fechaEncuesta">
    </div>
    <div class="form-group col-lg-6 col-sm-12">
        <label for="exampleInputName2">Numero de familias que viven en la vivienda</label>
        <input type="number" required class="form-control" id="exampleInputName2" v-model.number="infoProductivo.numeroFamiliasVivienda">
    </div>
    <div class="form-group col-lg-6 col-sm-6">
        <label for="exampleInputName2">¿Atiende el propietario de la vivienda?</label>
        <div class="checkbox" >
            <label><input type="checkbox" v-model="infoProductivo.respondePropietario" name="propietario">Si</label>
        </div>
    </div>
    <div class="form-group col-lg-6 col-sm-6">
        <label for="exampleInputName2">¿Beneficiario de programa de Inversión Social?</label>
        <div class="checkbox"  >
            <label><input type="checkbox" v-model="infoProductivo.programaSocial" name="programasocial">Si</label>
        </div>
    </div>
    <p v-if="bandera == 1"><strong>Nota.</strong>La informacion incial fue tomada del <strong>Levantamiento de informacion Beneficio No @{{ infoProductivoAnterior.consecutivo }}</strong> del beneficiario <strong>@{{ infoProductivo.beneficiario.nombre }} CC. @{{ infoProductivo.beneficiario.documento }}.</strong>Por favor verifica su validez, y si es correcta Guarda, sino crea nueva informacion inicial.</p>
    <button v-if="bandera == 1" type="button" class="btn btn-default" @click="resetGeneral()" style="margin-left: 86%;">
        Nuevo
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
    </button>
    <div class="form-group col-lg-6 col-sm-12">
        <label for="exampleInputName2">Tipo de Proyecto</label>
        <select required="required" v-model="generalidades.id_tipo_proyecto" class="form-control">
            <option value="" disabled >Seleccione...</option>
            <option v-for="tipo in tipoProyectos" :value="tipo.id">@{{ tipo.tipo_proyecto }}</option>
        </select>
    </div>
    <div class="form-group col-lg-6 col-sm-12">
        <label for="exampleInputName2">Tipo de Familia</label>
        <select required="required" v-model="generalidades.idTipologiaFamilia" class="form-control">
            <option value="" disabled >Seleccione...</option>
            <option v-for="tipologia in tipologiasFamilia" :value="tipologia.id">@{{ tipologia.tipologia_familia }}</option>
        </select>
    </div>

    <div class=" form-group col-lg-6 col-sm-12">
        <label for="exampleInputName2">Fecha Llegada a Vereda</label>
        <input type="text" name="fecha_vereda" id="fecha_vereda" class="form-control datepicker" required v-model="generalidades.fechaViveVereda">
    </div>
    <div class=" form-group col-lg-6 col-sm-12">
        <label for="exampleInputName2">Fecha Llegada a Vivienda</label>
        <input type="text" name="fecha_vivienda" id="fecha_vivienda" class="form-control datepicker" required v-model="generalidades.fechaViveVivienda">
    </div>
    <div class="form-group col-lg-6 col-sm-12">
        <label for="exampleInputName2">Medio de Transporte</label>
        <select required="required" v-model="generalidades.idTipoVehiculo" class="form-control">
            <option value="" disabled >Seleccione...</option>
            <option v-for=" vehiculo in tiposVehiculos" :value="vehiculo.id">@{{ vehiculo.tipo_vehiculo }}</option>
        </select>
    </div>
    <div class="form-group col-lg-6 col-sm-12">
        <label for="exampleInputName2">Via de Acceso</label>
        <select required="required" v-model="generalidades.idTipoViaAcceso" class="form-control">
            <option value="" disabled >Seleccione...</option>
            <option v-for="via in viasAcceso" :value="via.id">@{{ via.tipo_via_acceso }}</option>
        </select>
    </div>
    <div class="form-group col-lg-6 col-sm-12">
        <label for="exampleInputName2">Estado de la Via</label>
        <select required="required" v-model="generalidades.idEstadoVia" class="form-control">
            <option value="" disabled >Seleccione...</option>
            <option v-for="estado in estadosVia" :value="estado.id" >@{{  estado.estado_via }}</option>
        </select>
    </div>
    <div class="form-group col-lg-6 col-sm-12">
        <label for="exampleInputName2">Tiempo de Recorrido</label>
        <select required="required" v-model="generalidades.idTiempoRecorrido" class="form-control">
            <option value="" disabled >Seleccione...</option>
            <option v-for="tiempo in tiemposRecorrido" :value="tiempo.id">@{{ tiempo.tiempo_recorrido }}</option>
        </select>
    </div>

    <div class="form-group col-lg-12 btns-forms">
        <button type="submit"  class="btn btn-default " data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando..." id="btn-guardar">Guardar</button>
        <!--<button type="button" class="btn btn-default">Siguiente</button>-->
    </div>
</form>