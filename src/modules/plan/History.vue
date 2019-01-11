<template>
  <div class="template-holder">
    <h5>Plan History</h5>
    <br>
    <table class="table table-bordered table-responsive" v-if="data !== null">
      <thead>
        <tr>
          <td><b>Plan</b></td>
          <td><b>Start Date</b></td>
          <td><b>Expiry Date</b></td>
          <td><b>Price</b></td>
          <td><b># of Months</b></td>
          <td><b>Total</b></td>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item, index in data">
          <td>{{item.title}}</td>
          <td>{{item.start_human}}</td>
          <td>{{item.end_human}}</td>
          <td>{{item.price}}</td>
          <td>{{parseInt(item.total_amount) / parseInt(item.price)}}</td>
          <td>{{item.total_amount}}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<style scoped>
.template-holder{
  width: 98%;
  float: left;
  margin-bottom: 100px;
  margin-right: 2%;
}

.template-list{
  width: 100%;
  float: left;
  margin-top: 25px;
}
</style>
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
      data: null
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    retrieve(){
      let parameter = {
        account_id: this.user.userID
      }
      this.APIRequest('plans/retrieve', parameter).done(response => {
        if(response.data.length > 0){
          this.data = response.data
        }else{
          this.data = null
        }
      })
    }
  }
}
</script>
