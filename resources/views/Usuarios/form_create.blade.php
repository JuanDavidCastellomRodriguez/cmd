<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-usuario" name="modal-agregar-usuario">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form" v-on:submit.prevent="createUser()" >
                <div class="modal-header">
                    <h4 class="modal-title">Nueva Usuario</h4>
                </div>
                <div class="modal-body">
                    <div class="row">                        
                        <div class=" form-group col-lg-6 col-sm-12">
                            <label for="exampleInputName2">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required v-model="newUser.nombre">
                        </div>
                        <div class=" form-group col-lg-6 col-sm-12">
                            <label for="exampleInputName2">Apellidos</label>
                            <input type="text" name="apellidos" id="apellidos" class="form-control" required v-model="newUser.apellidos">
                        </div>
                        <div class=" form-group col-lg-6 col-sm-12">
                            <label for="exampleInputName2">Correo electronico</label>
                            <input type="email" name="correo" id="correo" class="form-control" required v-model="newUser.correo">
                        </div>
                        <div class=" form-group col-lg-6 col-sm-12">
                            <label for="exampleInputName2">Tipo de Usuario</label>
                            <select class="form-control" v-model="newUser.tipo_rol" required>
                                <option value="" disabled>Seleccione..</option>
                                <option :value="1">Administrador</option>
                                <option :value="2">Vivienda</option>
                                <option :value="3">Productivos</option>
                                <option :value="4">Informes</option>
                            </select>
                            <span class="glyphicon form-control-feedback" aria-hidden="true" style="margin-right: 25px;"></span>
                        </div>
                        <div class=" form-group col-lg-6 col-sm-12">
                            <label for="exampleInputName2">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" required v-model="newUser.password">
                        </div>                                 
                    </div>
                </div>
                <div class="modal-footer">
                    <i  v-show="" class="fa fa-spinner fa-spin"></i>
                    <button type="button" class="btn btn-default" data-dismiss="modal" @click="formReset()" >Cancelar</button>
                    <button type="submit"  class="btn btn-default "  id="btn-guardar">Guardar</button>
                </div>                
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>