<template>
  <div>
    <button class="btn btn-primary pull-right" @click="importProfiles()" style="margin-right: 5px;"><i class="fa fa-users"></i> Import</button>
  </div>
</template>
<style scoped>
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
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    importProfiles(){
      $('#loading').css({display: 'block'})
      let parameter = {
        GOOGLE_URL: this.config.GOOGLE_URL
      }
      this.APIRequest('gsheets/auth', parameter).then(url => {
        $('#loading').css({display: 'none'})
        if(url.redirect !== null){
          window.location.href = url.redirect
        }
      })
    }
  }
}
</script>
