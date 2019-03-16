<template>
	<div class="list-holder">
    <div class="alert alert-success">
      Hi <b>{{user.username}}!</b> Welcome to our import profiles. This will allow you to quickly sync or upload multiple profile.
    </div>
    <div class="alert alert-danger" v-if="errorMessage !== null"><b>Opps! </b>{{errorMessage}}</div>
    <div class="item" v-if="data !== null">
      <div class="file bordered-hover-primary" @click="open(data.sheet)">
        <i class="far fa-file-excel text-green"></i>
        <label>{{data.title}}</label>
      </div>
    </div>
    <div class="item" v-if="data !== null">
      or
    </div>
    <div class="item">
      <button class="btn btn-primary custom-button" @click="createNewGSheet()">Create New Google Sheet</button>
    </div>
    <div class="item">
      <button class="btn btn-primary" v-if="data !== null" @click="sync(data.sheet)">Sync</button>
    </div>
    <div class="item" style="margin-bottom: 100px;" v-if="profiles !== null">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td>Email</td>
              <td>Last Name</td>
              <td>First Name</td>
              <td>Status</td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item, index in profiles" v-bind:class="{'bg-danger text-white': item.status !== 'created' && item.status !== 'updated'}">
              <td>{{item.email}}</td>
              <td style="text-transform: capitalize">{{item.last_name}}</td>
              <td style="text-transform: capitalize">{{item.first_name}}</td>
              <td v-bind:class="{'text-primary': item.status === 'created', 'text-danger': item.status === 'updated'}" style="text-transform: capitalize">{{item.status}}</td>
            </tr>
          </tbody>
        </table>
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
      google: AUTH.google,
      errorMessage: null,
      data: null,
      profiles: null,
      profileHeader: null
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
        this.errorMessage = response.error
      })
    },
    open(id){
      let url = 'https://docs.google.com/spreadsheets/d/' + id
      window.open(url, '_blank')
    },
    sync(id){
      let parameter = {
        code: AUTH.google.code,
        scope: AUTH.google.scope,
        sheet: id,
        account_id: this.user.userID
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('gsheets/read_file', parameter).then(response => {
        $('#loading').css({display: 'none'})
        this.profileHeader = response.dataHeader
        this.profiles = response.data
        this.errorMessage = response.error
        if(response.error !== null){
          setTimeout(() => {
            this.auth()
          }, 2000)
        }
      })
    },
    auth(){
      $('#loading').css({display: 'block'})
      let parameter = {
        GOOGLE_URL: this.config.GOOGLE_URL
      }
      this.APIRequest('gsheets/auth', parameter).then(url => {
        $('#loading').css({display: 'none'})
        if(url.redirect !== null){
          window.location.href = url.redirect
        }
      })
    }
  }
}
</script>
