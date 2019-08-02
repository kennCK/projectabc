<template>
  <div>
    <div class="modal-body">
      <p>{{global.template.contents.prompts.message}}</p>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" @click="yes()">{{global.template.contents.prompts.btn.yes}}</button>
    </div>
  </div>
</template>
<style lang="scss" scoped>
@import "~assets/style/colors.scss";
.form-control{
  font-size: 11px !important;
}
</style>
<script>
import CONFIG from 'src/config.js'
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import GLOBAL from 'src/modules/editorv2/global.js'
export default {
  data () {
    return {
      global: GLOBAL
    }
  },
  methods: {
    hide(){
      $('#promptMessage').modal('hide')
    },
    yes(){
      if(GLOBAL.template.contents.prompts.title === 'Publish Request'){
        this.hide()
      }
    }
  }
}
</script>
