<template>
  <div id="updateProducts">
    <div class="modal fade" id="updateProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" v-if="item !== null">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
            <button type="button" class="close" @click="close()" aria-label="Close">
              <span aria-hidden="true" class="text-white">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <span v-if="errorMessage !== null" class="text-danger text-center">
                <label><b>Opps! </b>{{errorMessage}}</label>
            </span>
            <br v-if="errorMessage !== null">
            
            <div class="form-group">
              <label for="exampleInputEmail1">Title</label>
              <input type="text" class="form-control" placeholder="Type title here..." v-model="item.title" v-bind:disabled="item.title === 'id_printing'">
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Description</label>
              <textarea class="form-control" v-model="item.description" rows="5" ></textarea>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Featured Image</label>
              <div class="product-images">
                <div class="new-image text-primary">
                  <button class="btn btn-primary pull-right" @click="addImage('featured')"><i class="fa fa-plus"></i> Upload
                    <input type="file" @change="setUpFileUpload($event)" id="Image">
                  </button>
                </div>
                <div class="image-preview">
                  <!-- <span class="image" v-if="item !== null">
                    <img :src="config.BACKEND_URL + this.file.file_url" height="auto" width="100%" >
                  </span> -->
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Other Images</label>
              <div class="product-images">
                <div class="new-image text-primary">
                  <button class="btn btn-primary pull-right" @click="addImage('images')"><i class="fa fa-plus"></i> Upload
                    <input type="file" @change="setUpFileUpload($event)" id="Image">
                  </button>
                </div>
              </div>
            </div>

            <prices></prices>

            <div class="form-group">
              <label for="exampleInputEmail1">Attributes</label>
              <div>
                <select class="form-control" style="width: 40%; float: left;">
                  <option value="color">Color</option>
                  <option value="size">Size</option>
                </select>
                <button class="btn btn-primary" style="margin-left: 10px;"><i class="fa fa-plus"></i></button>
              </div>
            </div>
            

            <div class="form-group">
              <label for="exampleInputEmail1">Status</label>
              <select class="form-control" v-model="item.status">
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger pull-left" @click="close()">Close</button>
              <button type="button" class="btn btn-primary" @click="update()">Update</button>
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
.image-preview{
  width: 80px;
  height: 80px;
  padding: 10px;
  border: solid 1px #ddd;
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
.product-images{
  width: 100%;
  float: left;
  min-height: 10px;
  overflow-y: hidden;
}
/*.new-image{
  height: 80px;
  width: 80px;
  border-radius: 5px;
  border: solid 1px #ddd;
  float: left;
  text-align: center;
}*/
.new-image input[type='file']{
  display: none;
  text-align: center;
  float: left;
}
.new-image button{
  width: 22%;
  height: 50%;
  border-radius: 5px;
  border: solid 1px #ddd;
  float: left;
  text-align: center;
}
/*.new-image i{
  line-height: 80px;
  font-size: 24px;
}*/
.new-image:hover{
  cursor: pointer;
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      item: null,
      file: null,
      status: null
    }
  },
  components: {
    'prices': require('modules/product/Prices.vue')
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
          this.retrieve()
        }
      })
    },
    // upload(){
    //   let formData = new FormData()
    //   formData.append('file', this.file)
    //   formData.append('url', this.file.name)
    //   formData.append('account_id', this.user.userID)
    //   $('#loading').css({display: 'block'})
    //   axios.post(this.config.BACKEND_URL + '/account_images/create', formData).then(response => {
    //     if(response.data.data > 0){
    //       AUTH.checkAuthentication(null)
    //       $('#loading').css({display: 'none'})
    //     }
    //   })
    // },
    update(){
      if(this.validate()){
        this.APIRequest('products/update', this.item).then(response => {
          if(response.data > 0){
            $('#updateProductModal').modal('hide')
            this.$parent.retrieve()
          }
        })
      }
    },
    retrieve(){
      let parameter = {
        condition: [{
          value: this.user.userID,
          column: 'account_id',
          clause: '='
        }],
        account_id: this.user.userID
      }
      $('#loading').css({'display': 'block'})
      this.APIRequest('products/retrieve', parameter).then(response => {
        $('#loading').css({'display': 'none'})
        if(response.data.length > 0){
          this.data = response.data
        }else{
          this.data = null
        }
      })
    },
    validate(){
      let i = this.item
      if(i.minimum !== null || i.minimum !== '' || i.maximum !== null || i.maximum !== '' || i.price !== null || i.price !== ''){
        return true
      }
      return false
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
