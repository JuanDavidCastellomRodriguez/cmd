
<h3>Información Inicial</h3>
<form v-on:submit.prevent="guardarGeneral()" class="form">
    <div class=" form-group col-lg-6 col-sm-12">
        <label for="exampleInputName2">Fecha Encuesta</label>
        <input type="text" name="fecha_encuesta" id="fecha_encuesta" class="form-control datepicker" required v-model="infoVivienda.fechaEncuesta">
    </div>
    <div class="form-group col-lg-6 col-sm-12">
        <label for="exampleInputName2">Número de familias que viven en la vivienda</label>
        <input type="number" required class="form-control" id="exampleInputName2" v-model.number="infoVivienda.numeroFamiliasVivienda">
    </div>
    <div class="form-group col-lg-6 col-sm-6">
        <label for="exampleInputName2">¿Atiende el propietario de la vivienda?</label>
        <div class="checkbox" >
            <label><input type="checkbox" v-model="infoVivienda.respondePropietario" name="propietario">Si</label>
        </div>
    </div>
    <div class="form-group col-lg-6 col-sm-6">
        <label for="exampleInputName2">¿Beneficiario de programa de Inversión Social?</label>
        <div class="checkbox"  >
            <label><input type="checkbox" v-model="infoVivienda.programaSocial" name="programasocial">Si</label>
        </div>
    </div>
    <div class="form-group col-lg-6 col-sm-12">
        <label for="exampleInputName2">Tipo de Familia</label>
        <select v-model="generalidades.idTipologiaFamilia" class="form-control">
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
        <select  v-model="generalidades.idTipoVehiculo" class="form-control">
            <option value="" disabled >Seleccione...</option>
            <option v-for=" vehiculo in tiposVehiculos" :value="vehiculo.id">@{{ vehiculo.tipo_vehiculo }}</option>
        </select>
    </div>
    <div class="form-group col-lg-6 col-sm-12">
        <label for="exampleInputName2">Vía de Acceso</label>
        <select v-model="generalidades.idTipoViaAcceso" class="form-control">
            <option value="" disabled >Seleccione...</option>
            <option v-for="via in viasAcceso" :value="via.id">@{{ via.tipo_via_acceso }}</option>
        </select>
    </div>
    <div class="form-group col-lg-6 col-sm-12">
        <label for="exampleInputName2">Estado de la Vía</label>
        <select v-model="generalidades.idEstadoVia" class="form-control">
            <option value="" disabled >Seleccione...</option>
            <option v-for="estado in estadosVia" :value="estado.id" >@{{  estado.estado_via }}</option>
        </select>
    </div>
    <div class="form-group col-lg-6 col-sm-12">
        <label for="exampleInputName2">Tiempo de Recorrido</label>
        <select v-model="generalidades.idTiempoRecorrido" class="form-control">
            <option value="" disabled >Seleccione...</option>
            <option v-for="tiempo in tiemposRecorrido" :value="tiempo.id">@{{ tiempo.tiempo_recorrido }}</option>
        </select>
    </div>
    <div class="form-group col-lg-12 btns-forms">
        <button type="submit"  class="btn btn-default " data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando..." id="btn-guardar">Guardar</button>
        <button type="button" class="btn btn-default">Siguiente</button>
    </div>
</form>