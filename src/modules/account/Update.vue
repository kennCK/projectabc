<template>
  <div class="update-holder">
    <div class="sidebar">
      <span class="header">
        Personal Settings
      </span>
      <span class="item" v-bind:class="{'make-active': item.type === activeType}" v-for="item, index in menu" v-if="menu !== null" @click="makeActive(item.type)">
        {{item.title}}
      </span>
    </div>
    <div class="content">
      <profile v-if="activeType === 'profile'"></profile>
      <account v-if="activeType === 'account'"></account>
      <payment v-if="activeType === 'payment_method'"></payment>
      <billing-information v-if="activeType === 'billing_information'"></billing-information>
      <merchant v-if="activeType === 'merchant'"></merchant>
      <notification v-if="activeType === 'notification'"></notification>
    </div>
  </div>

</template>
<style scoped>
.update-holder{
  width: 100%;
  float: left;
  margin-top: 25px;
}

.sidebar{
  width: 25%;
  float: left;
  border-top: solid 1px #ddd;
  border-right: solid 1px #ddd;
  border-left: solid 1px #ddd;
  border-top-right-radius: 2px;
  border-top-left-radius: 2px;
  min-height: 40px;
  overflow-y: hidden;
}
.sidebar .header{
  height: 40px;
  float: left;
  width: 100%;
  line-height: 40px;
  padding-left: 10px;
  border-bottom: solid 1px #ddd;
  background: #eee;
}
.sidebar .item{
  height: 40px;
  float: left;
  width: 100%;
  line-height: 40px;
  padding-left: 10px;
  border-bottom: solid 1px #ddd;
}
.item:hover{
  cursor: pointer;
  border-left: solid 2px #22b173 !important;
}
.make-active{
  border-left: solid 2px #22b173 !important;
}
.content{
  width: 75%;
  float: left;
  min-height: 50px;
  overflow-y: hidden;
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import axios from 'axios'
import CONFIG from '../../config.js'
export default {
  mounted(){
    AUTH.checkPlan()
    if(this.parameter !== null){
      let flag = false
      for (var i = 0; i < this.menu.length; i++) {
        if(this.parameter === this.menu[i].type){
          flag = true
          this.makeActive(i)
        }
      }
      if(flag === false){
        this.makeActive(0)
      }
    }else{
      this.makeActive(0)
    }
  },
  data(){
    return {
      user: AUTH.user,
      tokenData: AUTH.tokenData,
      config: CONFIG,
      menu: [
        {title: 'Profile', type: 'profile'},
        {title: 'Account', type: 'account'},
        {title: 'Payment Accounts', type: 'payment_method'},
        {title: 'Billing Information', type: 'billing_information'},
        {title: 'Merchant Setting', type: 'merchant'},
        {title: 'Notifications', type: 'notification'}
      ],
      activeType: 'profile',
      parameter: this.$route.params.parameter
    }
  },
  components: {
    'profile': require('modules/account/Profile.vue'),
    'account': require('modules/account/Account.vue'),
    'payment': require('modules/account/Payment.vue'),
    'billing-information': require('modules/account/BillingInformation.vue'),
    'merchant': require('modules/account/Merchant.vue'),
    'notification': require('modules/account/Notification.vue')
  },
  methods: {
    redirect(path){
      ROUTER.push(path)
    },
    makeActive(type){
      this.activeType = type
    }
  }
}
</script>
