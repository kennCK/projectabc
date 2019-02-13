<template>
  <div class="support-messenger">
    <div class="messenger-content" v-if="flag === true">
      <div class="messenger-header" v-if="conversationStatus === 'start'">
        <div class="messenger-logo">
          <img src="../../assets/img/logo.png">
          <label><b>ID FACTORY</b></label>
        </div>
        <div class="messenger-info">
          <h3>Hi {{user.username}}!</h3>
          <p>
            Hello! What question do you have about ID Factory? We'd love to help you.
          </p>
        </div>
      </div>
      <div class="messenger-header" v-if="conversationStatus === 'new-conversation'">
        <div class="messenger-logo">
          <label><b>ID FACTORY</b></label>
        </div>
        <div class="messenger-info">
          <p>
            Hello! What question do you have about ID Factory? We'd love to help you.
          </p>
        </div>
      </div>
      <div class="conversation-start" v-if="conversationStatus === 'start'">
        <div class="start-header">
          <label class="title">Start a conversation</label>
          <label class="description">The team typically replies in a few minutes.</label>
        </div>
        <div class="start-images"></div>
        <div class="start-actions">
          <button class="btn btn-primary" @click="changeConversationStatus('new-conversation')"><i class="fa fa-send"></i> New Conversation</button>
          <label class="text-danger previous pull-right">See previous</label>
        </div>
      </div>
    </div>
    <span class="messenger-icon bg-primary"  @click="changeFlag()">
      <i class="fas fa-comment" v-if="flag === false"></i>
      <i class="fa fa-close" v-if="flag === true"></i>
    </span>
  </div>
</template>
<style scoped>
.support-messenger{
  min-width: 50px;
  min-height: 50px;
  overflow: hidden;
  position: fixed;
  bottom: 20px;
  right: 20px;
  max-width: 325px;
}
.messenger-icon{
  height: 60px;
  width: 60px;
  float: right;
  border-radius: 50%;
  text-align: center;
}
.messenger-icon i{
  font-size: 30px;
  line-height: 60px;
}
.messenger-content{
  height: 70vh;
  width: 325px;
  border-radius: 10px;
  float: left;
  border: solid 1px #ddd;
  margin-bottom: 20px;
  background: #fff;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
.messenger-header{
  width: 100%;
  float: left;
  height: 200px;
  background-image: linear-gradient(to bottom right, #ffffff, #22b173);
}
.messenger-header .messenger-logo{
  height: 50px;
  float: left;
  width: 90%;
  margin-right: 10%;
  margin-left: 10%;
  margin-top: 20px;
}
.messenger-logo img{
  width: 40px;
  height: 40px;
  float: left;
  margin-top: 5px;
}
.messenger-logo label{
  line-height: 40px;
  font-size: 24px;
  margin-top: 5px;
  color: #22b173;
}
.messenger-header .messenger-info{
  float: left;
  width: 80%;
  margin-right: 10%;
  margin-left: 10%;
  text-align: justify;
  padding-top: 15px;
}
.messenger-info h3{
  text-transform: capitalize;
  color: #000;
}

.conversation-start{
  height: 120px;
  margin-right: 5%;
  margin-left: 5%;
  width: 90%;
  float: left;
  background: #fff;
  margin-top: -25px;
  border-radius: 5px;
  border: solid 1px #ddd;
}
.start-header{
  height: 50px;
  width: 90%;
  margin-right: 5%;
  margin-left: 5%;
  margin-top: 10px;
}
.start-actions{
  height: 50px;
  width: 90%;
  margin-right: 5%;
  margin-left: 5%;
}
.start-header .title{
  font-size: 14px;
  line-height: 14px;
  width: 100%;
  float: left;
}
.start-header .description{
  line-height: 12px;
  width: 100%;
  float: left;
  color: #888;
}
.previous{
  line-height: 35px;
}
.previous:hover{
  text-decoration: underline;
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
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      data: null,
      flag: false,
      conversationStatus: 'start'
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    changeFlag(){
      this.flag = !this.flag
    },
    changeConversationStatus(status){
      this.conversationStatus = status
    }
  }
}
</script>
