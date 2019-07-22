<template>
  <div class="work-experience-holder">
    <span class="header">Work
      <button class="btn btn-primary pull-right" style="margin-right: 10px;" @click="showCreateModal()">Add</button>
    </span>
    <span class="content">
      <!-- Display Here -->
      <span class="display">
        <div class="rl-container-item" v-for="(item, index) in data" :key="index">
          <span class="header">
            <label> 
              {{ item.month_started }}
              {{ item.year_started }}
            </label>
            -
            <label v-if="item.month_ended && item.year_ended !== null">
              {{ item.month_ended }}
              {{ item.year_ended }}
            </label>
            <label v-else>
              Present
            </label>
            <label class="pull-right">
              <div class="dropdown" id="dropdownMenuButtonDropdown">
              <i class="fas fa-ellipsis-h text-gray more-options" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-target="dropdownMenuButtonDropdown">
              </i>
              <div class="dropdown-menu dropdown-more-options" aria-labelledby="dropdownMenuButton" >
                <span class="dropdown-item action-link" @click="showEdit(item)">Edit</span>
                <span class="dropdown-item action-link" @click="removeWork(item.id)">Remove</span>
              </div>
            </div>
            </label>
          </span>
          <span class="summary-header">
            <div style="line-height: 160%; vertical-align: middle;">
              <i class="fas fa-sitemap" style="font-size: 15px;"></i>
              <span style="position: relative; display: inline-block; left: 5px; font-size: 14px;">
                {{ item.position }}
              </span>
            </div>
            <div style="line-height: 160%; vertical-align: middle;">
              <i class="fas fa-landmark"></i>
              <span style="position: relative; display: inline-block; left: 5px; font-size: 14px;"> 
                {{ item.company_name }}
              </span>
            </div>
            <div style="line-height: 160%; vertical-align: middle;">
              <i class="fas fa-map-marker-alt" style="font-size: 21px;"></i>
              <span style="position: relative; display: inline-block; left: 5px; font-size: 14px;">
                {{ item.location }}
              </span>
            </div>
            <div style="line-height: 160%;">
                About Work:
              <div style="font-size: 14px;">
                <label v-if="item.work_description.length <= 800" >
                  {{ item.work_description }}
                </label>
                <label v-else>
                  <span v-if="item.flag === false"> {{ item.work_description.substring(0, 400)}} <strong class="text-danger" @click="item.flag = true"> >>> </strong></span>
                  <span v-if="item.flag === true"> {{ item.work_description }} <strong class="text-danger" @click="item.flag = false"> <<< </strong></span>
                </label>
              </div>
            </div>
          </span>
          <span class="footer" style="line-height: 160%;">
            <button class="btn btn-primary pull-left" style="margin-top: 5px;" @click="showAddImageCertificate(item.id)">Add image certificate</button>
          </span>
        </div>
      </span>
    </span>
    <browse-images-modal :object="user.profile" v-if="user.profile !== null"></browse-images-modal>
    <browse-images-modal :object="newWork" v-if="user.profile === null"></browse-images-modal>
    <create-modal :property="createWorkModal"></create-modal>
    <add-certificate></add-certificate>
  </div>
</template>
<style scoped>
.work-experience-holder{
  width: 95%;
  float: left;
  margin-left: 5%;
}
.header{
  width: 100%;
  height: 50px;
  line-height: 50px;
  font-size: 24px;
  border-bottom: solid 1px #ddd;
  float: left;
}
.content{
  width: 100%;
  min-height: 50px;
  float: left;
  overflow-y: hidden;
}
.display{
  width: 100%;
  float: left;
  margin-right: 5%;
  min-height: 50px;
  overflow-y: hidden;
}
.custom-block{
  width: 100%;
  float: left;
}
.custom-block input{
  display: none;
}
@media screen and (max-width: 992px){
  .holder{
    width: 96%;
    margin-left: 2%;
    margin-right: 2%;
  }
  .sidebar, .inputs{
    width: 100%;
    margin-right: 0%;
    margin-left: 0%;
  }
}
.rl-container-item{
  width: 100%;
  float: left;
  border-radius: 5px;
  min-height: 50px;
  overflow-y: hidden;
  border: solid 1px #ddd;
  margin-top: 10px;
  padding-left: 10px;
  padding-right: 10px;
}
.rl-container-item .header{
  width: 100%;
  float: left;
  height: 50px;
  line-height: 50px;
  color: #555;
}
.rl-container-item .summary-header{
  width: 100%;
  float: left;
  line-height: 25px;
  font-size: 17px;
  color: #555; 
}
.rl-container-item .footer{
  width: 100%;
  float: left;
  height: 45px;
  line-height: 40px;
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import axios from 'axios'
import CONFIG from '../../config.js'
import Work from '../modal/CreateWork.js'

export default {
  mounted(){
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      tokenData: AUTH.tokenData,
      config: CONFIG,
      data: null,
      createWorkModal: Work,
      showDescription: false,
      showDescriptionIndex: null,
      selectedWorkId: null
    }
  },
  components: {
    'browse-images-modal': require('components/increment/generic/image/BrowseModal.vue'),
    'create-modal': require('components/increment/generic/modal/Modal.vue'),
    'add-certificate': require('components/increment/generic/image/BrowseModal.vue')
  },
  methods: {
    setShowDescription(flag, index){
      if(index === this.showDescriptionIndex){
        this.showDescriptionIndex = null
        this.showDescription = false
      } else{
        this.showDescription = flag
        this.showDescriptionIndex = index
      }
    },
    retrieve(params){
      let parameter = {
        condition: [{
          value: this.user.userID,
          column: 'account_id',
          clause: '='
        }],
        sort: {
          year_ended: 'desc'
        }
      }
      this.APIRequest('works/retrieve', parameter).then(response => {
        if(response.data.length > 0){
          this.data = response.data
        }else{
          this.data = null
        }
      })
    },
    showCreateModal(){
      $('#createWorkModal').modal('show')
    },
    removeWork(id){
      let parameter = {
        id: id
      }
      this.APIRequest('works/delete', parameter).then(response => {
        this.retrieve()
      })
    },
    showImages(){
      $('#browseImagesModal').modal('show')
    },
    hideImages(){
      $('#browseImagesModal').modal('hide')
    },
    showAddImageCertificate(id){
      this.selectedWorkId = id
      $('#browseImagesModal').modal('show')
    },
    createCertificate(object){
      this.APIRequest('certificates/create', object).then(response => {
        if(response.data > 0){
          this.hideImages()
          AUTH.checkAuthentication()
        }
      })
    },
    manageImageUrl(url){
      let parameter = {
        account_id: this.user.userID,
        payload: 'work',
        payload_value: this.selectedWorkId,
        url: url
      }
      this.createCertificate(parameter)
    }
  }
}
</script>
