<template>
  <div>
    <div class="item">
      <span class="header">
        <label>Text</label>
        <i class="fa fa-close pull-right"></i>
      </span>
      <span class="settings">

        <span class="item-setting">
          <span class="title">
            Style
          </span>
          <span class="input">
            <select class="form-control">
              <option>Arial</option>
              <option>Times New Roman</option>
            </select>
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Size
          </span>
          <span class="input">
            <select class="form-control">
              <option v-for="i in 100" v-bind:value="i + '%'">{{i + '%'}}</option>
            </select>
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Color
          </span>
          <span class="input">
            <input type="text" class="form-control">
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Type
          </span>
          <span class="input">
            <select class="form-control">
              <option>Bold</option>
              <option>Normal</option>
            </select>
          </span>
        </span> 

        <span class="item-setting">
          <span class="title">
            Setting
          </span>
          <span class="input">
            <select class="form-control">
              <option>Static</option>
              <option>Dynamic</option>
            </select>
          </span>
        </span>   

        <span class="item-setting">
          <span class="title">
            Position
          </span>
          <span class="input">
            <select class="form-control">
              <option>Static</option>
              <option>Dynamic</option>
            </select>
          </span>
        </span>

         <span class="item-setting">
          <span class="title">
            Id
          </span>
          <span class="input">
            <input type="text" class="form-control">
          </span>
        </span>  
        
      </span>
    </div>
  </div>
</template>
<style scoped>
.item{
  width: 100%;
  float: left;
}
.header{
  width: 100%;
  float: left;
  height: 30px;
  text-align: center;
  line-height: 30px;
  border-bottom: solid 1px #ddd;
}
.header i{
  padding-right: 5px;
  font-size: 18px;
  line-height: 30px;
}
.settings{
  min-height: 10px;
  float: left;
  width: 100%;
  overflow-y: hidden;
}
.item-setting{
  width: 100%;
  float: left;
  height: 30px;
  line-height: 30px;
  border-bottom: solid 1px #ddd;
  font-size: 12px;
}
.item-setting .title{
  float: left;
  width: 40%;
  height: 30px;
  text-align: right;
  padding-right: 10px;
}
.item-setting .input{
  width: 60%;
  height: 30px;
  float: left;
}
.input .form-control{
  height: 28px !important;
  font-size: 12px !important;
  border-radius: 0px !important;
  border-bottom: 0px !important;
  border-top: 0px !important;
  margin-top: 1px !important;
  margin-bottom: 1px !important;
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
      errorMessage: null
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    }
  }
}
</script>
