<template>
  <div>
    <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#createTemplateModal"><i class="fa fa-plus"></i> New Template</button>
    <div class="modal fade" id="createTemplateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Editor</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
              <input type="text" class="form-control" placeholder="Type title here..." v-model="title">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Additional Details</label>
              <select class="form-control" v-model="settings">
                <option value="front">Front Only</option>
                <option value="front_and_back">Front and Back</option>
              </select>
            </div>

          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#createEventModal">Cancel</button>
              <button type="button" class="btn btn-primary" @click="submit()">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
    console.log(this.user)
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      title: null,
      settings: null
    }
  },
  props: ['params'],
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    submit(){
      if(this.validate()){
        let parameter = {
          account_id: this.user.userID,
          title: this.title,
          settings: this.settings
        }
        this.APIRequest('templates/create', parameter).then(response => {
          if(response.data > 0){
            // Success
          }
        })
      }
    },
    validate(){
      if(this.title !== null || this.title !== '' || this.settings !== null || this.settings !== ''){
        return true
      }
      return false
    }
  }
}
</script>
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
