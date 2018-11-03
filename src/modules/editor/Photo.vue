<template>
  <div>
    <div class="item">
      <span class="header">
        <label>Photo</label>
      </span>
      <span class="settings">
        
        <span class="item-setting">
          <span class="title">
            Id
          </span>
          <span class="input">
            <input type="text" class="form-control" v-model="attributes.id">
          </span>
        </span>


        <span class="item-setting">
          <span class="title">
            Setting
          </span>
          <span class="input">
            <select class="form-control" v-model="attributes.settings">
              <option value="static">Static</option>
              <option value="dynamic">Dynamic</option>
            </select>
          </span>
        </span>   


        <span class="item-setting">
          <span class="title">
            Height
          </span>
          <span class="input">
            <input type="text" class="form-control" v-model="attributes.height">
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Width
          </span>
          <span class="input">
            <select class="form-control" v-model="attributes.width">
              <option v-for="i in 100" v-bind:value="i + '%'">{{i + '%'}}</option>
            </select>
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Background
          </span>
          <span class="input">
            <input  class="form-control" v-bind:style="{color: (attributes.background === 'white' || attributes.background === '#fff' || attributes.background === '#ffffff') ? '#000' : '#ffffff', background: (attributes.background === '' || attributes.background === null) ? '#028170' : attributes.background}" type="text" v-model="attributes.background">
          </span>
        </span>


        <span class="item-setting">
          <span class="title">
            Color
          </span>
          <span class="input">
            <input  class="form-control" v-bind:style="{color: (attributes.color === 'white' || attributes.color === '#fff' || attributes.color === '#ffffff') ? '#000' : '#ffffff', background: (attributes.color === '' || attributes.color === null) ? '#028170' : attributes.color}" type="text" v-model="attributes.color">
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Top
          </span>
          <span class="input">
            <select class="form-control" v-model="attributes.top">
              <option v-for="i in 101" v-bind:value="(i - 1) + '%'">{{(i - 1) + '%'}}</option>
            </select>
          </span>
        </span>


        <span class="item-setting">
          <span class="title">
            Bottom
          </span>
          <span class="input">
            <select class="form-control" v-model="attributes.bottom">
              <option v-for="i in 101" v-bind:value="(i - 1) + '%'">{{(i - 1) + '%'}}</option>
            </select>
          </span>
        </span>


        <span class="item-setting">
          <span class="title">
            Left
          </span>
          <span class="input">
            <select class="form-control" v-model="attributes.left">
              <option v-for="i in 101" v-bind:value="(i - 1) + '%'">{{(i - 1) + '%'}}</option>
            </select>
          </span>
        </span>


        <span class="item-setting">
          <span class="title">
            Right
          </span>
          <span class="input">
            <select class="form-control" v-model="attributes.right">
              <option v-for="i in 101" v-bind:value="(i - 1) + '%'">{{(i - 1) + '%'}}</option>
            </select>
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Radius
          </span>
          <span class="input">
            <select class="form-control" v-model="attributes.borderRadius">
              <option v-for="i in 101" v-bind:value="(i - 1) + '%'">{{(i - 1) + '%'}}</option>
            </select>
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Z-Index
          </span>
          <span class="input">
            <input type="text" class="form-control" v-model="attributes.zIndex">
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
  min-height: 100px;
  max-height: 300px;
  float: left;
  width: 100%;
  overflow-y: scroll;
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
  props: ['attributes'],
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    }
  }
}
</script>
