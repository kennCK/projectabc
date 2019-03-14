<template>
	<div class="list-holder">
    <div class="alert alert-success">
      Hi <b>{{user.username}}!</b> Welcome to our import profiles. This will allow you to quickly sync or upload multiple profile.
    </div>
    <div class="item" v-if="data !== null">
      <div class="file" @click="open(data.sheet)">
        <i class="far fa-file-excel text-green"></i>
        <label>{{data.sheet}}</label>
      </div>
    </div>
    <div class="item" v-if="data !== null">
      or
    </div>
    <div class="item">
      <button class="btn btn-primary custom-button" @click="createNewGSheet()">Create New Google Sheet</button>
    </div>
    <div class="item">
      <button class="btn btn-primary" v-if="data !== null">Sync</button>
    </div>
	</div>
</template>
<style scoped>
.list-holder{
  width: 98%;
  float: left;
  margin-right: 2%;
  margin-top: 25px;
}
.item{
  width: 100%;
  float: left;
  margin-bottom: 10px;
}
.file{
  height: 200px;
  width: 175px;
  float: left;
  text-align: center;
  border: solid 1px #ddd;
}
.file i{
  font-size: 75px;
  line-height: 170px;
  width: 100%;
  float: left;
}
.file label{
  float: left;
  text-align: center;
  width: 100%;
}
.file:hover, .file label:hover{
  cursor: pointer;
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
    AUTH.checkPlan()
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
  components: {
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
      this.APIRequest('account_gsheets/retrieve', parameter).then(response => {
        if(response.data.length > 0){
          this.data = response.data[0]
        }else{
          this.data = null
        }
      })
    },
    createNewGSheet(){
      let parameter = {
        code: AUTH.google.code,
        scope: AUTH.google.scope,
        account_id: this.user.userID
      }
      // $('#loading').css({display: 'block'})
      this.APIRequest('gsheets/create_file', parameter).then(response => {
        // $('#loading').css({display: 'none'})
      })
    },
    open(id){
      let url = 'https://docs.google.com/spreadsheets/d/' + id
      window.open(url, '_blank')
    }
  }
}
</script>
