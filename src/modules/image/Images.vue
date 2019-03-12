<template>
  <div class="image-holder">
    <button class="btn btn-primary pull-right" @click="addImage()"><i class="fa fa-plus"></i> Upload Image
      <input type="file" @change="setUpFileUpload($event)" id="newImage">
    </button>
    <div class="image-list" v-if="data !== null">
      <div class="card" v-for="item, index in data">
        <div class="card-holder">
          <img class="card-img-top" v-bind:id="'card-img-top' + index" :src="config.BACKEND_URL + item.url" alt="Card image cap" download>
          <ul class="card-body">
            <li @click="remove(item.id)">Delete</li>
            <li style="border-right: 0px;" @click="download(config.BACKEND_URL + item.url, index)">Download</li>
          </ul>
        </div>
      </div>
    </div>
      <empty v-if="data === null" :title="'Looks like you have not uploaded an image!'" :action="'Click the Upload Image Button to get started.'">
      </empty>
  </div>
</template>
<style scoped>
button input{
  display: none;
}
.image-holder{
  width: 98%;
  float: left;
  margin-right: 2%;
  margin-bottom: 100px;
}
.image-list{
  width: 100%;
  float: left;
  margin-top: 25px;
}
.card{
  width: 19%;
  margin-right: 1%;
  float: left;
  margin-bottom: 25px;
  height: 240px;
}

.card-holder{
  width: 100%;
  position: relative;
  height: 240px;
}
.card-holder img{
  max-height: 200px;
  max-width: 100%;
}
.card-holder:hover{
  cursor: pointer;
  border: solid 1px #22b173;
}

.card-body{
  list-style: none;
  width: 100%;
  position: absolute;
  height: 40px;
  margin: 0px;
  padding: 0px;
  line-height: 40px;
  background: #22b173;
  color: #fff;
  padding: 0px !important;
  bottom: 0;
}
ul li{
  width: 50%;
  float: left;
  text-align: center;
  border-right: solid 1px #028170;
}
ul li:hover{
  background: #028170;
  cursor: pointer;
}

@media screen (max-width: 992px){
  .item{
    width: 49%;
  }
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
    AUTH.checkPlan()
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      data: null,
      file: null
    }
  },
  components: {
    'empty': require('modules/empty/Empty.vue')
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    addImage(){
      $('#newImage')[0].click()
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
      $('#loading').css({'display': 'block'})
      axios.post(this.config.BACKEND_URL + '/employees/upload', formData).then(response => {
        $('#loading').css({'display': 'none'})
        if(response.data !== null){
          this.retrieve()
        }
      })
    },
    retrieve(){
      let parameter = {
        condition: [{
          value: this.user.userID,
          column: 'account_id',
          clause: '='
        }]
      }
      $('#loading').css({'display': 'block'})
      this.APIRequest('account_images/retrieve', parameter).then(response => {
        $('#loading').css({'display': 'none'})
        if(response.data.length > 0){
          this.data = response.data
        }else{
          this.data = null
        }
      })
    },
    download(url, index){
      // alert('Hello ')
      // var canvas = document.getElementById('card-img-top1')
      // var image = canvas[0].toDataURL('image/png')
      // var link = document.createElement('a')
      // link.download = 'my-image1.png'
      // link.href = image
      // link.click()
      var x = document.createElement('a')
      x.download = 'card-img-top' + index
      x.href = url
      document.body.appendChild(x)
      x.click()
    },
    remove(id){
      let parameter = {
        id: id
      }
      this.APIRequest('account_images/delete', parameter).then(response => {
        this.retrieve()
      })
    }
  }
}
</script>
