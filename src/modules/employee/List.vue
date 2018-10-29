<template>
  <div class="list-holder">
    <table class="table">
      <thead>
        <tr>
          <td>Picture</td>
          <td>Name</td>
          <td>Picture</td>
          <td>Picture</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Picture</td>
          <td>Name</td>
          <td>Picture</td>
          <td>Picture</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null
    }
  },
  props: ['params'],
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    submit(){
      if(this.validate()){
      }
    },
    validate(){
    }
  }
}
</script>
<style scoped>
.list-holder{
  margin-top: 25px;
  width: 100%;
  float: left;
}
</style>
