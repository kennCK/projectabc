<template>
  <div class="list-holder">
    <table class="table">
      <thead>
        <tr>
          <td>Title</td>
          <td>Settings</td>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item, index in data" v-if="data !== null">
          <td>{{item.title}}</td>
          <td>{{(item.settings === 'Front') ? 'Front Only' : 'Front and Back'}}</td>
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
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      data: null
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    retrieve(){
      let parameter = {
        condition: [{
          value: this.user.userID,
          column: 'account_id',
          clause: '='
        }]
      }
      this.APIRequest('templates/retrieve', parameter).then(response => {
        if(response.data.length > 0){
          this.data = response.data
        }else{
          this.data = null
        }
      })
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
.table{
  width: 100% !important;
}
</style>
