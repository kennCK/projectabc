<template>
  <div id="printer">
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
            <div class="print-content">
              <div class="holder" style="margin-right: 20px;" ref="printFrontObject">
                <objects :objects="item.front_objects" v-if="item.front_objects !== null" ref="objects">
                </objects>
                <div class="display">
                  <i class="fas fa-spinner fa-spin"></i>
                  <label>Printing...</label>
                </div>
              </div>

              <div class="holder">
                <objects :objects="item.back_objects" v-if="item.back_objects !== null">
                </objects>
                <div class="display">
                  <i class="fas fa-spinner fa-spin"></i>
                  <label>Printing...</label>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" @click="hideModal()">Cancel</button>
              <button type="button" class="btn btn-primary" @click="printID(item.front_objects)">Print</button>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.print-content{
  width: 428px;
  height: 374px;
  margin: auto;
}
.holder{
  width: 204px;
  height: 374px;
  position: relative;
  float: left;
}
.preview{
  height: 324px;
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
  height: 324px;
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
    'objects': require('modules/object/Objects.vue')
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
    printID(objects){
      let header = '<!DOCTYPE html><html><head>'
      let css = '<style>.preview{ height: 324px;position: absolute; width: 100%; float: left;}'
      css += ' .division, .text, .photo{ position: absolute;}'
      css += 'p{color: red;}'
      css += '.text, .photo{ background: rgba(250, 250, 250, 0) !important;}</style></head>'
      let body = '<body>'
      let objectPrint = this.generateObject(objects)
      let bodyEnd = '</body></html>'
      var win = window.open()
      self.focus()
      win.document.open()
      win.document.write(header + css + body + objectPrint + bodyEnd)
      win.document.close()
      win.print()
      win.close()
    },
    generateObject(objects){
      let response = '<span class="preview">'
      console.log(objects.length)
      for (var i = 0; i < objects.length; i++) {
        response += '<span>'
        let attributes = JSON.parse(objects[i].attributes)
        console.log(attributes)
        if(objects[i].type === 'division'){
          response += '<span class="division"' + 'style="' + attributes + '"></span>'
        }else if(objects[i].type === 'text'){
          response += '<label class="text"' + 'style="' + attributes + '">' + objects[i].content + '</label>'
        }else if(objects[i].type === 'photo'){
          response += '<img class="photo"' + 'src="' + this.config.BACKEND_URL + objects[i].content + '"' + 'style="' + attributes + '>'
        }
      }
      response += '</span>'
      return response
    }
  }
}
</script>
