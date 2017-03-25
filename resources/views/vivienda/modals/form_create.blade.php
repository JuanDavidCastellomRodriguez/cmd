<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-diagnostico"name="modal-agregar-diagnostico">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form" v-on:submit.prevent="guardarDiagnostico()" >
                <div class="modal-header">

                    <h4 class="modal-title">Visita de Diagnostico</h4>
                    <p>A continuación se procederá a crear una nueva visita de diagnostico, por favor tenga en cuenta que toda la información es requerida</p>
                </div>
                <div class="modal-body">
                    <div class="row">

                            <div class=" form-group col-lg-6 col-sm-12">
                                <label for="exampleInputName2">Fecha Encuesta</label>

                                    <input type="text" name="fecha_encuesta" id="fecha_encuesta" class="form-control" required v-model="nuevoDiagnostico.fechaEncuesta">


                            </div>

                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="exampleInputName2">No de familias viven en la vivienda</label>
                                <input type="number" required class="form-control" id="exampleInputName2" v-model.number="nuevoDiagnostico.numeroFamiliasVivienda">
                            </div>
                            <div class="form-group col-lg-6 col-sm-6">
                                <label for="exampleInputName2">¿Atiende el propietario de la vivienda?</label>
                                <div class="checkbox" >
                                    <label><input type="checkbox" v-model="nuevoDiagnostico.respondePropietario" name="propietario">Si</label>
                                </div>
                            </div>
                            <div class="form-group col-lg-6 col-sm-6">
                                <label for="exampleInputName2">¿Beneficiario de programa de Inversión Social?</label>
                                <div class="checkbox"  >
                                    <label><input type="checkbox" v-model="nuevoDiagnostico.programaSocial" name="programasocial">Si</label>
                                </div>
                            </div>



                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="resetForm()" >Cancelar</button>
                    <button type="submit"  class="btn btn-default " data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando..."   id="btn-guardar">Guardar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


