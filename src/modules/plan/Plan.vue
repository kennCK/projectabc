<template>
  <div class="template-holder">
    <div class="template-list">
      <item></item>
    </div>
  </div>
</template>
<style scoped>
.template-holder{
  width: 98%;
  float: left;
  margin-right: 2%;
}

.template-list{
  width: 100%;
  float: left;
  margin-top: 25px;
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
      errorMessage: null,
      data: null,
      prevIndex: null
    }
  },
  components: {
    'item': require('modules/plan/Item.vue')
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    }
  }
}
</script>

