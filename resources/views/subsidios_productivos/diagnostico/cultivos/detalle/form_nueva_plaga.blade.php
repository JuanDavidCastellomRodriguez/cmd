
<form class="form" v-if="agregandoPlaga" style="font-size: 12px" v-on:submit.prevent="agregarPlaga()">


    <div class="form-group col-lg-3">
        <label for="exampleInputName2">Plaga</label>
        <input type="text" class="form-control"  v-model="nuevaPlaga.tipo_plaga" required>
    </div>
    <div class="form-group col-lg-5">
        <label for="exampleInputEmail2">Caracteristicas Control</label>
        <input type="text" class="form-control"  v-model="nuevaPlaga.caracteristicas_control" required>
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail2">Freciencia</label>
        <input type="text" class="form-control" v-model="nuevaPlaga.frecuencia" required>
    </div>
    <div class="form-group" style="text-align: right">

        <button type="submit" style="margin-top: 24px;" class="btn btn-sm btn-success" >Agregar</button>
    </div>
    <div class="col-lg-12" style="text-align: right; margin-bottom: 5px;">
        <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
    </div>

</form>
