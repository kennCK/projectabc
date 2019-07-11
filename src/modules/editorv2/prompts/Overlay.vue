<template>
  <div class="modal" tabindex="-1" role="dialog" id="promptMessage" v-if="global.prompts !== null">
    <div class="modal-dialog" role="document" >
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{global.prompts.title}}</h5>
          <button type="button" class="close"  @click="hide()" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>{{global.prompts.message}}</p>
        </div>
        <div class="modal-footer">
          
          <button type="button" class="btn btn-danger" @click="hide()">{{global.prompts.btn.no}}</button>
          <button type="button" class="btn btn-primary" @click="yes()">{{global.prompts.btn.yes}}</button>
        </div>
      </div>
    </div>
  </div>
</template>
<style lang="scss">
@import "~assets/style/colors.scss";
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
      if(GLOBAL.prompts.title === 'Unsave Template'){
        this.addTemplate()
      }
    },
    addTemplate(){
      let height = 300
      let width = 500
      GLOBAL.title = 'This is a test'
      GLOBAL.category = 'Tarpaulin'
      GLOBAL.status = 'personal'
      GLOBAL.purchased = null
      GLOBAL.contents = {
        style: {
          height: height + 'px',
          width: width + 'px',
          background: '#ffffff'
        },
        pages: [],
        plugins: [],
        selected_page: null,
        selected_plugin: null
      }
      GLOBAL.setting.page = {
        height: height,
        width: width
      }
      GLOBAL.setting.zoom = {
        height: height,
        width: width
      }
      this.hide()
    }
  }
}
</script>
