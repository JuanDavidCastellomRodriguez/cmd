<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-beneficiario"name="modal-agregar-beneficiario">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form" data-toggle="validator" v-on:submit.prevent="guardarBeneficiario()" >
                <div class="modal-header">

                    <h4 class="modal-title">Nuevo Habitante</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-4 col-sm-12 col-md-6 ">
                            <label for="exampleInputName2">Documento de Identidad</label>
                            <div class="input-group">
                                <input type="text" class="form-control"  id="txt-buscar-beneficiario" v-model="nuevoBeneficiario.no_cedula">
                                <div class="input-group-addon">
                                    <a href="#" title="Buscar" v-on:click="buscarBeneficiario()" ><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Nombres</label>
                            <input type="text" required="required" class="form-control" id="exampleInputName2" v-model="nuevoBeneficiario.nombres">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Apellidos</label>
                            <input type="text" required="required" class="form-control" id="exampleInputName2" v-model="nuevoBeneficiario.apellidos">
                        </div>

                        <div class=" form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Fecha Nacimiento</label>
                            <input type="text" required="required" name="fecha_nacimiento-beneficiario" id="fecha_nacimiento-beneficiario" class="form-control datepickers" v-model="nuevoBeneficiario.fecha_nacimiento">
                        </div>

                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Celular</label>
                            <input type="text" required="required" class="form-control" id="exampleInputName2" v-model="nuevoBeneficiario.no_celular">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Correo Electronico</label>
                            <input type="text" class="form-control" id="exampleInputName2" v-model="nuevoBeneficiario.correo_electronico">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Estado Civil</label>
                            <select required="required" v-model="nuevoBeneficiario.id_estado_civil" class="form-control">
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="estado in estadosCiviles" :value="estado.id">@{{ estado.estado_civil }}</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Nivel Educativo</label>
                            <select required="required" v-model="nuevoBeneficiario.id_nivel_educativo" class="form-control">
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="nivel in niveles" :value="nivel.id" >@{{ nivel.nivel_educativo }}</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">                            
                            <label for="exampleInputName2">Actualmente, estudia</label>
                            <select required="required" v-model="nuevoBeneficiario.estudia" class="form-control">
                              <option disabled value="">Seleccione..</option>
                              <option id="si" value="si">Si</option>
                              <option id="no" value="no">No</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6" v-if="nuevoBeneficiario.estudia == 'si'">      
                            <label>¿Qué estudia actualmente?</label>
                            <input type="text" class="form-control" v-model="nuevoBeneficiario.descripcion_estudio">                         
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Tipo persona a cargo</label>
                            <select required="required" v-model="nuevoBeneficiario.id_tipo_persona_a_cargo" class="form-control">
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="tipo in tipo_personas" :value="tipo.id" >@{{ tipo.tipo_persona }}</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Genero</label>
                            <select required="required" v-model="nuevoBeneficiario.id_genero" class="form-control">
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="genero in generos" :value="genero.id">@{{ genero.genero }}</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Ocupacion</label>
                            <input type="text" required="required" class="form-control" id="exampleInputName2" v-model.number="nuevoBeneficiario.ocupacion">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Cabeza de Hogar</label>
                            <div class="checkbox"  >
                                <label><input required="required" type="checkbox" v-model="nuevoBeneficiario.cabeza_hogar">Si</label>
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Parentesco</label>
                            <select required="required" v-model="nuevoBeneficiario.id_parentesco" class="form-control">
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="parentesco in parentescos" :value="parentesco.id">@{{ parentesco.parentesco }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                    <button type="button" class="btn btn-default" data-dismiss="modal"  v-on:click="formReset()" >Cancelar</button>
                    <button type="submit"  class="btn btn-default " data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando..."   id="btn-guardar">Guardar</button>

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal-confirm-delete-beneficiario" tabindex="-1" role="dialog" aria-labelledby="modal-confirm-delete-beneficiario">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Confirme</h4>
            </div>
            <div class="modal-body">
                <label for="">¿Esta seguro que desea quitar este Habitante?</label>
            </div>
            <div class="modal-footer">
                    <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-default" v-on:click="eliminarBeneficiario()">Si</button>
            </div>
        </div>
    </div>
</div>


