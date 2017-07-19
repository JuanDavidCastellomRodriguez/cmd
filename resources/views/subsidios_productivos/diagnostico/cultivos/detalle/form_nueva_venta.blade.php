<form class="form" v-if="agregandoVenta" v-on:submit.prevent="agregarVenta()" style="font-size: 12px">

    <div class="form-group col-lg-2">
        <label for="exampleInputName2">Mes</label>
        <select  class="form-control" v-model="nuevaVenta.id_mes" required >
            <option value="" disabled>Seleccione...</option>
            <option v-for="mes in meses"  :value="mes.id" >@{{ mes.mes }}</option>

        </select>
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail2">Cant. Venta</label>
        <input type="number" class="form-control"  v-model="nuevaVenta.cantidad_venta" required>
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputName2">Cant. Autoconsumo</label>
        <input type="number" class="form-control" v-model="nuevaVenta.cantidad_autoconsumo" required >
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail2">Cant. 1ª Calidad</label>
        <input type="number" class="form-control" v-model="nuevaVenta.cantidad_primera_calidad" required>
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail2">Cant. 2ª Calidad</label>
        <input type="number" class="form-control" v-model="nuevaVenta.cantidad_segunda_calidad" required>
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail2">Cant. 3ª Calidad</label>
        <input type="number" class="form-control" v-model="nuevaVenta.cantidad_tercera_calidad" required>
    </div>
    <div class="col-lg-8">
        <h5>Produccion Total: @{{ nuevaVenta.cantidad_venta + nuevaVenta.cantidad_autoconsumo }}</h5>
    </div>
    <div class="form-group col-lg-4" style="text-align: right">
        <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
        <button type="submit"  class="btn btn-sm btn-success" >Agregar</button>
    </div>



</form>