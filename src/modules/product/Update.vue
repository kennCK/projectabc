<template>
  <div id="updateProducts">
    <div class="modal fade" id="updateProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
            <button type="button" class="close" @click="close()" aria-label="Close">
              <span aria-hidden="true" class="text-white">&times;</span>
            </button>
          </div>
          <div class="modal-body" v-if="item !== null">
            <span v-if="errorMessage !== null" class="text-danger text-center">
                <label><b>Opps! </b>{{errorMessage}}</label>
            </span>
            <br v-if="errorMessage !== null">       
            <span class="inputs" >

              <div class="form-group">
                <label for="exampleInputEmail1">Title</label>
                <input type="text" class="form-control" placeholder="Type title here..." v-model="item.title" v-bind:disabled="item.title === 'id_printing'">
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Description</label>
                <textarea class="form-control" v-model="item.description" rows="5" ></textarea>
              </div>

              <prices :item="item"></prices>

              <attributes :item="item"></attributes>

              <div class="form-group">
                <label for="exampleInputEmail1">Status</label>
                <select class="form-control" v-model="item.status">
                  <option value="pending">Pending</option>
                  <option value="approved">Approved</option>
                </select>
              </div>

            </span>
            <span class="sidebar">
              <span class="sidebar-header" >Featured Image</span>
              <span class="image" v-if="item.featured !== null">
                <img :src="config.BACKEND_URL + item.featured[0].url" height="150px" width="150px" >
              </span>
              <span class="image" v-else>
                <i class="fa fa fa-image" ></i>
              </span>
              <button class="btn btn-primary custom-block" style="margin-top: 5px; margin-right: 1%;" @click="addImage('featured')">Upload
                <input type="file" id="Image" accept="image/*" @change="setUpFileUpload($event)">
              </button>

              <button class="btn btn-warning custom-block" style="margin-top: 5px; margin-left: 1%;" @click="browseFeaturedFlag = true">Select
              </button>
              <div class="browse-images-holder">
                <div class="browse-images" v-if="browseFeaturedFlag === true">
                  <browse-images :object="item.featured" :view="'featured-view'" v-if="item.featured !== null"></browse-images>
                  <browse-images :object="newImage" :view="'featured-view'" v-if="item.featured === null"></browse-images>
                </div>
              </div>

              <span class="sidebar-header" >Other Images</span>
              <div class="other-holder">
                <div class="image-holder" v-for="(image,index) in item.images" v-if="item.images !== null">
                  <span class="image" >
                    <img :src="config.BACKEND_URL + image.url" height="75px" width="100%">
                  </span>
                </div>
              </div>
              

              <button class="btn btn-primary custom-block" style="margin-top: 5px; margin-right: 1%;" @click="addImage('others')">Upload
                <input type="file" id="Image" accept="image/*" @change="setUpFileUpload($event)">
              </button>

              <button class="btn btn-warning custom-block" style="margin-top: 5px; margin-left: 1%;" @click="addImage('others')">Select
                <input type="file" id="Image" accept="image/*" @change="setUpFileUpload($event)">
              </button>
            </span>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" @click="close()">Close</button>
              <button type="button" class="btn btn-primary" @click="update()">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.inputs{
  width: 55%;
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
  width: 40%;
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
  overflow-y: hidden;
  text-align: center;
}
.image-holder{
  overflow-y: hidden;
  display: inline-flex;
  width: 24%;
  text-align: center;
  padding: 2px;
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
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      file: null,
      status: null,
      browseFeaturedFlag: false,
      browseOthersFlag: false,
      newImage: {
        product_id: null,
        url: null,
        status: null
      }
    }
  },
  components: {
    'prices': require('modules/product/Prices.vue'),
    'attributes': require('modules/product/Attributes.vue'),
    'browse-images': require('modules/image/BrowseImages.vue')
  },
  props: ['item'],
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
    update(){
      this.APIRequest('products/update', this.item).then(response => {
        if(response.data > 0){
          $('#updateProductModal').modal('hide')
          this.$parent.retrieve()
        }
      })
    },
    updateImage(object){
      if(object.product_id === null){
        object.product_id = this.item.id
        this.APIRequest('product_images/create', object).then(response => {
          if(response.data > 0){
            $('#updateProductModal').modal('hide')
            this.$parent.retrieve()
          }
        })
      }else{
        this.APIRequest('product_images/update', object).then(response => {
          if(response.data === true){
            $('#updateProductModal').modal('hide')
            this.$parent.retrieve()
          }
        })
      }
    },
    close(){
      this.item = null
      $('#updateProductModal').modal('hide')
    },
    modal(){
      $('#updateProductModal').modal('show')
    },
    deleteItem(){
      if(this.item !== null){
        let parameter = {
          id: this.item.id
        }
        this.APIRequest('products/delete', this.item).then(response => {
          $('#updateProductModal').modal('hide')
          this.$parent.retrieve()
        })
      }
    }
  }
}
</script>
