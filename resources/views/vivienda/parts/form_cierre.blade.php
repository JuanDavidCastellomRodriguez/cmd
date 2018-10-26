<template id="form-cierre">
    <div>
        <h2>Cierre</h2>



        <h4>Indicadores</h4>
        <form v-on:submit.prevent="guardarIndicadores" >
            <div class="row">
                <div class="form-group col-lg-3 col-sm-12">
                    <label  for="exampleInputName2">Numero de Habitaciones</label>
                    <input v-model="cierre.no_habitaciones" type="number" required class="form-control" id="exampleInputName2" >
                </div>
                <div class="form-group col-lg-3 col-sm-12">
                    <label  for="exampleInputName2">Numero de Persona en la vivienda</label>
                    <input v-model="cierre.no_personas_vivienda" type="number" required class="form-control" id="exampleInputName2" >
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
                        <label><input type="checkbox" v-model="cierre.saneamiento_basico"  name="propietario">Si</label>
                    </div>
                </div>
                <div class="form-group col-lg-3 col-sm-6">
                    <label for="exampleInputName2">¿Condiciones de seguridad, estrucutra y estetica?</label>
                    <div class="checkbox" >
                        <label><input type="checkbox" v-model="cierre.condiciones_seguridad"  name="propietario">Si</label>
                    </div>
                </div>
            </div>
            <h4>Zona de Riesgo</h4>
            <div class="row">
                <div class="form-group col-lg-3 col-sm-6 col-md-4" v-for=" riesgo in riesgos">
                    <div class="checkbox">
                        <label >
                            <input type="checkbox" :value="riesgo"  class="" v-model="cierre.zonas_riesgos">
                            @{{ riesgo }}
                        </label>
                    </div>
                </div>

                <div class="form-group col-lg-3 col-sm-3" v-if="cierre.zonas_riesgos != ''">
                    <label  for="exampleInputName2">Otro riesgo</label>
                    <input v-model="cierre.otro_riesgo" type="text" required class="form-control" id="exampleInputName2" >
                </div>
            </div>

            <div class="row">
                <h4>Infraestructura petrolera</h4>

                <div class="form-group col-lg-12 col-sm-12">
                    <label for="exampleInputName2">¿Infraestructura petrolera cercana al predio?</label>
                    <div class="checkbox" >
                        <label><input type="checkbox" v-model="cierre.infraestructura_cercana"  name="infraestructura_cercana">Si</label>
                    </div>
                </div>

        <div class="form-group col-lg-12 col-sm-12 col-md-12" v-if="cierre.infraestructura_cercana != ''">
              <label>Tipo de infraestructura petrolera</label>
              <div></div>
              <div class="form-group col-lg-3 col-sm-6 col-md-4" v-for=" tipo_infraestructura in tipos_infraestructuras">
                    <div class="checkbox">
                        <label >
                            <input type="checkbox" :value="tipo_infraestructura"  class="" v-model="cierre.tipos_infraestructuras">
                            @{{ tipo_infraestructura }}
                        </label>
                    </div>
               </div>
               <div class="form-group col-lg-3 col-sm-6 col-md-4">
                   <div class="checkbox">
                       <label>
                           <input type="checkbox" name="" :value="otra_infraestructura" v-model="cierre.otra_infraestructura">
                           Otra, ¿Cual?
                       </label>
                   </div>
               </div>
               <div class="form-group col-lg-3 col-sm-3" v-if="cierre.otra_infraestructura">
                    <label  for="exampleInputName2">Otra infraestructura</label>
                    <input v-model="cierre.cual_infraestructura" type="text" class="form-control" id="exampleInputName2" >
                </div>
        </div>

        <div class="form-group col-lg-12 col-sm-12 col-md-12" v-if="cierre.infraestructura_cercana != ''">
              <label>Tipo de riesgo de la infraestructura petrolera</label>
              <div></div>
              <div class="form-group col-lg-3 col-sm-6 col-md-4" v-for=" tipo_riesgo in tipos_riesgos">
                    <div class="checkbox">
                        <label >
                            <input type="checkbox" :value="tipo_riesgo"  class="" v-model="cierre.tipos_riesgos">
                            @{{ tipo_riesgo }}
                        </label>
                    </div>
               </div>
        </div>

                <div class="row">
                    <div class="form-group col-lg-5 col-sm-12" v-if="cierre.infraestructura_cercana != ''">
                        <label for="exampleInputName2">¿La infraestructura petrolera es propiedad de GeoPark?</label>
                        <div class="checkbox" >
                            <label><input type="checkbox" v-model="cierre.propiedad_geopark"  name="propiedad_geopark">Si</label>
                        </div>
                    </div>

                    <div class="form-group col-lg-2 col-sm-12">            
                        <label for="exampleInputName2">¿Caso Especial?</label>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" v-model="caso_especial">Si
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-lg-5 col-sm-3" v-if="caso_especial">
                        <label  for="exampleInputName2">¿Porque?</label>
                        <input  v-model="razon_especial" type="text" class="form-control" id="exampleInputName2" >
                    </div>
                </div>


                <div class="form-group col-lg-12 col-sm-12">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-datos-estado" style="margin-bottom: 15px;">
                            Consultar estado general de la vivienda
                            <span class="" aria-hidden="true"></span>
                        </button>
                </div>  



                <div class="form-group col-lg-12 col-sm-12">
                    <label for="exampleInputName2">Estado General de la Vivienda</label>
                    <select required="required"  class="form-control" v-model="cierre.estados_vivienda_id">
                        <option value="" disabled>Seleccione...</option>
                        <option v-for="estado in estadovivienda" :value="estado.id" >@{{ estado.estado_vivienda }}</option>
                    </select>
                </div>

                <div class="form-group col-lg-12 col-sm-12">
                    <label for="exampleInputName2">Obra proyectada</label>
                    <textarea class="form-control" id="exampleInputName2" v-model="cierre.obra_proyectada"></textarea>
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