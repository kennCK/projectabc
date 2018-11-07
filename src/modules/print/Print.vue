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
              <div class="holder" style="margin-right: 20px;">
                <item :objects="item.front_objects" v-if="item.front_objects !== null">
                </item>
                <div class="display">
                  <i class="fas fa-spinner fa-spin"></i>
                  <label>Printing...</label>
                </div>
              </div>

              <div class="holder">
                <item :objects="item.back_objects" v-if="item.back_objects !== null">
                </item>
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
    'item': require('modules/employee/Item.vue')
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
    }
  }
}
</script>
