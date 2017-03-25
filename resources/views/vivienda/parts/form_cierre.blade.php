<template id="form-cierre">
    <div>
        <h2>Cierre</h2>
        <div class="row">
            <div class="col-md-12">
                <h3>Imagenes Subidas al Servidor</h3>
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