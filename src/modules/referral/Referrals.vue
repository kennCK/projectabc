<template>
	<div class="holder">
    <div class="invitation">
      <div class="header text-primary">
        <b>Invite your friends to ID Factory</b>
      </div>
      <div class="inputs">
        <input type="email" class="form-control" placeholder="Type email address here..." v-model="email">
        <textarea class="form-control" rows="10" placeholder="Type your message here..." v-model="message"></textarea>
        <button class="btn btn-primary" @click="send()">Send Invitation</button>
      </div>
    </div>
    <div class="results" v-if="data !== null">
      <table class="table table-bordered table-hover table-responsive" style="margin-top: 25px;">
        <thead>
          <tr>
            <td><b>Email</b></td>
            <td><b>Rewards</b></td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item, index in data" v-if="data !== null" class="item">
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
  .results, .invitation{
    width: 48%;
    float: left;
  }
  .results{
    margin-left: 2%;
  }
  .invitation{
    margin-right: 2%;
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

</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
    AUTH.checkPlan()
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      data: null,
      email: null,
      message: null
    }
  },
  components: {
    'empty': require('modules/empty/Empty.vue')
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    send(){
      if(AUTH.validateEmail(this.email) === true && this.message !== null){
        let parameter = {
          account_id: this.user.userID,
          to_email: this.email,
          content: this.message
        }
        this.APIRequest('emails/referral', parameter).done(response => {
          if(response.data === true){
            // success message here
          }else{
            // error message here
          }
        })
      }else{
        // error message here
      }
    }
  }
}
</script>
