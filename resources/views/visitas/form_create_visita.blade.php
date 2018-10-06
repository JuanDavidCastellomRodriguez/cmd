<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-visita"name="modal-agregar-visita">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form" v-on:submit.prevent="guardarVisita()" > 
                <div class="modal-header">

                    <h4 class="modal-title">Nueva Visita</h4>

                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class=" form-group col-lg-6 col-sm-12">
                            <label for="exampleInputName2">Fecha Visita</label>
                            <input type="text"  id="fecha_visita" class="form-control" required v-model="nuevaVisita.fecha">
                        </div>
                        <div class="form-group has-feedback col-lg-6 col-sm-12">
                            <label for="exampleInputName2">Tipo de Visita</label>
                            <select class="form-control" v-model="nuevaVisita.id_tipo_visita" required>
                                <option value="" disabled  >Seleccione...</option>
                                <option v-for="tipo in tipoDeVisitas" :value="tipo.id">@{{ tipo.tipo_visita }}</option>
                            </select>
                            <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                        </div>

                        <div class="form-group col-lg-6 col-sm-12" v-if="nuevaVisita.id_tipo_visita == 2">
                                <label for="exampleInputName2">Valor Subsidio (en Pesos)</label>
                                <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevaVisita.valor">
                            </div>
                        <div class="form-group col-lg-6 col-sm-12" v-if="nuevaVisita.id_tipo_visita == 2">
                            <label for="exampleInputName2">Aporte Beneficiario (en Pesos)</label>
                            <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevaVisita.valor_beneficiario">
                        </div>
                        <div class="form-group has-feedback col-lg-6 col-sm-12">
                            <label for="exampleInputName2">Porcentaje de Ejecucion</label>
                            <input class="form-control" type="text" id="exampleInputName2" required v-model.number="nuevaVisita.porcentaje_ejecucion">
                            <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;">%</span>
                        </div>
                        <div class="form-group has-feedback col-lg-6 col-sm-12">
                            <label for="exampleInputName2">Tipo de Mejoramientos</label>
                            <select class="form-control" v-model="nuevaVisita.id_tipo_mejoramiento" required>
                                <option value="" disabled  >Seleccione...</option>
                                <option v-for="tipo in tipoDeMejoras" :value="tipo.id">@{{ tipo.tipo_mejoramiento }}</option>
                            </select>
                            <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                        </div>
                        <div class="form-group has-feedback col-lg-6 col-sm-12" v-if="nuevaVisita.id_tipo_mejoramiento == 4">
                            <label for="exampleInputName2">¿Cual?</label>
                            <input class="form-control" type="text" id="exampleInputName2" v-model="nuevaVisita.otra_mejora">
                            <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                        </div> 
                        <div class="form-group has-feedback col-lg-6 col-sm-12 checkbox">
                            <label>
                                <input type="checkbox" v-model="registroFoto"> ¿Registro Fotografico?
                            </label>
                        </div>                       
                        <div class="form-group col-lg-12 col-sm-12">
                            <label for="exampleInputName2">Observaciones</label>
                            <textarea  required class="form-control"  v-model.number="nuevaVisita.observaciones"></textarea>
                        </div>
                    </div>
                </div>                                   
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="formReset()" >Cancelar</button>
                    <button type="submit"  class="btn btn-default " data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando..."   id="btn-guardar">Guardar</button>
                </div>
            </form>
            <div class="row" style="margin-left: 5px; margin-bottom: 20px;" v-if="registroFoto">
                        <div class="col-md-12">
                            <h3>Registro Fotografico de la Visita</h3>
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
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
