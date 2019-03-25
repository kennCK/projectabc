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
            <input type="text" class="form-control" v-model="object.name" @keypress="setTyping(true)">
            <span class="suggestion" v-if="typing === true">
              <span class="suggestion-item" v-for="item, index in suggestion" @click="setId(item)">{{item}}</span>
            </span>
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
          <span class="title">
           Font Family
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
          <span class="input-paragraph-text">
            <i class="fas fa-font"></i>
            <input type="text" v-model="object.attributes.fontSize" class="form-control form-control-custom">
          </span>
          <span class="input-paragraph-text">
            <i class="fas fa-text-height"></i>
            <input type="text" v-model="object.attributes.lineHeight" class="form-control form-control-custom">
          </span>
          <span class="input-paragraph-text">
            <i class="fas fa-text-width"></i>
            <input type="text" v-model="object.attributes.textSpacing" class="form-control form-control-custom">
          </span>
        </span>
        <span class="item-setting">
          <span class="input-paragraph">
            <i class="fas fa-bold" @click="object.attributes.fontWeight = '600'" v-if="object.attributes.fontWeight === '500'"></i>
            <i class="active-pharagraph fas fa-bold" @click="object.attributes.fontWeight = '500'" v-else></i>
            <i class="fas fa-italic" @click="object.attributes.fontStyle = 'italic'" v-if="object.attributes.fontStyle === 'normal'"></i>
            <i class="active-pharagraph fas fa-italic" @click="object.attributes.fontStyle = 'normal'" v-else></i>
            <label v-bind:class="{'active-pharagraph': object.attributes.textTransform === 'uppercase'}" class="" @click="object.attributes.textTransform = 'uppercase'">AA</label>
            <label v-bind:class="{'active-pharagraph': object.attributes.textTransform === 'lowercase'}" class="" @click="object.attributes.textTransform = 'lowercase'">aa</label>
            <label v-bind:class="{'active-pharagraph': object.attributes.textTransform === 'capitalize'}" class="" @click="object.attributes.textTransform = 'capitalize'">Aa</label>
          </span>
        </span>
        <span class="item-setting">
          <span class="input-paragraph">
            <label v-bind:class="{'active-pharagraph': object.attributes.textDecoration === 'initial'}" class="" @click="object.attributes.textDecoration = 'initial'" style="text-decoration: initial">T</label>
            <label v-bind:class="{'active-pharagraph': object.attributes.textDecoration === 'overline'}" class="" @click="object.attributes.textDecoration = 'overline'" style="text-decoration: overline">T</label>
            <label v-bind:class="{'active-pharagraph': object.attributes.textDecoration === 'line-through'}" class="" @click="object.attributes.textDecoration = 'line-through'" style="text-decoration: line-through">T</label>
            <label v-bind:class="{'active-pharagraph': object.attributes.textDecoration === 'underline'}" class="" @click="object.attributes.textDecoration = 'underline'" style="text-decoration: underline">T</label>
          </span>
        </span>
        <span class="item-setting">
          <span class="input-paragraph">
            <i v-bind:class="{'active-pharagraph': object.attributes.textAlign === 'left'}" class="fas fa-align-left" @click="changeTextAlign('left')"></i>
            <i v-bind:class="{'active-pharagraph': object.attributes.textAlign === 'center'}" class="fas fa-align-center" @click="changeTextAlign('center')"></i>
            <i v-bind:class="{'active-pharagraph': object.attributes.textAlign === 'right'}" class="fas fa-align-right" @click="changeTextAlign('right')"></i>
            <i v-bind:class="{'active-pharagraph': object.attributes.textAlign === 'justify'}" class="fas fa-align-justify" @click="changeTextAlign('justify')"></i>
          </span>
        </span>
      </span>


      <span class="settings" v-if="menu[prevIndex].title === 'Size'">
        <span class="item-setting">
          <span class="input-paragraph-text" style="width: 50%;">
            <label>Width</label>
            <input type="text" v-model="object.attributes.width" class="form-control form-control-custom">
          </span>
          <span class="input-paragraph-text" style="width: 50%;">
            <label>Height</label>
            <input type="text" v-model="object.attributes.height" class="form-control form-control-custom">
          </span>
        </span>

        <span class="item-setting">
          <span class="input-paragraph-text" style="width: 50%;">
            <label>Top</label>
            <input type="text" v-model="object.attributes.top" class="form-control form-control-custom">
          </span>
          <span class="input-paragraph-text" style="width: 50%;">
            <label>Bottom</label>
            <input type="text" v-model="object.attributes.bottom" class="form-control form-control-custom">
          </span>
        </span>

        <span class="item-setting">
          <span class="input-paragraph-text" style="width: 50%;">
            <label>Left</label>
            <input type="text" v-model="object.attributes.left" class="form-control form-control-custom">
          </span>
          <span class="input-paragraph-text" style="width: 50%;">
            <label>Right</label>
            <input type="text" v-model="object.attributes.right" class="form-control form-control-custom">
          </span>
        </span>

        <span class="item-setting">
          <span class="input-paragraph-text" style="width: 50%;">
            <label>Rounded</label>
            <input type="text" v-model="object.attributes.borderRadius" class="form-control form-control-custom">
          </span>
          <span class="input-paragraph-text" style="width: 50%;">
            <label>Rotate</label>
            <select class="form-control form-control-custom" v-model="object.attributes.transform">
              <option v-for="i in 361" v-bind:value="'rotate(' + (i - 1) + 'deg)'">{{(i - 1) + '%'}}</option>
            </select>
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
  width: 25%;
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
  height: 180px;
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
.input-paragraph-text{
  width: 33%;
  float: left;
  height: 30px;
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

.input .suggestion{
  width: 60%;
  position: absolute;
  height: 120px;
  border-bottom: solid 1px #ddd;
  border-left: solid 1px #ddd;
  border-right: solid 1px #ddd;
  background: #fff;
  z-index: 10;
  overflow-y: auto;
}

.suggestion .suggestion-item{
  width: 100%;
  float: left;
  height: 30px;
  line-height: 30px;
  border-top:   solid 1px #ddd;
  padding-left: 5px; 
}

.suggestion-item:hover{
  cursor: pointer;
  background: #ccc;
}

.item-setting .input-paragraph i{
  font-size: 20px;
  line-height: 30px;
  width: 15%;
  float: left;
  text-align: center;
}
.item-setting .input-paragraph label{
  font-size: 20px;
  line-height: 30px;
  width: 15%;
  float: left;
  text-align: center;
  font-weight: 600;
}
.input-paragraph-text i{
  font-size: 20px;
  line-height: 30px;
  width: 40%;
  float: left;
  text-align: center;
}
.input-paragraph-text .form-control-custom{
  width: 60%;
  float: left;
  height: 25px;
  margin-top: 2px;
  font-size: 10px !important;
}
.input i:hover, .item-setting .input-paragraph i:hover, .item-setting .input-paragraph label:hover{
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
.input-paragraph-text{
  width: 33%;
  float: left;
  height: 30px;
}
.input-paragraph-text label{
  line-height: 30px;
  float: left;
  width: 40%;
  font-weight: 600;
  color: #22b173;
  text-align: center;
}
.input-paragraph-text i{
  font-size: 20px;
  line-height: 30px;
  width: 40%;
  float: left;
  text-align: center;
}
.input-paragraph-text .form-control-custom{
  width: 60%;
  float: left;
  height: 25px !important;
  margin-top: 2px;
  font-size: 10px !important;
  padding-top: 3px !important;
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
      {title: 'Pharagraph', flag: false},
      {title: 'Size', flag: false}
      ],
      prevIndex: 0,
      suggestion: ['address', 'birth_date', 'contact_number', 'complete_name', 'department', 'emergency_contact_name', 'emergency_contact_number', 'email', 'employment_code', 'first_name', 'last_name', 'middle_name', 'position', 'sex'],
      typing: false
    }
  },
  props: ['object', 'index'],
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    changeMenu(index){
      this.setTyping(false)
      if(this.prevIndex !== index){
        this.menu[this.prevIndex].flag = false
        this.menu[index].flag = true
        this.prevIndex = index
      }
    },
    changeTextAlign(align){
      this.object.attributes.textAlign = align
    },
    setTyping(params){
      this.typing = params
    },
    setId(params){
      this.object.name = params
      this.setTyping(false)
    }
  }
}
</script>
