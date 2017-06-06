<template id="form-cierre">
    <div>
        <h2>Cierre</h2>

        <h4>Indicadores</h4>
        <form >
            <div class="row">
                <div class="form-group col-lg-3 col-sm-12">
                    <label  for="exampleInputName2">Numero de Habitaciones</label>
                    <input v-model="cierre.habitaciones" type="number" required class="form-control" id="exampleInputName2" >
                </div>
                <div class="form-group col-lg-2 col-sm-6">
                    <label for="exampleInputName2">¿Hacinamiento?</label>
                    <div class="checkbox" >
                        <label><input type="checkbox" v-model="cierre.hacinamiento" name="propietario">Si</label>
                    </div>
                </div>
                <div class="form-group col-lg-3 col-sm-6">
                    <label for="exampleInputName2">¿Sanemaiento Basico?</label>
                    <div class="checkbox" >
                        <label><input type="checkbox" v-model="cierre.saneamientoBasico"  name="propietario">Si</label>
                    </div>
                </div>
                <div class="form-group col-lg-3 col-sm-6">
                    <label for="exampleInputName2">¿Condciones de seguridad, estrucutra y estetica?</label>
                    <div class="checkbox" >
                        <label><input type="checkbox" v-model="cierre.condicionesSegEst"  name="propietario">Si</label>
                    </div>
                </div>
            </div>
            <h4>Zona de Riesgo</h4>
            <div class="row">
                <div class="form-group col-lg-3 col-sm-6 col-md-4" v-for=" riesgo in riesgos">
                    <div class="checkbox">
                        <label >
                            <input type="checkbox" :value="riesgo.id"  class="" v-model="cierre.riesgos">
                            @{{ riesgo.riesgo }}
                        </label>
                    </div>
                </div>
                <div class="form-group col-lg-3 col-sm-6">
                    <label for="exampleInputName2">Estado General de la Vivienda</label>
                    <select  class="form-control" v-model="cierre.estadoVivienda">
                        <option value="" disabled>Seleccione...</option>
                        <option v-for="estado in estadovivienda" :value="estado.id" >@{{ estado.estado_vivienda }}</option>
                    </select>
                </div>
            </div>
            <div class="row" style="text-align: right">
                <button type="submit"  class="btn btn-default " data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando..." id="btn-guardar">Guardar</button>
            </div>

        </form>


        <div class="row">
            <div class="col-md-12">
                <h3>Registro Fotografico de Diagnostico (Imagenes Subidas al Servidor)</h3>
                <label  v-if="images.length == 0">Ninguna Imagen Encontrada</label>
                <div style="position:relative; display: inline-block" v-for="img in images">
                    <img  :src="img.ruta"  >
                    <div style="position:absolute;right:6px;bottom:6px;">
                        <span  class="glyphicon glyphicon-remove btn-dlt" v-on:click="deleteImages(img)" title="Eliminar" aria-hidden="true"></span>
                    </div>
                </div>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" v-model="subirMas"> ¿Más imagenes?
                    </label>
                </div>
            </div>
            <div v-show="subirMas">
                <div class="col-md-12" >
                    <div class="col-md-12">
                        <input type="file" v-on:change="onFileChange" multiple class="form-control" accept="image/jpeg, image/png">
                    </div>

                </div>
                <div class="col-md-12" >
                    <h3>Imagenes a subir</h3>
                    <label  v-if="image.length == 0">Ninguna Imagen Seleccionada</label>
                    <div style="position:relative; display: inline-block" v-for="img in image">
                        <img  :src="img"  >
                        <div style="position:absolute;right:6px;bottom:6px;">
                            <span  class="glyphicon glyphicon-remove btn-dlt" v-on:click="deleteImage(img)" title="Eliminar" aria-hidden="true"></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-2" style="margin-top: 10px">
                    <button class="btn btn-default" @click="upload">Subir Imagenes</button>
                    <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                </div>
            </div>

        </div>
    </div>

</template>
<style scoped>
    img{
        max-height: 100px;
        padding: 5px;
        border-radius: 5px;
    }
    .btn-dlt{
        color: red;
        cursor: pointer;

    }
</style>
</template>