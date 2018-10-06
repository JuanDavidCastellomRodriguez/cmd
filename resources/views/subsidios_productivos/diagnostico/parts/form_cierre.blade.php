<template id="form-cierre">
    <div>
        <h2>Cierre</h2>
        <form v-on:submit.prevent="guardarObs()" class="form">
            <div class="row">
                <div class="col-sm-12">
                    <label for="observaciones">Observaciones del proyecto que se pretende desarrollar</label>
                    <textarea class="form-control" rows="10" v-model="obs"></textarea>
                </div>
            </div>
            <div class="row" style="text-align: right; margin: 20px 3px 0 0">
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
        <div class="row"> 

            <div class="checkbox" style="margin-left: 20px;">
                <h3>Registro de Archivos del Beneficio</h3>
                <label>
                    <input type="checkbox" v-model="subirMasArchivos"> ¿Subir archivos?
                </label>
            </div>
            <div v-show="subirMasArchivos">
                <div class="col-md-12" >
                    <div class="col-md-12">
                        <input type="file" id="archivo" name="archivo" @change="procesarFiles"  ref="files" multiple class="form-control" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" style="margin-bottom: 10px;">    
                    </div>
                </div>
                <div class="col-md-2" style="margin-top: 10px">
                    <button class="btn btn-default" @click="subirArchivos">Subir Archivos</button>
                    <i v-show="loading" class="fa fa-spinner fa-spin"></i>
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