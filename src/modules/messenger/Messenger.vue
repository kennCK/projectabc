<template>
  <div class="messenger-holder">
    <div class="conversation">
      <conversation></conversation>   
    </div>
    <div class="users">
      <groups :groups="groups" :partners="partners" v-if="groups !== null || partners !== null"></groups>
    </div>
  </div>
</template>
<style scoped>
.messenger-holder{
  width: 100%;
  float: left;
}
.conversation{
  width: 70%;
  float: left;
  min-height: 500px;
  overflow-y:hidden;
}
.users{
  width: 28%;
  float: left;
  height: 80vh;
  margin-left: 2%; 
  overflow-y:hidden;
  border-left: solid 1px #22b173;
}
@media (max-width: 992px){
  .users{
    display: none;
  }
  .conversation{
    width: 100%;
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
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      newTitle: null,
      data: null,
      groups: null,
      partners: null,
      selectedIndex: 0
    }
  },
  props: ['params'],
  components: {
    'conversation': require('modules/conversation/Conversation.vue'),
    'groups': require('modules/userlist/Groups.vue')
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    create(){
      if(this.newTitle !== null || this.newTitle !== ''){
        let parameter = {
          'account_id': this.user.userID,
          'title': this.newTitle
        }
        this.APIRequest('messenger_groups/create', parameter).then(response => {
          console.log(response)
        })
      }
    },
    retrieve(){
      let parameter = {
        account_id: this.user.userID,
        account_type: this.user.type
      }
      this.APIRequest('messenger_groups/retrieve', parameter).then(response => {
        this.groups = response.data
        this.partners = response.accounts
      })
    },
    selectedGroup(index, moduleText){
      if(moduleText === 'groups'){
        for (var i = 0; i < this.$children.length; i++) {
          if(this.$children[i].$el.id === 'groupConversation'){
            this.$children[i].group = this.groups[index]
            this.$children[i].newFlag = false
            this.$children[i].retrieve()
          }
        }
      }else if(moduleText === 'partners'){
        for (i = 0; i < this.$children.length; i++) {
          if(this.$children[i].$el.id === 'groupConversation'){
            this.$children[i].newFlag = true
            this.$children[i].group = this.partners[index]
          }
        }
      }
    }
  }
}
</script>
