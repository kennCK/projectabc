<template>
  <div id="editProfile">
    <div class="modal fade" id="editEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" v-if="data !== null">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Edit Employee</h5>
            <button type="button" class="close" @click="hideModal()" aria-label="Close">
              <span aria-hidden="true" class="text-white">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <span v-if="errorMessage !== null" class="text-danger text-center">
                <label><b>Opps! </b>{{errorMessage}}</label>
            </span>
            <br v-if="errorMessage !== null">
            <br>
            <div class="form-group">
              <label for="exampleInputEmail1">Front Template</label>
              <select v-model="data.front_template" class="form-control">
                <option v-for="item, index in templates" v-if="templates !== null && item.settings === 'front'" v-bind:value="item.id">{{item.title}}</option>
              </select>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Back Template</label>
              <select v-model="data.back_template" class="form-control">
                <option v-for="item, index in templates" v-if="templates !== null && item.settings === 'back'" v-bind:value="item.id">{{item.title}}</option>
              </select>
            </div>

            <div class="form-group">
              <button class="btn btn-primary" @click="addNewColumn()"><i class="fa fa-plus"></i> New Column</button>
            </div>

            <div v-for="item, index in data.columns" v-if="data.columns !== null">
              <div class="input-group">
<!--                 <span class="input-group-addon">Type</span>
                <select v-model="item.type" class="form-control" style="width: 0px !important;">
                  <option value="text">Text</option>
                  <option value="photo">Image</option>
                </select> -->

                <span class="input-group-addon">Name</span>
                <input type="text" class="form-control" placeholder="*first_name" v-model="item.column" disabled v-if="item.new === false">
                <input type="text" class="form-control" placeholder="*first_name" v-model="item.column" v-if="item.new === true">

                <span class="input-group-addon">Value</span>

                <span v-if="item.type === 'photo'" class="form-control upload-image" @click="addImage('image' + index, index)">
                  <label>Click to add image</label>
                  <input type="file" class="form-control" v-bind:id="'image' + index" @change="setUpFileUpload($event)" accept="image/*">
                </span>
                
                <input type="text" class="form-control" placeholder="Type value here..." v-model="item.value" v-if="item.type !== 'photo'">
                
                <button class="btn btn-danger" style="margin-top: 5px; margin-left: 5px;" @click="removeColumn(index)" v-if="item.new === true"><i class="fa fa-trash"></i></button>
              </div>
              <div class="input-group preview" v-if="item.type === 'photo' && item.value !== null">
                <img :src="config.BACKEND_URL + item.value" height="100%">
              </div>        
            </div>

          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" @click="hideModal()">Close</button>
              <button type="button" class="btn btn-primary" @click="update()">Update</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>

.form-control{
  height: 45px !important;
}
.input-group{
  margin-bottom: 10px !important;
}
.input-group-addon{
  width: 100px !important;
  background: #22b173 !important;
  color: #fff !important;
}
.upload-image{
  height: 45px;
}
.upload-image:hover{
  cursor: pointer;
}
.upload-image input{
  display: none;
}
.preview{
  height: 100px;
  width: 100%;
  float: left;
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
      templates: null,
      data: null,
      file: null,
      fileIndex: null,
      id: null
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    modal(){
      this.retrieve()
    },
    hideModal(){
      this.data = null
      $('#editEmployeeModal').modal('hide')
      this.$parent.retrieve()
    },
    retrieve(){
      let parameter = {
        condition: [{
          value: this.id,
          column: 'id',
          clause: '='
        }]
      }
      this.APIRequest('employees/retrieve_on_update', parameter).done(response => {
        if(response.data.length > 0){
          this.data = response.data[0]
        }else{
          this.data = null
        }
        this.retrieveTemplates()
      })
    },
    retrieveTemplates(){
      let parameter = {
        condition: [{
          value: this.user.userID,
          column: 'account_id',
          clause: '='
        }]
      }
      this.APIRequest('templates/retrieve_templates_only', parameter).then(response => {
        if(response.data.length > 0){
          this.templates = response.data
          $('#editEmployeeModal').modal({
            backdrop: 'static',
            show: true,
            keyboard: false
          })
        }
      })
    },
    addNewColumn(){
      let object = {
        employee_id: null,
        type: 'text',
        column: null,
        value: null,
        new: true
      }
      if(this.data.columns === null){
        this.data.columns = []
      }else{
        //
      }
      this.data.columns.push(object)
    },
    removeColumn(index){
      this.data.columns.splice(index, 1)
    },
    addImage(id, index){
      $('#' + id)[0].click()
      this.fileIndex = index
    },
    createFile(file){
      let fileReader = new FileReader()
      fileReader.readAsDataURL(event.target.files[0])
      this.upload()
    },
    setUpFileUpload(event){
      let files = event.target.files || event.dataTransfer.files
      if(!files.length){
        return false
      }else{
        this.file = files[0]
        this.createFile(files[0])
      }
    },
    upload(){
      let formData = new FormData()
      formData.append('file', this.file)
      formData.append('file_url', this.file.name)
      formData.append('account_id', this.user.userID)
      $('#loading').css({'display': 'block'})
      axios.post(this.config.BACKEND_URL + '/employees/upload', formData).then(response => {
        $('#loading').css({'display': 'none'})
        if(response.data !== null){
          this.data.columns[this.fileIndex].value = response.data.data
          this.fileIndex = null
        }
      })
    },
    update(){
      if(this.validateColumns()){
        $('#loading').css({'display': 'block'})
        let parameter = {
          'employee': this.data
        }
        this.APIRequest('employees/update_by_profile', parameter).then(response => {
          $('#loading').css({'display': 'none'})
          this.hideModal()
        })
      }
    },
    validateColumns(){
      return true
    }
  }
}
</script>
