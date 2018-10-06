<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-plan" name="modal-agregar-plan">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form" v-on:submit.prevent="guardarPlan()" enctype="multipart/form-data" files="true">
                <div class="modal-header">
                    <h4 class="modal-title">Nueva Plan de Desarrollo</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="modal-header col-lg-12" style="margin-left: 0; padding-left: 0">
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Nombre del Plan</label>
                                <input type="text" name="titulo_plan" id="titulo_plan" class="form-control" required v-model="nuevoPlan.titulo">
                            </div>
                            <div class="form-group col-lg-6 col-sm-12 ">
                                <label for="exampleInputName2">Fecha aprobacion</label>
                                <input type="text" name="fecha_aprobacion" id="fecha_aprobacion" class="form-control" required v-model="nuevoPlan.fecha">
                            </div>
                            <div class="form-group col-lg-12 modal-header" style="margin: 15px 0 0 0; padding: 0;">
                                <div class=" form-group col-lg-6 col-sm-12">
                                    <label for="exampleInputName2">Municipio</label>
                                    <select class="form-control" v-model="nuevoPlan.municipio_id" v-on:change="getVeredas($event.target.value)" required>
                                        <option value="" disabled >Seleccione...</option>
                                        <option v-for="municipio in municipios" :value="municipio.id">@{{ municipio.municipio  }}</option>
                                    </select>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                                </div>                         
                            </div>
                            <div class="form-group col-lg-12 modal-header" style="margin: 15px 0 0 0; padding: 0;">
                                <div class=" form-group col-lg-6 col-sm-12">
                                    <label for="exampleInputName2">Vereda</label>
                                    <select class="form-control" v-model="nuevoPlan.vereda_id" required>
                                        <option value="" disabled >Seleccione...</option>
                                        <option v-for="vereda in veredas" :value="vereda.id">@{{ vereda.vereda  }}</option>
                                    </select>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                                </div>                         
                            </div>                        
                        </div>
                    </div>
                        
                    <div class="row"> 

                        <div class="checkbox" style="margin-left: 17px;">
                            <label>
                                <input type="checkbox" v-model="subirMas"> ¿Subir archivos?
                            </label>
                        </div>
                        <div v-show="subirMas">
                            <div class="col-md-12" >
                                <div class="col-md-12">
                                    <input type="file" id="archivo" name="archivo" v-on:change="procesarFiles"  ref="files" multiple class="form-control" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf">    
                                </div>

                            </div>
                            <div class="col-md-12" >
                                <h3>Archivos a subir</h3>
                                <label  v-if="archivo.length == 0">Ningun archivo Seleccionado</label>
                                <div style="position:relative; display: inline-block;margin-right: 20px;" v-for="archi in archivo">
                                    <span class="glyphicon glyphicon-duplicate"></span>
                                    <div>
                                        <span  class="glyphicon glyphicon-remove btn-dlt" v-on:click="deleteFile(archi)" title="Eliminar" aria-hidden="true"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>            
                <div class="modal-footer">
                    <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="formReset()" >Cancelar</button>
                    <button type="submit"  class="btn btn-default "  id="btn-guardar">Guardar</button>
                </div>
            </form>
            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>