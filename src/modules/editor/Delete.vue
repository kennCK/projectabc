<template>
  <div id="deleteModal">
    <div class="modal fade" id="deleteTemplateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" v-if="id !== null">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Delete Confirmation</h5>
            <button type="button" class="close" @click="close()" aria-label="Close">
              <span aria-hidden="true" class="text-white">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <span class="text-center">
                Are you sure you want to delete this template?
            </span>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" @click="close()">No</button>
              <button type="button" class="btn btn-primary" @click="remove()">Yes</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.featured-image{
  width: 100%;
  float: left;
  height: 200px;
  margin-bottom: 10px;
}

.featured-image .options{
  width: 100%;
  float: left;
  text-align: center;
  height: 200px;
  border: solid 1px #ddd;
  overflow-y: hidden;
}
.options input{
  display: none;
}
.options:hover{
  cursor: pointer;
}
.options i{
  font-size: 40px;
  width: 100%;
  float: left;
  margin-top: 75px;
}

.options label{
  width: 100%;
  float: left;
}
.options img{
  width: 100%;
  float: left;
  height: auto;
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      id: null
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    remove(){
      let parameter = {
        id: this.id
      }
      this.APIRequest('templates/delete', parameter).then(response => {
        $('#deleteTemplateModal').modal('hide')
        this.$parent.retrieve(false)
      })
    },
    close(){
      this.item = null
      $('#deleteTemplateModal').modal('hide')
    }
  }
}
</script>
