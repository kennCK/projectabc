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
      </span>

      <span class="settings" v-if="menu[prevIndex].title === 'Color'">
        
        <span class="item-setting">
          <span class="title">
            Background
          </span>
          <span class="input">
            <input  class="form-control" type="text" v-model="object.attributes.background">
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Color
          </span>
          <span class="input">
            <input  class="form-control" type="text" v-model="object.attributes.color">
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
  font-size: 10px !important;
}
.item-setting .title{
  float: left;
  width: 40%;
  height: 30px;
  text-align: right;
  padding-right: 10px;
  text-transform: uppercase;
  font-weight: 600;
  font-size: 10px !important;
  color: #22b173;
}
.item-setting .input{
  width: 60%;
  height: 30px;
  float: left;
}

.image-holder{
  min-height: 120px;
  width: 100%;
  overflow-y: hidden;
  float: left;
  margin-top: 5px;
}

.image-holder-action {
  height: 30px;
  width: 100%;
  float: left;
}

.image-holder img{
  height: auto;
  width: 50%;
  float: left;
}
.image-holder-action .btn{
  float: left;
  height: 30px !important;
  padding-top: 5px !important; 
  margin-top: 5px;
  font-size: 10px !important;
  margin-left: 5px;
}
.image-holder-action label{
  float: left;
  line-height: 30px;
  padding-right: 10px;
  padding-left: 10px;
  height: 30px;
  margin-bottom: 0px;
  margin-top: 5px;
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
.input-paragraph-text label{
  line-height: 30px;
  float: left;
  width: 40%;
  font-weight: 600;
  color: #22b173;
  text-align: center;
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
  height: 25px !important;
  margin-top: 2px;
  font-size: 10px !important;
  padding-top: 3px !important;
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

.image-holder-action input{
  width: 100%;
  height: 30px;
  line-height: 30px;
  float: left;
  border-left: solid 1px #ddd;
  border-right: solid 1px #ddd;
  padding-left: 10px;
}
.image-holder-action input:hover{
  cursor: pointer;
  background: #22b173;
  color: #fff;
}
.image-holder-action input{
  display: none;
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
      {title: 'Size', flag: false}
      ],
      prevIndex: 0,
      file: null
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
    },
    addImage(){
      $('#photoImage')[0].click()
    },
    createFile(file){
      let fileReader = new FileReader()
      fileReader.readAsDataURL(event.target.files[0])
      this.upload()
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
    upload(){
      let formData = new FormData()
      formData.append('file', this.file)
      formData.append('file_url', this.file.name)
      formData.append('account_id', this.user.userID)
      formData.append('template_id', this.object.template_id)
      $('#loading').css({'display': 'block'})
      axios.post(this.config.BACKEND_URL + '/objects/upload', formData).then(response => {
        $('#loading').css({'display': 'none'})
        if(response.data !== null){
          this.object.content = response.data.data
        }
      })
    }
  }
}
</script>
