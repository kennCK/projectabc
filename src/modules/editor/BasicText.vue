<template>
  <div>
    <div class="item">
      <span class="header">
        <ul class="header-menu">
          <li v-bind:class="{'active-header-menu': item.flag === true}"v-for="item, index in menu" @click="changeMenu(index)">{{item.title}}</li>
        </ul>
      </span>
      <span class="settings" v-if="menu[prevIndex].title === 'Content'">
        <span class="item-setting">
          <span class="title">
            Object Id
          </span>
          <span class="input">
            <input type="text" class="form-control" v-model="object.name">
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
           OBJECT Setting
          </span>
          <span class="input">
            <select class="form-control" v-model="object.settings">
              <option value="static">Fixed</option>
              <option value="dynamic">Changeable</option>
            </select>
          </span>
        </span>   

        <span class="item-setting">
          <span class="title">
            Text
          </span>
          <span class="input" >
             <input type="text" class="form-control" v-model="object.content" v-if="object.content.length < 15">
          </span>
          <textarea v-if="object.content.length >= 15" class="form-control" v-model="object.content" rows="4"></textarea>
        </span>
      </span>
      <span class="settings" v-if="menu[prevIndex].title === 'Color'">
        
<!--         <span class="item-setting">
          <span class="title">
            Background
          </span>
          <span class="input">
            <input  class="form-control" v-bind:style="{color: (object.attributes.background === 'white' || object.attributes.background === '#fff' || object.attributes.background === '#ffffff') ? '#000' : '#ffffff', background: (object.attributes.background === '' || object.attributes.background === null) ? '#028170' : object.attributes.background}" type="text" v-model="object.attributes.background">
          </span>
        </span> -->


        <span class="item-setting">
          <span class="title">
            Color
          </span>
          <span class="input">
            <input  class="form-control" type="text" v-model="object.attributes.color">
          </span>
        </span>
      </span>
      <span class="settings" v-if="menu[prevIndex].title === 'Pharagraph'">
        <span class="item-setting">
          <span class="input-paragraph">
            <i class="fas fa-font" @click=""></i>
            <i class="fas fa-text-height" @click=""></i>
            <i class="fas fa-text-width" @click=""></i>
          </span>
        </span>
        <span class="item-setting">
          <span class="input-paragraph">
            <i class="fas fa-italic" @click="object.attributes.fontStyle = 'italic'" v-if="object.attributes.fontStyle === 'normal'"></i>
            <i class="active-pharagraph fas fa-italic" @click="object.attributes.fontStyle = 'normal'" v-else></i>
            <i v-bind:class="{'active-pharagraph': object.attributes.textAlign === 'left'}" class="fas fa-align-left" @click="changeTextAlign('left')"></i>
            <i v-bind:class="{'active-pharagraph': object.attributes.textAlign === 'center'}" class="fas fa-align-center" @click="changeTextAlign('center')"></i>
            <i v-bind:class="{'active-pharagraph': object.attributes.textAlign === 'right'}" class="fas fa-align-right" @click="changeTextAlign('right')"></i>
            <i v-bind:class="{'active-pharagraph': object.attributes.textAlign === 'justify'}" class="fas fa-align-justify" @click="changeTextAlign('justify')"></i>
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
.header-menu{
  height: 30px;
  float: left;
  margin: 0px;
  padding: 0px;
  width: 100%;
  list-style: none;
}
.header-menu li{
  width: 30%;
  float: left;
  font-size: 10px;
  font-weight: 600;
  height: 30px;
}

.header-menu li:hover{
  cursor: pointer;
}

.active-header-menu{
  background: #22b173;
  color: #fff;
}
.settings{
  height: 170px;
  float: left;
  width: 100%;
  overflow-y: auto;
}
.item-setting{
  width: 100%;
  float: left;
  height: 30px;
  line-height: 30px;
  border-bottom: solid 1px #ddd;
  font-size: 10px;
}
.item-setting .title{
  float: left;
  width: 40%;
  height: 30px;
  text-align: right;
  padding-right: 10px;
  text-transform: uppercase;
  font-weight: 600;
  color: #22b173;
}
.item-setting .input{
  width: 60%;
  height: 30px;
  float: left;
}

.item-setting .input-paragraph{
  width: 100%;
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
.input i{
  font-size: 20px;
  line-height: 30px;
  width: 25%;
  float: left;
  text-align: center;
}
.item-setting .input-paragraph i{
  font-size: 20px;
  line-height: 30px;
  width: 15%;
  float: left;
  text-align: center;
}
.input i:hover, .item-setting .input-paragraph i:hover{
  cursor: pointer;
}
.actions{
  font-size: 24px;
  line-height: 30px;
  padding-left: 5px;
}
.actions:hover{
  cursor: pointer;
  color: #22b173;
}
.active-pharagraph{
  color: #22b173 !important;
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
      errorMessage: null,
      menu: [
      {title: 'Content', flag: true},
      {title: 'Color', flag: false},
      {title: 'Pharagraph', flag: false}
      ],
      prevIndex: 0
    }
  },
  props: ['object', 'index'],
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    changeMenu(index){
      if(this.prevIndex !== index){
        this.menu[this.prevIndex].flag = false
        this.menu[index].flag = true
        this.prevIndex = index
      }
    },
    changeTextAlign(align){
      this.object.attributes.textAlign = align
    }
  }
}
</script>
