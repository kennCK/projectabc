<template>
  <div v-if="item !== null">
    <div class="messenger-header">
      <label class="back-icon" @click="changeConversationStatus('start')"><i class="fa fa-chevron-left"></i></label>
      <div class="profile" v-if="item.last_message.account !== null">
        <img :src="config.BACKEND_URL + item.last_message.account.profile.profile_url" v-if="item.last_message.account.profile === null">
        <i class="fa fa-user-circle-o text-green" v-else></i>
      </div>
      <span class="details">
        <label><b>ID Factory</b></label>
        <label>Active</label>
      </span>
    </div>
    <div class="conversation-content">
        <div class="message-holder">
          <messages :groupId="item.id"></messages>
        </div>
        <div class="input-holder">
          <send :flag="false" :groupId="item.id" :payload="'previous'"></send>
        </div>
    </div>
  </div>
</template>
<style scoped>
.messenger-header{
  width: 100%;
  float: left;
  height: 70px;
  border-top-right-radius: 10px;
  border-top-left-radius: 10px;
  background-image: linear-gradient(to right, #fffff0, #22b173);
}
.messenger-header{
  line-height: 70px;
}
.back-icon{
  width: 40px;
  height: 40px;
  float: left;
  margin-top: 15px;
  text-align: center;
  margin-left: 2%;
  margin-right: 2%;
  line-height: 40px;
}
.back-icon:hover{
  border-radius: 5px;
  background: #22b173;
  cursor: pointer;
  color: #fff;
}
.messenger-header .profile{
  float: left;
  width: 40px;
  height: 40px;
  margin-right: 2%;
}
.messenger-header .profile img{
  height: 40px;
  width: 40px;
  z-index: 0;
  border-radius: 50%;
}
.messenger-header .profile i{
  line-height: 40px;
  font-size: 40px;
  margin-top: 15px;
}

.messenger-header .details{
  float: left;
  height: 40px;
  margin-top: 20px;
}
.messenger-header .details label{
  width: 100%;
  float: left;
  line-height: 12px;
}

.conversation-content{
  height: 400px;
  width: 100%;
  float: left;
  background: #fff;
}
.message-holder{
  height: 340px;
  overflow-y: auto;
  width: 100%;
  float: left;
  background: #fff;
}
.input-holder{
  height: 60px;
  width: 100%;
  float: left;
  background: #fff;
  border-top: solid 1px #ddd;
}

</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      data: null
    }
  },
  props: ['item'],
  components: {
    'send': require('modules/support/Send.vue'),
    'messages': require('modules/support/Messages.vue')
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    changeConversationStatus(status){
      this.$parent.conversationStatus = status
    },
    retrieve(){
      for (var i = 0; i < this.$children.length; i++) {
        if(this.$children[i].$el.id === 'messenger'){
          this.$children[i].retrieve()
        }
      }
    }
  }
}
</script>
