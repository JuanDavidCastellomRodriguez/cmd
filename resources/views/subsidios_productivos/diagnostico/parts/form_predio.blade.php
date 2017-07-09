<template id="form-predio-template">
    <div>
        <h3>Informacion Predio</h3>
        <form class="form" data-toggle="validator" v-on:submit.prevent="guardarPredio()" enctype="multipart/form-data">

            <div class="form-group has-feedback col-lg-6 col-sm-12">
                <label for="exampleInputName2">Tenencia del Predio</label>
                <select class="form-control" v-model="tenenciaPredio.id_tipo_tenencia_tierras" required>
                    <option value="" disabled  >Seleccione...</option>
                    <option v-for="tipo in tipoTenencia" :value="tipo.id">@{{ tipo.tipo_tenencia  }}</option>
                </select>
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
            <!--
            <div class="form-group has-feedback col-lg-6 col-sm-12">
                <label for="exampleInputName2">Documento Predio</label>
                <input type="file"  class="form-control" name="pdf"  v-on:change="onFileChange">
                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
            </div>
            -->
            <div class="form-group has-feedback col-lg-6 col-sm-12">
                <label for="exampleInputName2">Area del Predio (Hectareas)</label>
                <input type="number" required class="form-control" v-model.number="tenenciaPredio.area_predio_has">
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
            <div v-if="tenenciaPredio.id_tipo_tenencia_tierras != 1 ">
                <div class="form-group has-feedback col-lg-6 col-sm-12">
                    <label for="exampleInputName2">Documento Identidad Propietario del Predio</label>
                    <input type="text"  class="form-control"  v-model="propietarioPredio.noCedula">
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 10px;"></span>
                </div>
                <div class="form-group has-feedback col-lg-6 col-sm-12">
                    <label for="exampleInputName2">Nombres Propietario del Predio</label>
                    <input type="text"  class="form-control" v-model="propietarioPredio.nombres">
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 10px;"></span>
                </div>
                <div class="form-group has-feedback col-lg-6 col-sm-12">
                    <label for="exampleInputName2">Apellidos Propietario del Predio</label>
                    <input type="text"  class="form-control" v-model="propietarioPredio.apellidos">
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 10px;"></span>
                </div>
                <div class="form-group has-feedback col-lg-6 col-sm-12">
                    <label for="exampleInputName2">Numero Telefono Propietario del Predio</label>
                    <input type="text"  class="form-control" v-model="propietarioPredio.telefono">
                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 10px;"></span>
                </div>
            </div>

            <div class="form-group col-lg-12 btns-forms">
                <button type="submit"  class="btn btn-default " data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando..." id="btn-guardar">Guardar</button>

            </div>

        </form>
    </div>

</template>
