<template>
  <div id="printer">
    <div class="modal fade" id="printModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" v-if="objects !== null">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Printing</h5>
            <button type="button" class="close" @click="hideModal()" aria-label="Close">
              <span aria-hidden="true" class="text-white">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="print-content">
              <div class="holder">
                <div class="preview">
                  <span v-for="obj, innerIndex in objects" v-if="objects !== null">
                      <span class="division" v-if="obj.type === 'division'" v-bind:style="obj.attributes">
                      </span>
                      <label class="text" v-if="obj.type === 'text'" v-bind:style="obj.attributes">{{obj.content}}</label>
                      <img class="photo" :src="config.BACKEND_URL + obj.content" v-if="obj.type === 'photo'" :style="obj.attributes">
                  </span>
                </div>
                <div class="display">
                  <i class="fas fa-spinner fa-spin"></i>
                  <label>Printing...</label>
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" @click="hideModal()">Cancel</button>
              <button type="button" class="btn btn-primary">Print</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.print-content{
  width: 204px;
  height: 374px;
  margin: auto;
}
.holder{
  width: 204px;
  height: 374px;
  position: relative;
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
      item: null,
      objects: null
    }
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
      this.objects = null
      $('#printModal').modal('hide')
    }
  }
}
</script>
