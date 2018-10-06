<template id="servicios-publicos">
  <div>
      <h3>Servicios Publicos</h3>
      <div class="col-lg-12 col-sm-6">
            <p v-if="bandera == 1"><strong>Nota.</strong>La informacion de servicios publicos fue tomada del <strong>Levantamiento de informacion Beneficio No @{{ infoVivienda.consecutivo }}</strong> del beneficiario <strong>@{{ nombre }} CC. @{{ documento }}.</strong>Por favor verifica la validez de esta informacion, y si es correcta Guarda, sino llena nuevamente los campos.</p>
        </div>
        <button v-if="bandera == 1" type="button" class="btn btn-default" @click="resetServicios()" style="margin-left: 86%;">
            Nuevo
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </button>
      <form v-on:submit.prevent="guardarServiciosPublicos()" class="form">
          <div class="form-group col-lg-6 col-sm-12 col-md-6">
              <label for="exampleInputName2">Fuente de Agua</label>
              <select required="required" v-model="servicios.id_fuente_agua" class="form-control">
                  <option value="" disabled>Seleccione...</option>
                  <option  v-for="fuente in fuenteAgua" :value="fuente.id" >@{{fuente.fuente_agua}}</option>

              </select>
          </div>
          <div class="form-group col-lg-6 col-sm-12 col-md-6">
              <label for="exampleInputName2">Sistema de Tratamiento de Agua</label>
              <div class="checkbox ">
                  <label >
                      <input type="checkbox"  class="" v-model="servicios.tratamiento_agua">
                      ¿Si?
                  </label>
              </div>
          </div>

          <div class="form-group col-lg-6 col-sm-12 col-md-6">
              <label for="exampleInputName2">Manejo de Aguas Residuales</label>
              <select required="required" v-model="servicios.id_sistemas_tratamiento_aguas" class="form-control">
                  <option value="" disabled>Seleccione...</option>
                  <option  v-for="agua in aguasResiduales" :value="agua.id" >@{{agua.sistema_eliminacion_aguas_grises}}</option>

              </select>
          </div>
          <div class="form-group col-lg-6 col-sm-12 col-md-6">
              <label for="exampleInputName2">Manejo Residuos Solidos</label>
              <select required="required" v-model="servicios.id_metodo_disposicion_basura" class="form-control">
                  <option value="" disabled>Seleccione...</option>
                  <option   v-for="residuo in residuosSolidos" :value="residuo.id" >@{{residuo.metodos_disposicion}}</option>

              </select>
          </div>
          <div class="form-group col-lg-6 col-sm-12 col-md-6">
              <label for="exampleInputName2">Gas</label>
              <select required="required" v-model="servicios.id_gas" class="form-control">
                  <option value="" disabled>Seleccione...</option>
                  <option   v-for="g in gas" :value="g.id" >@{{g.gas}}</option>

              </select>
          </div>
          <div class="form-group col-lg-6 col-sm-12 col-md-6">
              <label for="exampleInputName2">Electricidad</label>
              <select required="required" v-model="servicios.id_fuente_energia_electrica" class="form-control">
                  <option value="" disabled>Seleccione...</option>
                  <option   v-for="e in electricidad" :value="e.id" >@{{e.fuente_energia_electrica}}</option>

              </select>
          </div>
          <div class="form-group col-lg-12 col-sm-12 col-md-12">
              <label>Comunicaciones</label>
              <div></div>
              <div class="form-group col-lg-2 col-sm-4 col-md-3" v-for=" elemento in comunicaciones">
                  <div class="checkbox">
                      <label >
                          <input type="checkbox" :value="elemento.id"  class="" v-model="servicios.comunicaciones">
                          @{{ elemento.medio_comunicacion }}
                      </label>
                  </div>
              </div>
          </div>
          <div class="form-group col-lg-12 btns-forms">
              <button type="submit"  class="btn btn-default " data-loading-text="<i class='fa fa-spinner fa-spin '></i> Guardando..." id="btn-guardar">Guardar</button>

          </div>
      </form>
  </div>
</template>
