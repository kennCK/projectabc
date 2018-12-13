<template>
  <div class="holder">
    <div class="header" v-if="user.type === 'PARTNER'">
      My Clients
      <i class="fa fa-pencil-square-o pull-right text-white create-new-group"></i>
    </div>
    <div class="header" v-if="user.type === 'USER'">
      Printing Partners
      <i class="fa fa-pencil-square-o pull-right text-white create-new-group"></i>
    </div>
    <m-card v-for="group, index in groups" :key="group.id" :group="group" :index="index"></m-card>
  </div>
</template>
<style scoped>
.holder{
  width: 100%;
  float: right;
}
.holder .header{
  width: 100%;
  float: left;
  height: 50px;
  line-height: 50px;
  padding-left: 10px;
  background: #22b173;
  color: #fff;
}
.create-new-group{
  line-height: 50px; 
  padding-right: 10px;
}
.create-new-group:hover{
  cursor: pointer;
  color: #eee;
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
      config: CONFIG
    }
  },
  props: ['groups'],
  components: {
    'm-card': require('modules/userlist/Card.vue'),
    'm-options': require('modules/userlist/OtherOptions.vue')
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    makeActive(selectedIndex){
      this.$parent.selectedGroup(selectedIndex)
    }
  }
}
</script>

