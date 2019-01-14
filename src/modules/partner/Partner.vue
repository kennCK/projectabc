<template>
  <div class="partner" v-if="item !== null && item.account !== null && item.status === 'VERIFIED'">
    <div class="partner-container">
      <div class="partner-profile">
        <img :src="config.BACKEND_URL + item.account.profile.profile_url" v-if="item.account.profile !== null">
        <i class="fa fa-user-circle-o" v-else></i>
      </div>
      <div class="partner-info">
        <label><h5>{{item.account.billing.company}}</h5></label>
        <label><i class="fas fa-map-marker-alt"></i>{{item.account.billing.address}}</label>
        <label class="text-warning action-link" v-on:click="redirect('/messenger/' + item.username)"><i class="fas fa-envelope"></i>Send Message</label>
        <label class="text-danger action-link"><i class="fas fa-store"></i>View Store</label>
      </div>
      <div class="partner-reviews">
        <label class="reviews">
          <span class="badge badge-warning">4</span>
          <i class="fa fa-star-o text-primary" v-for="i in 5"></i>
        </label>
        <label>
          300 Reviews
        </label>
      </div>
    </div>

  </div>
</template>
<style scoped>
.partner{
  width: 100%;
  float: left;
  min-height: 100px;
  overflow-y: hidden;
  border-bottom: solid 1px #ddd;
  border-right: solid 1px #ddd;
  border-left: solid 1px #ddd;
}
.partner-container{
  margin-bottom: 10px;
  margin-top: 10px;
  width: 100%;
  float: left;
}
.partner-profile{
  width: 15%;
  float: left;
  text-align: center;
}
.partner-profile img{
  width: 100%;
  border-radius: 5px;
  float: left;
}
.partner-profile{
  font-size: 100px;
  float: left;
  line-height: 100px;
  padding-left: 10px;
}
.partner-info{
  width: 60%;
  float: left;
}
.partner-info label{
  width: 100%;
  float: left;
  line-height: 16px;
  padding-left: 10px;
}
.partner-info label i{
  padding-right: 10px;
}
.partner-reviews{
  width: 25%;
  float: left;
}
.partner-reviews label{
  width: 100%;
  float: left;
}
.reviews i{
  padding-right: 5px;
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      prevId: null
    }
  },
  props: ['item', 'index'],
  methods: {
    makeActive(){
      this.$parent.makeActive(this.index)
    },
    redirect(parameter){
      AUTH.redirect(parameter)
    }
  }
}
</script>
