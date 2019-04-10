<template>
  <div>
    <button class="btn btn-primary custom-block" style="margin-top: 5px; margin-right: 1%;" @click="addImage(status)">Upload
      <input type="file" id="Image" accept="image/*" @change="setUpFileUpload($event)">
    </button>

    <button class="btn btn-warning custom-block" style="margin-top: 5px; margin-left: 1%;" @click="showImages()">Select
    </button>
    <browse-images-modal :object="newImage"></browse-images-modal>
  </div>
</template>
<style scoped>
.custom-block{
  width: 49%;
  float: left;
}
.custom-block input{
  display: none;
}
.browse-images-holder {
  float:left;
}
.browse-images{
  width: 200px;
  height: 300px;
  position: absolute;
  border: solid 1px #ddd;
  background: #fff;
  margin-left: -250px;
  margin-top: -300px;
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
    AUTH.checkPlan()
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      file: null,
      browseFeaturedFlag: false,
      browseOthersFlag: false,
      newImage: {
        product_id: null,
        url: null,
        status: null
      }
    }
  },
  props: ['item', 'status'],
  components: {
    'browse-images-modal': require('modules/image/BrowseModal.vue')
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    addImage(status){
      $('#Image')[0].click()
      this.status = status
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
    createFile(file){
      let fileReader = new FileReader()
      fileReader.readAsDataURL(event.target.files[0])
      this.upload()
    },
    upload(){
      let formData = new FormData()
      formData.append('file', this.file)
      formData.append('file_url', this.file.name)
      formData.append('account_id', this.user.userID)
      formData.append('payload_value', this.item.id)
      formData.append('status', this.status)
      $('#loading').css({'display': 'block'})
      axios.post(this.config.BACKEND_URL + '/account_images/upload', formData).then(response => {
        $('#loading').css({'display': 'none'})
        if(response.data !== null){
          this.$parent.retrieve()
        }
      })
    },
    createPhoto(object){
      if(this.status === 'featured'){
        object.status = 'featured'
        if(this.item.featured === null){
          object.product_id = this.item.id
          this.createRequest(object)
        }else{
          this.item.featured[0].url = object.url
          this.updateRequest(this.item.featured[0])
        }
      }else if(this.status === 'images'){
        object.status = 'others'
        object.product_id = this.item.id
        this.createRequest(object)
      }
    },
    createRequest(parameter){
      this.APIRequest('product_images/create', parameter).then(response => {
        this.$parent.retrieve()
        this.reset()
      })
    },
    updateRequest(parameter){
      this.APIRequest('product_images/update', parameter).then(response => {
        this.$parent.retrieve()
        this.reset()
      })
    },
    reset(){
      this.newImage = {
        product_id: null,
        status: null,
        url: null
      }
      this.hideImages()
    },
    showImages(){
      $('#browseImagesModal').modal('show')
    },
    hideImages(){
      $('#browseImagesModal').modal('hide')
    }
  }
}
</script>
