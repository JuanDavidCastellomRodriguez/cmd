<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-obra" name="modal-agregar-obra">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form" v-on:submit.prevent="guardarObra()" > 
                <div class="modal-header">

                    <h4 class="modal-title">Nueva infraestructura Comunitaria</h4>

                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class=" form-group col-lg-6 col-sm-12">
                            <label for="exampleInputName2">Fecha Aprobacion</label>
                            <input type="text"  id="fecha_aprobacion" class="form-control" required v-model="nuevaObra.fecha">
                        </div>
                        <div class=" form-group col-lg-6 col-sm-12">
                            <label for="exampleInputName2">Nombre de obra</label>
                            <input type="text"  id="nombre_obra" class="form-control" required v-model="nuevaObra.nombre_obra">
                        </div>
                        <div class=" form-group col-lg-6 col-sm-12">
                            <label for="exampleInputName2">Nombre de quien recibe</label>
                            <input type="text"  id="nombre_recibe" class="form-control" required v-model="nuevaObra.nombre_recibe">
                        </div>

                        <div class=" form-group col-lg-6 col-sm-12">
                            <label for="exampleInputName2">Identificación de quien recibe</label>
                            <input type="text"  id="identificacion_recibe" class="form-control" required v-model="nuevaObra.identificacion_recibe">
                        </div>

                        
                            <div class=" form-group col-lg-6 col-sm-12">
                                <label for="exampleInputName2">No. Orden</label>
                                <select class="form-control" v-model="nuevaObra.id_orden" required>
                                    <option value="" disabled >Seleccione...</option>
                                    <option v-for="orden in ordenes" :value="orden.id">@{{ orden.consecutivo  }}</option>
                                </select>
                                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                            </div>                         
                        
                            <div class=" form-group col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Municipio</label>
                                <select class="form-control" v-model="nuevaObra.municipio_id" v-on:change="getVeredas($event.target.value)" required>
                                    <option value="" disabled >Seleccione...</option>
                                    <option v-for="municipio in municipios" :value="municipio.id">@{{ municipio.municipio  }}</option>
                                </select>
                                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                            </div>                         
                        
                        
                            <div class=" form-group col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Vereda</label>
                                <select class="form-control" v-model="nuevaObra.vereda_id" required>
                                    <option value="" disabled >Seleccione...</option>
                                    <option v-for="vereda in veredas" :value="vereda.id">@{{ vereda.vereda  }}</option>
                                </select>
                                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                            </div>                         
                        
                        <div class="form-group col-lg-6 col-sm-12">
                            <label for="exampleInputName2">Valor de inversion (en Pesos)</label>
                            <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevaObra.valor">
                        </div>                      
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="exampleInputName2">Descripcion de obra</label>
                            <textarea  required class="form-control"  v-model.number="nuevaObra.descripcion"></textarea>
                        </div>
                        <div class="form-group has-feedback col-lg-6 col-sm-12 checkbox">
                            <label>
                                <input type="checkbox" v-model="registroFoto"> ¿Registro Fotografico?
                            </label>
                        </div>
                        <div class="row" style="margin-left: 5px; margin-bottom: 20px;" v-if="registroFoto">
                            <div class="col-md-12">
                                <h3>Registro Fotografico de la Infraestructura comunitaria</h3>
                                <label  v-if="images.length == 0">Ninguna Imagen Encontrada</label>
                                <div style="position:relative; display: inline-block" v-for="img in images">
                                    <img :src="img.ruta" style=" max-height: 120px; max-width: 120px;">
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
                            </div>    
                            <div class="col-md-12" >
                                <h3>Imagenes a subir</h3>
                                <label  v-if="image.length == 0">Ninguna Imagen Seleccionada</label>
                                <div style="position:relative; display: inline-block" v-for="img in image">
                                    <img  :src="img"  style=" max-height: 120px; max-width: 120px;">
                                    <div style="position:absolute;right:6px;bottom:6px;">
                                        <span  class="glyphicon glyphicon-remove btn-dlt" v-on:click="deleteImage(img)" title="Eliminar" aria-hidden="true"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> 

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="formReset()" >Cancelar</button>
                    <button type="submit"  class="btn btn-default " data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando..."   id="btn-guardar">Guardar</button>
                </div>
            </form>
            
                
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->