<template>
  <div class="modal" tabindex="-1" role="dialog" id="promptMessage" v-if="property !== null">
    <div class="modal-dialog" role="document" >
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{property.title}}</h5>
          <button type="button" class="close"  @click="hide()" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>{{property.message}}</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">{{property.btn.continue}}</button>
          <button type="button" class="btn btn-secondary" @click="hide()">{{property.btn.cancel}}</button>
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
export default {
  mounted () {
    $('#promptMessage').modal('show')
  },
  data () {
    return {
      //
    }
  },
  props: ['property'],
  methods: {
    hide(){
      $('#promptMessage').modal('hide')
    }
  }
}
</script>
