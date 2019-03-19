<template>
  <div class="holder">
    <span class="header">Email</span>
    <span class="content">
      <span class="inputs">
        <div class="item" style="margin-top: 25px;">
          <span class="details">
            <label class="title">Login</label>
            <label class="definition">Send me an email everytime there's a login with my account.</label>
          </span>
          <span class="icon" v-if="data !== null">
            <i class="fa fa-toggle-on text-primary action-link" v-if="parseInt(data.email_login) === 1" @click="update(data.id, 'email_login', 0)"></i>
            <i class="fa fa-toggle-off text-danger action-link" v-if="parseInt(data.email_login) === 0" @click="update(data.id, 'email_login', 1)"></i>
          </span>
          <span class="icon" v-if="data === null">
            <i class="fa fa-toggle-off text-danger action-link" @click="create('email_login')"></i>
          </span>
        </div>
        <div class="item" style="margin-top: 25px;">
          <span class="details">
            <label class="title">One Time Password(OTP)</label>
            <label class="definition">Enable OTP everytime there's a login with my account.</label>
          </span>
           <span class="icon" v-if="data !== null">
            <i class="fa fa-toggle-on text-primary action-link" v-if="parseInt(data.email_otp) === 1" @click="update(data.id, 'email_otp', 0)"></i>
            <i class="fa fa-toggle-off text-danger action-link" v-if="parseInt(data.email_otp) === 0" @click="update(data.id, 'email_otp', 1)"></i>
          </span>
          <span class="icon" v-if="data === null">
            <i class="fa fa-toggle-off text-danger action-link" @click="create('email_otp')"></i>
          </span>
        </div>
      </span>
      <span class="sidebar">
      </span>
    </span>
  </div>
</template>
<style scoped>
.holder{
  width: 95%;
  float: left;
  margin-left: 5%;
}
.header{
  width: 100%;
  height: 50px;
  line-height: 50px;
  font-size: 24px;
  border-bottom: solid 1px #ddd;
  float: left;
}
.content{
  width: 100%;
  min-height: 50px;
  float: left;
  overflow-y: hidden;
}
.content .error{
  width: 100%;
  float: left;
  height: 40px;
  line-height: 40px;
}
.inputs{
  width: 65%;
  float: left;
  margin-right: 5%;
  min-height: 50px;
  overflow-y: hidden;
}
.sidebar{
  width: 30%;
  float: left;
  min-height: 50px;
  overflow-y: hidden;
}
.sidebar-header{
  height: 40px;
  line-height: 40px;
  width: 100%;
  float: left;
}
.sidebar .image{
  width: 100%;
  float: left;
  min-height: 200px;
  overflow-y: hidden;
  text-align: center;
}
.item{
  width: 100%;
  float: left;
  height: 50px;
}
.item .details{
  width: 80%;
  float: left;
  height: 50px;
}
.details label{
  width: 100%;
  float: left;
}
.details .definition{
  color: #555;
  font-size: 13px;
  line-height: 13px;
}
.item .icon{
  width: 20%;
  float: left;
  height: 50px;
  text-align: right;
  line-height: 50px;
}
.icon i{
  font-size: 35px;
}
@media screen and (max-width: 992px){
  .holder{
    width: 96%;
    margin-left: 2%;
    margin-right: 2%;
  }
  .sidebar, .inputs{
    width: 100%;
    margin-right: 0%;
    margin-left: 0%;
  }
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import axios from 'axios'
import CONFIG from '../../config.js'
export default {
  mounted(){
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      tokenData: AUTH.tokenData,
      config: CONFIG,
      data: null
    }
  },
  methods: {
    retrieve(){
      let parameter = {
        condition: [{
          value: this.user.userID,
          column: 'account_id',
          clause: '='
        }]
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('notification_settings/retrieve', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0){
          this.data = response.data[0]
        }else{
          this.data = null
        }
      })
    },
    create(type){
      let parameter = {
        account_id: this.user.userID,
        email_login: (type === 'email_login') ? 1 : 0,
        email_otp: (type === 'email_otp') ? 1 : 0,
        sms_login: (type === 'sms_login') ? 1 : 0,
        sms_otp: (type === 'sms_otp') ? 1 : 0
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('notification_settings/create', parameter).then(response => {
        this.retrieve()
      })
    },
    update(id, type, value){
      let parameter = null
      switch(type){
        case 'email_login': parameter = {
          id: id,
          email_login: value
        }
          break
        case 'email_otp': parameter = {
          id: id,
          email_otp: value
        }
          break
        case 'sms_login': parameter = {
          id: id,
          sms_login: value
        }
          break
        case 'sms_otp': parameter = {
          id: id,
          sms_otp: value
        }
          break
      }
      this.updateRequest(parameter)
    },
    updateRequest(parameter){
      $('#loading').css({display: 'block'})
      this.APIRequest('notification_settings/update', parameter).then(response => {
        this.retrieve()
      })
    }
  }
}
</script>
