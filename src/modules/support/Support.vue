<template>
  <div class="support-messenger">
    <div class="messenger-content" v-if="flag === true">
      <start  v-if="conversationStatus === 'start'"></start>
      <new-conversation v-if="conversationStatus === 'new-conversation'"></new-conversation>
      <conversation v-if="conversationStatus === 'conversation' && group !== null" :item="group"></conversation>
      <previous v-if="conversationStatus === 'previous'"></previous>
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
  height: 470px;
  width: 325px;
  border-radius: 10px;
  float: left;
  border: solid 1px #ddd;
  margin-bottom: 20px;
  background: #fff;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
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
      conversationStatus: 'start',
      group: null
    }
  },
  components: {
    'start': require('modules/support/Start.vue'),
    'previous': require('modules/support/Previous.vue'),
    'conversation': require('modules/support/Conversation.vue'),
    'new-conversation': require('modules/support/NewConversation.vue')
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    changeFlag(){
      this.flag = !this.flag
    }
  }
}
</script>
