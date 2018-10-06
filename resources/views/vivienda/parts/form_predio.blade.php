<template id="form-predio-template">
    <div>
        <h3>Informacion Predio</h3>
        <div class="col-lg-12 col-sm-6">
            <p v-if="bandera == 1"><strong>Nota.</strong>La informacion de este predio fue tomada del <strong>Levantamiento de informacion Beneficio No @{{ info_vivienda.consecutivo }}</strong> del beneficiario <strong>@{{ nombreBeneficiario }} CC. @{{ documentoBeneficiario }}.</strong><br>Por favor verifica su validez para este nuevo predio, y si es correcta Guarda, sino crea un nuevo Predio.</p>
        </div>
        <button v-if="bandera == 1" type="button" class="btn btn-default" @click="resetPredio()" style="margin-left: 86%;">
            Nuevo Predio
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>

        <form class="form" data-toggle="validator" v-on:submit.prevent="guardarPredio()" enctype="multipart/form-data">
            
            <div class="form-group has-feedback col-lg-6 col-sm-12">
                <label for="exampleInputName2">Tenencia del Predio</label>
                <select class="form-control" v-model="tenenciaPredio.id_tipo_tenencia_tierras" required>
                    <option value="" disabled  >Seleccione...</option>
                    <option v-for="tipo in tipoTenencia" :value="tipo.id">@{{ tipo.tipo_tenencia  }}</option>
                </select>
                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
            </div>
            <div class="form-group has-feedback col-lg-6 col-sm-12" v-if="tenenciaPredio.id_tipo_tenencia_tierras == 5">
                <label for="exampleInputName2">¿Cual?</label>
                <input type="text" required class="form-control" v-model="tenenciaPredio.otra_tenencia">
                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
            </div>
            <div class="form-group has-feedback col-lg-6 col-sm-12">
                <label for="exampleInputName2">Tipo Documento Predio</label>
                <select class="form-control" v-model="tenenciaPredio.id_opcion" required>
                    <option value="" disabled  >Seleccione...</option>
                    <option v-for="opcion in opcionesTenencia" :value="opcion.id">@{{ opcion.opcion_tenencia  }}</option>
                </select>
                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
            </div>
            <div class="form-group has-feedback col-lg-6 col-sm-12" v-if="tenenciaPredio.id_opcion == 4">
                <label for="exampleInputName2">¿Cual?</label>
                <input type="text" required class="form-control" v-model="tenenciaPredio.otra_opcion">
                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
            </div>
            <!--
            <div class="form-group has-feedback col-lg-6 col-sm-12">
                <label for="exampleInputName2">Documento Predio</label>
                <input type="file"  class="form-control" name="pdf"  v-on:change="onFileChange">
                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
            </div>
            -->
            <div class="form-group has-feedback col-lg-6 col-sm-12">
                <label for="exampleInputName2">Area del Predio (Hectareas)</label>
                <input type="number" required class="form-control" v-model="tenenciaPredio.area_predio_has" step="0.1">
                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 15px;"></span>
            </div>
            <div class="form-group has-feedback col-lg-6 col-sm-12">
                <label for="exampleInputName2">Nombre del Predio</label>
                <input type="text" required class="form-control"  v-model="predio.nombre">
                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
            </div>
            <div class="form-group has-feedback col-lg-6 col-sm-12">
                <label for="exampleInputName2">Direccion del Predio</label>
                <input type="text" required class="form-control" v-model="predio.direccion">
                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
            </div>
            <div class="form-group has-feedback col-lg-6 col-sm-12">
                <label for="exampleInputName2">Latitud del Predio</label>
                <input type="text" required class="form-control" v-model.number="predio.latitud">
                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
            </div>
            <div class="form-group has-feedback col-lg-6 col-sm-12">
                <label for="exampleInputName2">Logitud del Predio</label>
                <input type="text" required class="form-control" v-model.number="predio.longitud">
                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 15px;"></span>
            </div>
            <div class="form-group has-feedback col-lg-6 col-sm-12">
                <label for="exampleInputName2">MSNM del Predio</label>
                <input type="number" required class="form-control"  v-model="predio.msnm">
                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
            </div>
            <div class="form-group has-feedback col-lg-6 col-sm-12">
                <label for="exampleInputName2">Departamento del Predio</label>
                <select class="form-control" v-model="predio.idDepartamento" v-on:change="changeDepartamento($event.target.value, '')" required>
                    <option value="" disabled >Seleccione...</option>
                    <option v-for="departamento in departamentos" :value="departamento.id">@{{ departamento.departamento  }}</option>
                </select>
                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
            </div>
            <div class="form-group has-feedback col-lg-6 col-sm-12">
                <label for="exampleInputName2">Municipio del Predio</label>
                <select class="form-control" v-model="predio.idMunicipio" v-on:change="changeMunicipio($event.target.value, '')" required >
                    <option value="" disabled >Seleccione...</option>
                    <option v-for="municipio in municipios" :value="municipio.id">@{{ municipio.municipio }}</option>
                </select>
                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
            </div>
            <div class="form-group has-feedback col-lg-6 col-sm-12">
                <label for="exampleInputName2">Vereda del Predio</label>
                <select class="form-control" v-model="predio.idVereda" required>
                    <option value="" disabled  >Seleccione...</option>
                    <option v-for="vereda in veredas" :value="vereda.id">@{{ vereda.vereda  }}</option>
                </select>
                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
            </div>
            <div class="form-group has-feedback col-lg-6 col-sm-12">
                <label for="exampleInputName2">Documento Identidad Propietario del Predio</label>
                <input type="text" required class="form-control"  v-model="propietarioPredio.noCedula">
                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 10px;"></span>
            </div>
            <div class="form-group has-feedback col-lg-6 col-sm-12">
                <label for="exampleInputName2">Nombres Propietario del Predio</label>
                <input type="text" required class="form-control" v-model="propietarioPredio.nombres">
                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 10px;"></span>
            </div>
            <div class="form-group has-feedback col-lg-6 col-sm-12">
                <label for="exampleInputName2">Apellidos Propietario del Predio</label>
                <input type="text" required class="form-control" v-model="propietarioPredio.apellidos">
                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 10px;"></span>
            </div>
            <div class="form-group has-feedback col-lg-6 col-sm-12">
                <label for="exampleInputName2">Numero Telefono Propietario del Predio</label>
                <input type="text" required class="form-control" v-model="propietarioPredio.telefono">
                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 10px;"></span>
            </div>
            
            <div class="form-group col-lg-12 btns-forms">
                <button type="submit"  class="btn btn-default " data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando..." id="btn-guardar">Guardar</button>
                <!--<button type="button" class="btn btn-default">Siguiente</button>-->
            </div>

        </form>
        
    </div>
    
</template>
