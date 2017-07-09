<div class="modal fade" tabindex="-1" role="dialog" id="modal-agregar-mano-obra"name="modal-agregar-mano-obra">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form" data-toggle="validator" v-on:submit.prevent="guardarManoObra()" >
                <div class="modal-header">

                    <h4 class="modal-title">Nuevo Mes de Mano de Obra</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-4 col-sm-12 col-md-6 ">
                            <label for="exampleInputName2">Mes</label>
                            <select v-model="nuevaMano.id_mes" class="form-control" v-on:change="mesSelected($event.target[$event.target.selectedIndex].text)">
                                <option value="" disabled>Seleccione...</option>
                                <option v-for="mes in meses" :value="mes.id" >@{{mes.mes}}</option>

                            </select>
                        </div>
                        <div class="col-lg-12"></div>
                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Cantidad Jornal Vendido</label>
                            <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevaMano.jornal_vendido">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputName2">Actividad Jornal Vendio</label>
                            <textarea  required class="form-control" id="exampleInputName2" v-model="nuevaMano.actividad_jornal_vendido"></textarea>
                        </div>

                        <div class="form-group col-lg-4 col-sm-12 col-md-6">
                            <label for="exampleInputName2">Cantidad Jornal Comprado</label>
                            <input type="number" required class="form-control" id="exampleInputName2" v-model="nuevaMano.jornal_contratado">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputName2">Actividad Jornal Comprado</label>
                            <textarea  required class="form-control" id="exampleInputName2" v-model="nuevaMano.actividad_jornal_contratado"></textarea>
                        </div>




                    </div>
                </div>
                <div class="modal-footer">
                    <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                    <button type="button" class="btn btn-default" data-dismiss="modal"  v-on:click="formReset()" >Cancelar</button>
                    <button type="submit"  class="btn btn-default " data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando..."   id="btn-guardar">Agregar</button>

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal-confirm-delete-mano-obra" tabindex="-1" role="dialog" aria-labelledby="modal-confirm-delete-mano-obra">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Confirme</h4>
            </div>
            <div class="modal-body">
                <label for="">¿Esta seguro que desea quitar este Mes de Mano de Obra?</label>
            </div>
            <div class="modal-footer">
                    <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-default" v-on:click="eliminarMes()">Si</button>
            </div>
        </div>
    </div>
</div>


