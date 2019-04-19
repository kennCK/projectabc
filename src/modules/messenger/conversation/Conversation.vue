<template>
  <div class="holder" id="groupConversation">
    <c-header :group="group" v-if="group !== null"></c-header>
    <c-body :conversations="auth.messenger.messages" v-if="group !== null"></c-body>
    <c-footer :group="group" v-if="group !== null"></c-footer>
  </div>
</template>
<style scoped>
.holder{
  width: 100%;
  float: left;
}
</style>
<script>
import ROUTER from '../../../router'
import AUTH from '../../../services/auth'
import CONFIG from '../../../config.js'
import axios from 'axios'
export default {
  mounted(){
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      auth: AUTH,
      id: null,
      newFlag: false
    }
  },
  components: {
    'c-header': require('modules/messenger/conversation/Header.vue'),
    'c-body': require('modules/messenger/conversation/Body.vue'),
    'c-footer': require('modules/messenger/conversation/Footer.vue')
  },
  props: ['groupId', 'group'],
  watch: {
    groupId: function(newVal, oldVal) { // watch it
      this.groupId = newVal
      this.retrieve()
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    retrieve(){
      if(this.groupId && this.group.new === false){
        let parameter = {
          condition: [{
            value: this.groupId,
            column: 'messenger_group_id',
            clause: '='
          }],
          sort: {
            'created_at': 'ASC'
          }
        }
        this.APIRequest('messenger_messages/retrieve', parameter).done(response => {
          if(response.data.length > 0){
            AUTH.messenger.messages = response.data
          }else{
            AUTH.messenger.messages = null
          }
        })
      }else{
        AUTH.messenger.messages = null
      }
    }
  }
}
</script>
