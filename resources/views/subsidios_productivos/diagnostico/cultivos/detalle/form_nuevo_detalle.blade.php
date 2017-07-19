
<form class="form" v-if="agregandoActividad" v-on:submit.prevent="agregarActividad()" style="font-size: 12px">

    <div class="form-group col-lg-2">
        <label for="exampleInputName2">Componente</label>
        <select  class="form-control" v-model="nuevoDetalle.id_componente_cultivo" required >
            <option value="" disabled>Seleccione...</option>
            <option v-for="componente in componentesCultivos" v-if="componente.id_etapa == 1 && nuevoDetalle.id_etapa == 1" :value="componente.id" >@{{ componente.componente }}</option>
            <option v-for="componente in componentesCultivos" v-if="componente.id_etapa == 2 && nuevoDetalle.id_etapa == 2" :value="componente.id" >@{{ componente.componente }}</option>
            <option v-for="componente in componentesCultivos" v-if="componente.id_etapa == 3 && nuevoDetalle.id_etapa == 3" :value="componente.id" >@{{ componente.componente }}</option>
        </select>
    </div>
    <div class="form-group col-lg-5">
        <label for="exampleInputEmail2">Actividades, Caracteristicas</label>
        <input type="text" class="form-control"  v-model="nuevoDetalle.actividades" required>
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputName2">Jornales</label>
        <input type="number" class="form-control" v-model="nuevoDetalle.mano_obra" required >
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail2">Freciencia</label>
        <input type="text" class="form-control" v-model="nuevoDetalle.frecuencia" required>
    </div>
    <div class="form-group" style="text-align: right">

        <button type="submit" style="margin-top: 24px;" class="btn btn-sm btn-success" >Agregar</button>
    </div>
    <div class="col-lg-12" style="text-align: right; margin-bottom: 5px;">
        <i  v-show="loading" class="fa fa-spinner fa-spin"></i>
    </div>

</form>
