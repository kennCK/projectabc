<template>
  <div id="messenger">
    <div class="holder" v-if="data !== null">
      <div class="message-row" v-for="item, index in data">
        <div class="template" v-if="item.account_id !== user.userID">
          <div class="header">
            <div class="profile">
              <img :src="config.BACKEND_URL + item.account.profile.profile_url" v-if="item.account.profile === null">
              <i class="fa fa-user-circle-o text-green" v-else></i>
            </div>
            <span class="details" v-if="item.account !== null">
              <label><b>{{item.account.username}}</b> from ID Factory</label>
            </span>
          </div>
        <div class="content">
          <label>
            <label v-html="item.message"></label>
          </label>
        </div>
      </div>

      <div class="template">
        <div class="header-right">
          <div class="profile">
            <img :src="config.BACKEND_URL + item.account.profile.profile_url" v-if="item.account.profile === null">
            <i class="fa fa-user-circle-o text-green" v-else></i>
          </div>
          <span class="details" v-if="item.account !== null">
            <label><b>{{item.account.username}}</b></label>
          </span>
        </div>
        <div class="content">
          <label>
            <bdi>
              <label v-html="item.message"></label>
            </bdi>
          </label>
        </div>
      </div>
    </div>
  </div>
  </div>
</template>
<style scoped>
.holder{
  width: 90%;
  float: left;
  margin-left: 5%;
  margin-right: 5%;
  min-height: 50px;
  overflow-y: hidden;
}
.message-row, .template{
  width: 100%;
  min-height: 10px;
  overflow-y: hidden;
  margin-top: 10px;
}
.template .header{
  height: 40px;
  width: 100%;
  float: left;
}

.header .profile{
  float: left;
  width: 40px;
  height: 40px;
  margin-right: 2%;
}
.header .profile img{
  height: 30px;
  width: 30px;
  z-index: 0;
  border-radius: 50%;
}

.header .profile i{
  line-height: 30px;
  font-size: 30px;
}
.header .details{
  float: left;
  height: 40px;
}
.header .details label{
  width: 100%;
  float: left;
  color: #555;
  line-height: 12px;
  line-height: 30px;
}


.header-right .profile{
  float: right;
  width: 40px;
  height: 40px;
  margin-left: 2%;
  text-align: right;
}
.header-right .profile img{
  height: 30px;
  width: 30px;
  z-index: 0;
  border-radius: 50%;
}

.header-right .profile i{
  line-height: 30px;
  font-size: 30px;
}
.header-right .details{
  float: right;
  height: 40px;
}
.header-right .details label{
  width: 100%;
  float: right;
  color: #555;
  line-height: 12px;
  line-height: 30px;
}
.template .content{
  min-height: 10px;
  float: left;
  width: 100%;
  overflow-y: hidden;
  text-align: right;
}
.template .content label{
  line-height: 18px;
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
  props: ['groupId'],
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    retrieve(){
      if(this.groupId !== null){
        let parameter = {
          condition: [{
            column: 'messenger_group_id',
            value: this.groupId,
            clause: '='
          }]
        }
        this.APIRequest('messenger_messages/retrieve', parameter).then(response => {
          if(response.data.length > 0){
            this.data = response.data
          }else{
            this.data = null
          }
        })
      }
    },
    retrieveWithParams(id){
      if(id !== null){
        let parameter = {
          condition: [{
            column: 'messenger_group_id',
            value: id,
            clause: '='
          }]
        }
        this.APIRequest('messenger_messages/retrieve', parameter).then(response => {
          if(response.data.length > 0){
            this.data = response.data
          }else{
            this.data = null
          }
        })
      }
    }
  }
}
</script>
