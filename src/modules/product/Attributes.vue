<template>
  <div id="updateProducts">
    <span v-if="errorMessage !== null" class="text-danger text-center">
        <label><b>Opps! </b>{{errorMessage}}</label>
    </span>
    <br v-if="errorMessage !== null">
    
    <div class="form-group">
      <label for="exampleInputEmail1">Attributes</label>
      <div>
        <select class="form-control" style="width: 40%; float: left;">
          <option value="color">Color</option>
          <option value="size">Size</option>
        </select>
        <button class="btn btn-primary" style="margin-left: 10px;"><i class="fa fa-plus"></i></button>
      </div>
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
  props: ['item'],
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      flag: null
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    }
  }
}
</script>
