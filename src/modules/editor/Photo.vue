<template>
  <div>
    <div class="item">
      <span class="header">
        <label>Advanced Settings</label>
      </span>
      <span class="settings">
        
        <span class="item-setting">
          <span class="title">
            Id
          </span>
          <span class="input">
            <input type="text" class="form-control" v-model="object.name">
          </span>
        </span>

        <span class="item-setting">
          <span class="title">
            Content
          </span>
          <span class="input">
            <span class="file" @click="addImage()">
              <label>Click to upload</label>
              <input type="file" class="form-control" id="photoImage"   @change="setUpFileUpload($event)" accept="image/*">
            </span>
          </span>
        </span>


        <span class="item-setting">
          <span class="title">
            Setting
          </span>
          <span class="input">
            <select class="form-control" v-model="object.settings">
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
            Background
          </span>
          <span class="input">
            <input  class="form-control" v-bind:style="{color: (object.attributes.background === 'white' || object.attributes.background === '#fff' || object.attributes.background === '#ffffff') ? '#000' : '#ffffff', background: (object.attributes.background === '' || object.attributes.background === null) ? '#028170' : object.attributes.background}" type="text" v-model="object.attributes.background">
          </span>
        </span>


        <span class="item-setting">
          <span class="title">
            Color
          </span>
          <span class="input">
            <input  class="form-control" v-bind:style="{color: (object.attributes.color === 'white' || object.attributes.color === '#fff' || object.attributes.color === '#ffffff') ? '#000' : '#ffffff', background: (object.attributes.color === '' || object.attributes.color === null) ? '#028170' : object.attributes.color}" type="text" v-model="object.attributes.color">
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
            Z-Index
          </span>
          <span class="input">
            <input type="text" class="form-control" v-model="object.attributes.zIndex">
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
.input .file{
  width: 100%;
  height: 30px;
  line-height: 30px;
  float: left;
  border-left: solid 1px #ddd;
  border-right: solid 1px #ddd;
  padding-left: 10px;
}
.input .file:hover, .input .file label:hover{
  cursor: pointer;
  background: #22b173;
  color: #fff;
}
.file input{
  display: none;
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
      errorMessage: null,
      file: null
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
