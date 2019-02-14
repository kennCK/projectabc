<template>
  <div>
    <div class="item">
      <span class="header">
        <label>Advanced Settings</label>
      </span>
      <span class="settings">


        <span class="item-setting">
          <span class="title">
            Family
          </span>
          <span class="input">
            <select class="form-control" v-model="object.attributes.fontFamily">
              <option value="Arial">Arial</option>
              <option value="Helvetica">Helvetica</option>
              <option value="Times New Roman">Times New Roman</option>
            </select>
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Size
          </span>
          <span class="input">
            <input type="text" class="form-control" v-model="object.attributes.fontSize">
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Style
          </span>
          <span class="input">
            <select class="form-control" v-model="object.attributes.fontStyle">
              <option value="normal">Normal</option>
              <option value="italic">Italic</option>
              <option value="oblique">Oblique</option>
            </select>
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Transform
          </span>
          <span class="input">
            <select class="form-control" v-model="object.attributes.textTransform">
              <option value="uppercase">Uppercase</option>
              <option value="lowercase">Lowercase</option>
              <option value="capitalize">Capitalize</option>
            </select>
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Decoration
          </span>
          <span class="input">
            <select class="form-control" v-model="object.attributes.textDecoration">
              <option value="default">Normal</option>
              <option value="overline">Overline</option>
              <option value="line-through">Line-through</option>
              <option value="underline">Underline</option>
            </select>
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Bold
          </span>
          <span class="input">
            <select class="form-control" v-model="object.attributes.fontWeight">
              <option v-for="i in 9" v-bind:value="350 + (i * 50)">{{350 + (i * 50)}}</option>
            </select>
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Top
          </span>
          <span class="input">
            <select class="form-control" v-model="object.attributes.top">
              <option v-for="i in 101" v-bind:value="(i - 1) + '%'">{{(i - 1) + '%'}}</option>
            </select>
          </span>
        </span>


        <span class="item-setting">
          <span class="title">
            Bottom
          </span>
          <span class="input">
            <select class="form-control" v-model="object.attributes.bottom">
              <option v-for="i in 101" v-bind:value="(i - 1) + '%'">{{(i - 1) + '%'}}</option>
            </select>
          </span>
        </span>


        <span class="item-setting">
          <span class="title">
            Left
          </span>
          <span class="input">
            <select class="form-control" v-model="object.attributes.left">
              <option v-for="i in 100" v-bind:value="((101 - i) * -1) + '%'">{{((101 - i) * -1) + '%'}}</option>
              <option v-for="i in 101" v-bind:value="(i - 1) + '%'">{{(i - 1) + '%'}}</option>
            </select>
          </span>
        </span>


        <span class="item-setting">
          <span class="title">
            Right
          </span>
          <span class="input">
            <select class="form-control" v-model="object.attributes.right">
              <option v-for="i in 101" v-bind:value="(i - 1) + '%'">{{(i - 1) + '%'}}</option>
            </select>
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Radius
          </span>
          <span class="input">
            <select class="form-control" v-model="object.attributes.borderRadius">
              <option v-for="i in 101" v-bind:value="(i - 1) + '%'">{{(i - 1) + '%'}}</option>
            </select>
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Align
          </span>
          <span class="input">
            <select class="form-control" v-model="object.attributes.textAlign">
              <option value="center">Center</option>
              <option value="justify">Justify</option>
              <option value="left">Left</option>
              <option value="right">Right</option>
            </select>
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Z-Index
          </span>
          <span class="input">
            <input type="text" class="form-control" v-model="object.attributes.zIndex">
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Height
          </span>
          <span class="input">
            <input type="text" class="form-control" v-model="object.attributes.height">
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Width
          </span>
          <span class="input">
            <select class="form-control" v-model="object.attributes.width">
              <option v-for="i in 100" v-bind:value="i + '%'">{{i + '%'}}</option>
            </select>
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Line Height
          </span>
          <span class="input">
            <input type="text" class="form-control" v-model="object.attributes.lineHeight">
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Rotate
          </span>
          <span class="input">
            <select class="form-control" v-model="object.attributes.transform">
              <option v-for="i in 361" v-bind:value="'rotate(' + (i - 1) + 'deg)'">{{(i - 1) + '%'}}</option>
            </select>
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Transparency
          </span>
          <span class="input">
            <select class="form-control" v-model="object.attributes.opacity">
              <option v-for="i in 11" v-bind:value="(i - 1) / 10">{{((i - 1) * 10) + '%'}}</option>
            </select>
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Border Top
          </span>
          <span class="input">
            <input type="text" class="form-control" v-model="object.attributes.borderTop">
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Border Bo.
          </span>
          <span class="input">
            <input type="text" class="form-control" v-model="object.attributes.borderBottom">
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Border Left
          </span>
          <span class="input">
            <input type="text" class="form-control" v-model="object.attributes.borderLeft">
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Border Right
          </span>
          <span class="input">
            <input type="text" class="form-control" v-model="object.attributes.borderRight">
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            P. Left
          </span>
          <span class="input">
            <input type="text" class="form-control" v-model="object.attributes.paddingLeft">
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Action
          </span>
          <span class="input">
            <i class="fas fa-trash text-danger actions" @click="remove()"></i>
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
  height: 220px;
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
.actions{
  font-size: 24px;
  line-height: 30px;
  padding-left: 5px;
}
.actions:hover{
  cursor: pointer;
  color: #ff0000;
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
  props: ['object', 'index'],
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    remove(){
      if(this.object.new === true){
        this.$parent.removeObject(this.index)
      }else{
        let parameter = {
          id: this.object.id
        }
        this.APIRequest('objects/delete', parameter).then(response => {
          this.$parent.retrieve()
        })
      }
    }
  }
}
</script>
