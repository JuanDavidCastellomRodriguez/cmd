
<form class="form" v-if="agregandoInsumo" v-on:submit.prevent="agregarInsumo()" style="font-size: 12px">

    <div class="form-group col-lg-6">
        <label for="exampleInputEmail2">Insumo</label>
        <input type="text" class="form-control" v-model="nuevoInsumo.insumo"  required >
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail2">Cantidad</label>
        <input type="text" class="form-control" v-model="nuevoInsumo.cantidad" required >
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputName2">Frecuencia</label>
        <input type="number" class="form-control" v-model="nuevoInsumo.frecuencia" required>
    </div>
    <div class="form-group col-lg-2" style="margin-top: 24px; text-align: right ">

        <button type="submit"  class="btn btn-sm btn-success" >Agregar</button>
    </div>
    <div class="col-lg-12" style="text-align: right; margin-bottom: 5px;">
        <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
    </div>

</form>
