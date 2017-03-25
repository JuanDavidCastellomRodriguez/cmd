<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-persona"name="modal-agregar-persona">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form" data-toggle="validator" v-on:submit.prevent="guardarPersona()" >
                <div class="modal-header">

                    <h4 class="modal-title">Nueva Persona a Cargo</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Tipo</label>
                            <select v-model="nuevaPersona.id_tipo" class="form-control">
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="tipo in tiposPersonaCargo" :value="tipo.id">@{{ tipo.tipo_persona }}</option>
                            </select>
                        </div>
                        <div class=" form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Fecha Nacimiento</label>
                            <input type="text"  name="fecha_nacimiento_persona" id="fecha_nacimiento_persona" class="form-control" required v-model="nuevaPersona.fecha_nacimiento">
                        </div>

                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Nivel Educativo</label>
                            <select v-model="nuevaPersona.id_nivel_educativo" class="form-control">
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="nivel in niveles" :value="nivel.id" >@{{ nivel.nivel_educativo }}</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Genero</label>
                            <select v-model="nuevaPersona.id_genero" class="form-control">
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="genero in generos" :value="genero.id">@{{ genero.genero }}</option>
                            </select>
                        </div>


                        <div class="form-group col-lg-12 col-sm-12 col-md-12">
                            <label for="exampleInputName2">Observaciones</label>
                            <textarea type="text" required class="form-control" id="exampleInputName2" v-model="nuevaPersona.observaciones"></textarea>
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

<div class="modal fade" id="modal-confirm-delete-persona" tabindex="-1" role="dialog" aria-labelledby="modal-confirm-delete-persona">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Confirme</h4>
            </div>
            <div class="modal-body">
                <label for="">¿Esta seguro que desea quitar esta Persona a Cargo?</label>
            </div>
            <div class="modal-footer">
                <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-default" v-on:click="eliminarPersona()">Si</button>
            </div>
        </div>
    </div>
</div>


