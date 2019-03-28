<template>
  <div id="printBadge">
    <div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" v-if="item !== null">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Printing</h5>
            <button type="button" class="close" @click="hideModal()" aria-label="Close">
              <span aria-hidden="true" class="text-white">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div v-bind:style="{height: (parseInt(item.templates.front.height)) + 'px', width: ((parseInt(item.templates.front.width) + 25) * 2)  + 'px'}" class="print-content">
              <div v-bind:style="{height: (parseInt(item.templates.front.height)) + 'px', width: (parseInt(item.templates.front.width))  + 'px'}" class="holder">
                <span id="frontObject">
                  <objects :objects="item.templates.front.objects" :key="item.id" v-if="item.templates.front !== null" :heightTemplate="parseInt(item.templates.front.height)" :widthTemplate="parseInt(item.templates.front.width)" :profile="item.profile"></objects>
                  <!-- <print-preview :objects="item.front_objects" :key="item.id" v-if="item.front_objects !== null" :heightTemplate="'100%'" :widthTemplate="'100%'"></print-preview> -->

                </span>
                
                <div v-bind:style="{height: (parseInt(item.templates.front.height)) + 'px', width: (parseInt(item.templates.front.width))  + 'px'}" class="display">
                  <i class="fas fa-spinner fa-spin"></i>
                  <label>Printing...</label>
                </div>
              </div>

              <div v-bind:style="{height: (parseInt(item.templates.front.height)) + 'px', width: (parseInt(item.templates.front.width))  + 'px'}" class="holder">
                <span id="backObject">
                  <objects :objects="item.templates.back.objects" v-if="item.templates.back.objects !== null" :heightTemplate="parseInt(item.templates.front.height)" :widthTemplate="parseInt(item.templates.front.width)" :profile="item.profile"></objects>
                </span>
                <div v-bind:style="{height: (parseInt(item.templates.front.height)) + 'px', width: (parseInt(item.templates.front.width))  + 'px'}" class="display">
                  <i class="fas fa-spinner fa-spin"></i>
                  <label>Printing...</label>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" @click="hideModal()">Cancel</button>
              <button type="button" class="btn btn-primary" @click="print()">Print</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.print-content{
  margin: auto;
}
.holder{
  position: relative;
  float: left;
}
.preview{
  position: absolute;
  width: 100%;
  float: left;
}
.division, .text, .photo{
  position: absolute;
}
.text, .photo{
  background: rgba(250, 250, 250, 0) !important;
}
.display{
  width: 100%;
  float: left;
  text-align: center;
  position: absolute;
  z-index: 3;
  top: 0;
  color: #fff;
  background: rgba(0, 0, 0, 0.7);
}
.display i{
  font-size: 50px;
  width: 100%;
  float: left;
  margin-top: 100px;
}
.display label{
  width: 100%;
  float: left;
  margin-top: 20px;
}

@page{
  margin: 0;
  size: auto;
}

@media print{
  @page{  
    margin: 0;
    size: auto;
  }
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
      config: CONFIG,
      errorMessage: null,
      item: null
    }
  },
  components: {
    'objects': require('modules/object/BadgeProfile.vue'),
    'print-preview': require('modules/object/PrintPreview.vue')
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    modal(){
      $('#printModal').modal('show')
    },
    hideModal(){
      this.item = null
      $('#printModal').modal('hide')
    },
    print(){
      // let Css = require('json-to-css')
      let printContents = document.getElementById('frontObject').innerHTML
      let originalContents = document.body.innerHTML
      document.body.innerHTML = printContents
      window.print()
      console.log(printContents)
      document.body.innerHTML = originalContents
      setTimeout(function() {
        location.reload()
      }, 100)
    }
  }
}
</script>
