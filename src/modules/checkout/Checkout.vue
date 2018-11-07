<template>
  <div class="holder">
    <span class="preview" v-if="item !== null">
      
    </span>
  </div>
</template>
<style scoped>
.holder{
  width: 100%;
  float: left;
  margin-top: 50px;
}
.list{
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
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null
    }
  },
  components: {
    'objects': require('modules/object/Objects.vue')
  },
  props: ['item'],
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    }
  }
}
</script>

