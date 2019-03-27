<template>
  <div id="updateProducts">
    <span v-if="errorMessage !== null" class="text-danger text-center">
        <label><b>Opps! </b>{{errorMessage}}</label>
    </span>
    <br v-if="errorMessage !== null">
    
    <div class="form-group">
      <label for="exampleInputEmail1">Prices</label>
      <div>
        <select class="form-control" style="width: 40%; float: left;" v-model="flag">
          <option value="fixed">Fixed</option>
          <option value="variable">Variable</option>
        </select>
      </div>
    </div>
    <br>
    <br>
    <div class="input-group" style="width:49.5%;" v-if="flag === 'fixed'">
      <label class="text-danger" v-if="errorMessage !== null">{{errorMessage}}</label>
      <span class="input-group-addon" id="addon-1">Price</span>
      <input type="text" class="form-control" placeholder="..." aria-describedby="addon-1" v-model="payload">
      <button class="btn btn-primary" style="margin-left: 5px;" @click="addGovernmentVariables()">Submit</button>
    </div>

    <div class="input-group" style="width:100%;" v-if="flag === 'variable'">
      <span class="input-group-addon" id="addon-1">Minimum</span>
      <input type="text" class="form-control" placeholder="..." aria-describedby="addon-1" v-model="payload" >
      <span class="input-group-addon" id="addon-1">Maximum</span>
      <input type="text" class="form-control" placeholder="..." aria-describedby="addon-1" v-model="payload" >
      <span class="input-group-addon" id="addon-1">Price</span>
      <input type="text" class="form-control" placeholder="..." aria-describedby="addon-1" v-model="payload" >
      <button class="btn btn-primary" style="margin-left: 5px;" @click="addGovernmentVariables()">Submit</button>
    </div>
  </div>
</template>
<style scoped>
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
  },
  props: ['product'],
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
<<<<<<< HEAD
      errorMessage: null,
      flag: null
=======
      errorMessage: null
>>>>>>> 1cc7796ebd2b874e40324c6ad33626a370c3d8f4
    }
  },
  props: ['item'],
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    }
  }
}
</script>
