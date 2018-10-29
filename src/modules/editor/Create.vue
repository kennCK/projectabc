<template>
  <div>
    <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#createTemplateModal"><i class="fa fa-plus"></i> New Template</button>
    <div class="modal fade" id="createTemplateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Add Event</h5>
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
<!--             <div class="featured-image">
              <span class="options" v-on:click="addFeaturedImage()" v-if="featuredFile === null" title="Click to add">
                <i class="fa fa-plus-circle"></i>
                <label>Add Featured Image</label>
                <input type="file" id="addFeaturedImage" name="file" accept="image/*"  @change="setUpFileUploadFeaturedImage($event)">
              </span>
              <span class="options" v-on:click="addFeaturedImage()" v-else title="Click to change">
                <img :src="featuredFileUrl">
                <input type="file" id="addFeaturedImage" name="file" accept="image/*"  @change="setUpFileUploadFeaturedImage($event)">
              </span>
            </div> -->
            <div class="form-group">
              <label for="exampleInputEmail1">Title</label>
              <input type="text" class="form-control" placeholder="Type title here...">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Additional Details</label>
              <textarea class="form-control"  placeholder="Type additional details here..." rows="5">
              </textarea> 
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
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null
    }
  },
  props: ['params'],
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    submit(){
      if(this.validate()){
      }
    },
    validate(){
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
