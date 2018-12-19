<template>
  <div id="updateSettings">
    <div class="modal fade" id="updateTemplateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" v-if="item !== null">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Update Settings</h5>
            <button type="button" class="close" @click="close()" aria-label="Close">
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
              <label for="exampleInputEmail1">Title</label>
              <input type="text" class="form-control" placeholder="Type title here..." v-model="item.title">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Additional Details</label>
              <select class="form-control" v-model="item.settings">
                <option value="front">Front</option>
                <option value="back">Back</option>
              </select>
            </div>


            <div class="form-group">
              <label for="exampleInputEmail1">Size</label>
              <select class="form-control" v-model="size">
                <option value="portrait">3.375" x 2.125" Portrait</option>
                <option value="landscape">2.125" x 3.375" Landscape</option>
              </select>
            </div>

            <div class="form-group" v-if="user.type === 'ADMIN'">
              <label for="exampleInputEmail1">Status</label>
              <select class="form-control" v-model="item.status">
                <option value="personal">Personal</option>
                <option value="marketplace">Marketplace</option>
              </select>
            </div>

            <div class="form-group" v-if="user.type === 'ADMIN'">
              <label for="exampleInputEmail1">Category</label>
              <select class="form-control" v-model="item.categories">
                <option value="office">Office</option>
                <option value="school">School</option>
              </select>
            </div>

            <div class="form-group" v-if="user.type === 'ADMIN'">
              <label for="exampleInputEmail1">Price</label>
              <input type="text" class="form-control" placeholder="PHP 0.00" v-model="item.price">
            </div>

          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" @click="close()">Cancel</button>
              <button type="button" class="btn btn-primary" @click="update()">Submit</button>
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
      errorMessage: null,
      title: null,
      settings: null,
      orientation: null,
      item: null,
      size: null
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    update(){
      if(this.validate()){
        let parameter = {
          id: this.item.id,
          title: this.item.title,
          settings: this.item.settings,
          width: (this.size === 'portrait') ? this.config.LANDSCAPE : this.config.PORTRAIT,
          height: (this.size === 'portrait') ? this.config.PORTRAIT : this.config.LANDSCAPE
        }
        this.APIRequest('templates/update', parameter).then(response => {
          if(response.data > 0){
            $('#updateTemplateModal').modal('hide')
            this.$parent.retrieve()
          }
        })
      }
    },
    validate(){
      let i = this.item
      if(i.title !== null || i.title !== '' || i.settings !== null || i.settings !== '' || this.size !== null || this.size !== ''){
        return true
      }
      return false
    },
    close(){
      this.item = null
      $('#updateTemplateModal').modal('hide')
    }
  }
}
</script>
