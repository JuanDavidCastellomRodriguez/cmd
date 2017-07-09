<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-subsidio"name="modal-agregar-subsidio">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form" v-on:submit.prevent="guardarSubsidio()" >
                <div class="modal-header">

                    <h4 class="modal-title">Nuevo Subsidio</h4>
                </div>
                <div class="modal-body">
                    <div class="row">


                        <div class="modal-header col-lg-12" style="margin-left: 0; padding-left: 0">
                            <div class="form-group col-lg-6 col-sm-12 col-md-6 ">
                                <label for="exampleInputName2">Documento del Beneficiario</label>
                                <div class="input-group">
                                    <input type="text" required class="form-control"  id="txt-buscar-beneficiario" v-model="nuevoBeneficiario.no_cedula">
                                    <div class="input-group-addon">
                                        <a href="#" title="Buscar" v-on:click="buscarBeneficiario(nuevoBeneficiario.no_cedula)" ><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-6 col-sm-12" v-if="!esNuevoBeneficiario">
                                <label for="exampleInputName2">Datos</label>
                                <input type="text" required disabled class="form-control" id="exampleInputName2" v-model="beneficiario">
                            </div>
                            <div class="col-lg-12" style="margin: 0; padding: 0;" v-show="esNuevoBeneficiario">
                                <div class="form-group col-lg-6 col-sm-12 ">
                                    <label for="exampleInputName2">Nombres</label>
                                    <input type="text" required class="form-control" id="exampleInputName2" v-model="nuevoBeneficiario.nombres">
                                </div>
                                <div class="form-group col-lg-6 col-sm-12 ">
                                    <label for="exampleInputName2">Apellidos</label>
                                    <input type="text" required class="form-control" id="exampleInputName2" v-model="nuevoBeneficiario.apellidos">
                                </div>

                                <div class=" form-group col-lg-6 col-sm-12 ">
                                    <label for="exampleInputName2">Fecha Nacimiento</label>
                                    <input type="text"  name="fecha_nacimiento-beneficiario" id="fecha_nacimiento-beneficiario" class="form-control" required v-model="nuevoBeneficiario.fecha_nacimiento">
                                </div>

                                <div class="form-group col-lg-6 col-sm-12">
                                    <label for="exampleInputName2">Celular</label>
                                    <input type="text" required class="form-control" id="exampleInputName2" v-model="nuevoBeneficiario.no_celular">
                                </div>
                            </div>


                        </div>
                        <div class="col-lg-12" style="margin: 15px 0 0 0; padding: 0;">
                            <div class=" form-group col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Fecha Subsidio</label>
                                <input type="text" name="fecha_subsidio" id="fecha_subsidio" class="form-control" required v-model="nuevoSubsidio.fecha_inicio">
                            </div>


                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Valor Subsidio (en Pesos)</label>
                                <input type="number" required class="form-control" id="exampleInputName2" v-model.number="nuevoSubsidio.valor">
                            </div>
                            <div class="form-group has-feedback col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Departamento</label>
                                <select class="form-control" v-model="nuevoSubsidio.idDepartamento" v-on:change="changeDepartamento($event.target.value, '')" required>
                                    <option value="" disabled >Seleccione...</option>
                                    <option v-for="departamento in departamentos" :value="departamento.id">@{{ departamento.departamento  }}</option>
                                </select>
                                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                            </div>
                            <div class="form-group has-feedback col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Municipio</label>
                                <select class="form-control" v-model="nuevoSubsidio.idMunicipio" v-on:change="changeMunicipio($event.target.value, '')" required >
                                    <option value="" disabled >Seleccione...</option>
                                    <option v-for="municipio in municipios" :value="municipio.id">@{{ municipio.municipio }}</option>
                                </select>
                                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                            </div>
                            <div class="form-group has-feedback col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Vereda</label>
                                <select class="form-control" v-model="nuevoSubsidio.id_vereda" required>
                                    <option value="" disabled  >Seleccione...</option>
                                    <option v-for="vereda in veredas" :value="vereda.id">@{{ vereda.vereda  }}</option>
                                </select>
                                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                            </div>

                            <div class="form-group has-feedback col-lg-12 col-sm-12">
                                <label for="exampleInputName2">Observaciones</label>
                                <textarea v-model="nuevoSubsidio.observaciones" class="form-control"></textarea>
                                <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                            </div>
                        </div>




                    </div>
                </div>
                <div class="modal-footer">
                    <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="formReset()" >Cancelar</button>
                    <button type="submit"  class="btn btn-default "  id="btn-guardar">Crear Subsidio</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


