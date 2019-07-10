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
      let newTemplate = {
        title: 'This is a test',
        type: 'Tarpaulin',
        edit_flag: false,
        contents: {
          style: {
            height: '300px',
            width: '500px',
            background: '#ffffff'
          },
          pages: [],
          plugins: [],
          selected_page: null,
          selected_plugin: null
        },
        purpose: 0,
        status: 0
      }
      GLOBAL.addTemplate(newTemplate)
      this.hide()
    }
  }
}
</script>
