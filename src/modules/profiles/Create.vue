<template>
  <div>
    <button class="btn btn-primary pull-right" @click="modal()"><i class="fa fa-user"></i> New</button>
    <button class="btn btn-primary pull-right" @click="modal()" style="margin-right: 5px;"><i class="fa fa-users"></i> Import</button>
    <div class="modal fade" id="createProfileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Add Profile</h5>
            <button type="button" class="close" @click="hideModal()" aria-label="Close">
              <span aria-hidden="true" class="text-white">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <span v-if="errorMessage !== null" class="text-danger text-center">
                <label><b>Opps! </b>{{errorMessage}}</label>
            </span>
            <br v-if="errorMessage !== null">       
            <span class="inputs" >

              <div class="form-group" style="margin-top: 25px;">
                <label for="address">Email Address</label>
                <input type="text" class="form-control" placeholder="Optional" v-model="data.email">
              </div>

              <div class="form-group" style="margin-top: 25px;">
                <label for="address">First Name</label>
                <input type="text" class="form-control" placeholder="Optional" v-model="data.first_name">
              </div>

              <div class="form-group">
                <label for="address">Middle Name</label>
                <input type="text" class="form-control" placeholder="Optional" v-model="data.middle_name">
              </div>

              <div class="form-group">
                <label for="address">Last Name</label>
                <input type="text" class="form-control" placeholder="Optional" v-model="data.last_name">
              </div>

              <div class="form-group">
                <label for="address">Gender</label>
                <select class="form-control" v-model="data.sex">
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                </select>
              </div>

              <div class="form-group">
                <label for="address">Contact Numbar</label>
                <input type="text" class="form-control" placeholder="Optional" v-model="data.contact_number">
              </div>

              <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" placeholder="Optional" v-model="data.address">
              </div>

              <div class="form-group">
                <label for="address">Birthdate</label>
                <input type="date" class="form-control" v-model="data.birthdate" placeholder="Optional">
              </div>

              <div class="form-group">
                <label for="address">Emergency Contact Person</label>
                <input type="text" class="form-control" v-model="data.emergency_contact_name" placeholder="Optional">
              </div>

              <div class="form-group">
                <label for="address">Emergency Contact Person's Number</label>
                <input type="text" class="form-control" v-model="data.emergency_contact_number" placeholder="Optional">
              </div>

              <div class="form-group">
                <label for="address">Variables</label>
                <div class="input-group">
                  <span class="input-group-addon" id="addon-1">Variable</span>
                  <input type="text" class="form-control" placeholder="*driver_license" aria-describedby="addon-1">
                  <span class="input-group-addon" id="addon-1">Value</span>
                  <input type="text" class="form-control" placeholder="Number" aria-describedby="addon-1">
                  <button class="btn btn-primary" style="margin-left: 5px;">Add</button>
                </div>
                
              </div>
          
            </span>
            <span class="sidebar">
              <span class="sidebar-header" style="margin-top: 25px;">Profile Picture</span>
              <span class="image" v-if="data.profile !== null">
                <img :src="config.BACKEND_URL + data.profile" height="auto" width="100%" >
              </span>
              <span class="image" v-else>
                <i class="fa fa-user-circle-o" ></i>
              </span>
              <button class="btn btn-primary custom-block" style="margin-top: 5px; margin-right: 1%;" @click="addImage()">Upload
                <input type="file" id="profilePicture" accept="image/*" @change="setupFile($event)">
              </button>

              <button class="btn btn-warning custom-block" style="margin-top: 5px; margin-left: 1%;" @click="addImage()">Select
                <input type="file" id="profilePicture" accept="image/*" @change="setupFile($event)">
              </button>

              <span class="sidebar-header" style="margin-top: 25px;">Signature</span>
              <span class="image" v-if="data.signature !== null">
                <img :src="config.BACKEND_URL + data.signature" height="auto" width="100%" >
              </span>
              <span class="image" v-else>
                <i class="fas fa-signature"></i>
              </span>
              <button class="btn btn-primary custom-block" style="margin-top: 5px; margin-right: 1%;" @click="addImage()">Upload
                <input type="file" id="profilePicture" accept="image/*" @change="setupFile($event)">
              </button>

              <button class="btn btn-warning custom-block" style="margin-top: 5px; margin-left: 1%;" @click="addImage()">Select
                <input type="file" id="profilePicture" accept="image/*" @change="setupFile($event)">
              </button>
            </span>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" @click="hideModal()">Close</button>
              <button type="button" class="btn btn-primary" @click="submit()">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>

.inputs{
  width: 65%;
  float: left;
  margin-right: 5%;
  min-height: 50px;
  overflow-y: hidden;
}
.form-group{
  margin-bottom: 0px !important;
}
.form-group label{
  margin-bottom: 0px !important;
}
.sidebar{
  width: 30%;
  float: left;
  min-height: 50px;
  overflow-y: hidden;
}
.sidebar-header{
  height: 40px;
  line-height: 40px;
  width: 100%;
  float: left;
}
.sidebar .image{
  width: 100%;
  float: left;
  min-height: 200px;
  overflow-y: hidden;
  text-align: center;
}
.image i{
  font-size: 150px;
  line-height: 200px;
}
.image img{
  border-radius: 5px;
}
.custom-block{
  width: 49%;
  float: left;
}
.custom-block input{
  display: none;
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
      data: {
        account_id: null,
        email: null,
        profile: null,
        employment_code: null,
        first_name: null,
        last_name: null,
        middle_name: null,
        sex: null,
        address: null,
        contact_number: null,
        birthdate: null,
        position: null,
        department: null,
        emergency_contact_name: null,
        emergency_contact_number: null,
        signature: null
      },
      file: null,
      government: []
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    modal(){
      $('#createProfileModal').modal('show')
    },
    hideModal(){
      $('#createProfileModal').modal('hide')
    },
    addImage(){
      $('#profilePicture')[0].click()
    },
    setupFile(event){
      let files = event.target.files || event.dataTransfer.files
      if(!files.length){
        return false
      }else{
        this.file = files[0]
        this.createFile(files[0])
      }
    },
    createFile(file){
      let fileReader = new FileReader()
      fileReader.readAsDataURL(event.target.files[0])
      this.upload()
    },
    upload(){
      let formData = new FormData()
      formData.append('file', this.file)
      formData.append('profile_url', this.file.name)
      formData.append('account_id', this.user.userID)
      $('#loading').css({display: 'block'})
      axios.post(this.config.BACKEND_URL + '/account_profiles/create', formData).then(response => {
        if(response.data.data > 0){
          AUTH.checkAuthentication(null)
          $('#loading').css({display: 'none'})
        }
      })
    },
    retrieve(){
      let parameter = {
        condition: [{
          value: this.user.userID,
          column: 'account_id',
          clause: '='
        }]
      }
      this.APIRequest('account_informations/retrieve', parameter).then(response => {
        if(response.data.length > 0){
          this.data = response.data[0]
        }else{
          this.data = null
        }
      })
    },
    update(){
      if(this.validate()){
        this.APIRequest('account_informations/update', this.data).then(response => {
          if(response.data === true){
            this.retrieve()
          }
        })
      }
    },
    validate(){
      let i = this.data
      if(i.first_name !== null && i.last_name !== null && i.sex !== null){
        return true
      }
      return false
    }
  }
}
</script>
