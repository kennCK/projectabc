<template>
	<div class="holder">
    <div class="alert alert-success">
      Hi <b>{{user.username}}!</b> Invite your friends to ID Factory to get a month of free subscription based on your current plan. If you are currently on trial account you will get the <b>basic</b> subscription plan reward.
    </div>
    <div class="invitation">
      <div class="header text-primary">
        <b>Invite your friends to ID Factory</b>
      </div>
      <span class="alert alert-success" v-if="successMessage !== null">
        {{successMessage}}
      </span>
      <span class="alert alert-danger" v-if="errorMessage !== null">
        {{errorMessage}}
      </span>
      <div class="inputs">
        <input type="email" class="form-control" placeholder="Type email address here..." v-model="email">
        <textarea class="form-control" rows="10" placeholder="Type your message here..." v-model="message"></textarea>
        <button class="btn btn-primary btn-block" @click="send()">Send Invitation</button>
      </div>
    </div>
    <div class="results" v-if="data !== null">
      <table class="table table-bordered table-responsive" style="margin-top: 25px;">
        <thead>
          <tr>
            <td><b>Email</b></td>
            <td><b>Rewards</b></td>
            <td><b>Action</b></td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item, index in data" v-if="data !== null" class="item">
            <td>{{item.address}}</td>
            <td>
              <label v-if="item.status === 'confirmed' || item.status === 'used'">Free Subscription(Month)</label>
              <label v-else>Waiting</label>
            </td>
            <td>
              <button v-if="item.status === 'confirmed'" class="btn btn-primary" @click="apply(item)">Apply</button>
              <label v-if="item.status === 'used'" class="text-danger">Applied</label>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="results" v-if="data === null">
      <empty :title="'Looks like you do not have referrals!'" :action="'Invite your friends now to get a month of free subscription.'"></empty>
    </div>
	</div>
</template>
<style scoped>
	.holder{  
    width: 98%;
    float: left;
    margin-right: 2%;
	  margin-top: 25px;
	  margin-bottom: 50px;
	}
  .results{
    float: left;
    width: 68%;
  }
  .invitation{
    margin-right: 2%;
    float: left;
    width: 30%;
  }
  .item:hover{
    cursor: pointer;
  }
  .invitation .header{
    width: 100%;
    height: 50px;
    float: left;
    line-height: 50px;
    text-align: center;
    margin-top: 25px;
    border: solid 1px #ddd;
    margin-bottom: 10px;
  }
  .inputs input, .inputs textarea, .inputs button{
    margin-top: 10px !important;
  }
  .inputs button, .inputs input{
    height: 50px !important;
  }
  .alert{
    width: 100%;
    float: left;
  }
  @media (max-width: 992px){
    .holder, .results, .invitation{
      width: 100%;
      margin: 0%;
    }
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
      data: null,
      email: null,
      message: 'I\'d like to invite you on ID Factory. They help me ease on providing ID\'s to my employees and It\'s very easy to use. Register now!',
      successMessage: null,
      errorMessage: null
    }
  },
  components: {
    'empty': require('modules/empty/Empty.vue')
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
      $('#loading').css({display: 'block'})
      this.APIRequest('invitations/retrieve', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0){
          this.data = response.data
        }else{
          this.data = null
        }
      })
    },
    send(){
      if(AUTH.validateEmail(this.email) === true && this.message !== null){
        let parameter = {
          account_id: this.user.userID,
          to_email: this.email,
          content: this.message
        }
        $('#loading').css({display: 'block'})
        this.APIRequest('invitations/create', parameter).done(response => {
          if(response.data > 0 && response.data !== null){
            // success message here
            this.email = null
            this.message = 'I\'d like to invite you on ID Factory. They help me ease on providing ID\'s to my employees and It\'s very easy to use. Register now!'
            this.successMessage = 'Invitation Sent!'
            this.errorMessage = null
            this.retrieve()
          }else{
            // error message here
            this.successMessage = null
            this.errorMessage = response.error
            $('#loading').css({display: 'none'})
          }
        })
      }else{
        // error message here
        this.successMessage = null
        this.errorMessage = 'Invalid email address. Please check and try again!'
      }
    },
    apply(item){
      let parameter = {
        id: item.id,
        account_id: this.user.userID,
        status: 'used'
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('plans/apply_rewards', parameter).then(response => {
        this.retrieve()
        AUTH.checkAuthentication()
      })
    }
  }
}
</script>
