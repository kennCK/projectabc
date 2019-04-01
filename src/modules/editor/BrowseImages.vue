<template>
  <div>
    <div class="item">
      <span class="header">
        Saved Images
        <i class="fa fa-close pull-right" @click="close()" v-if="view === 'editor'"></i>
        <i class="fa fa-close pull-right" @click="closeTableView()" v-if="view !== 'editor'"></i>
      </span>
      <span class="search">
        <input type="text" class="form-control form-control-custom" v-model="searchValue" placeholder="Search something..." @keyup.enter="search()">
        <i class="fa fa-search" @click="search()"></i>
      </span>
      <span class="settings" v-if="data !== null">
        <span v-bind:class="{'active-image': item.active === true}" class="image-holder" v-for="item, index in data" @click="select(index)">
          <img :src="config.BACKEND_URL + item.url">
        </span>
      </span>
      <span class="settings text-danger" v-if="data === null && loadingFlag === false">
        <label class="error">No results!</label>
      </span>
      <span class="settings text-primary" v-if="loadingFlag === true">
        <label class="error">Loading...</label>
      </span>
      <span class="bottom-action" v-if="prevIndex !== null && data !== null">
        <button class="btn btn-danger" @click="cancel()">Cancel</button>
        <button class="btn btn-primary" @click="apply()" v-if="view === 'editor' && view === 'table-view'">Apply</button>
        <button class="btn btn-primary" @click="applyProfile('profile')" v-if="view === 'profile-view'">Apply</button>
        <button class="btn btn-primary" @click="applySignature('signature')" v-if="view === 'signature-view'">Apply</button>
      </span>
    </div>
  </div>
</template>
<style scoped>
.item{
  width: 100%;
  float: left;
}
.header, .search{
  width: 100%;
  float: left;
  height: 30px;
  text-align: center;
  line-height: 30px;
  border-bottom: solid 1px #ddd;
  text-align: center;
  font-size: 10px;
}

.header .fa-close{
  padding-right: 5px;
}

.settings{
  height: 200px;
  float: left;
  width: 100%;
  overflow-y: auto;
}
.search .form-control-custom{
  width: 100%;
  float: left;
  height: 25px !important;
  margin-top: 2px;
  font-size: 10px !important;
  padding-top: 3px !important;
}
.search i{
  float: right;
  padding-right: 7px;
  margin-top: -21px;
  font-size: 14px !important;
}
.search i:hover{
  cursor: pointer;
}
.image-holder{
  width: 80px;
  float: left;
  height: 80px;
  margin-left: 1%;
  margin-right: 1%;
  margin-bottom: 5px;
  border: solid 1px #ddd;
  border-radius: 2px;
}
.image-holder img{
  max-height: 79px;
  max-width: 100%;
  float: left;
  border-radius: 50%;
}

.bottom-action{
  width: 100%;
  float: left;
  height: 40px;
  font-size: 10px;
}
.bottom-action .btn{
  float: left;
  height: 30px !important;
  padding-top: 5px !important; 
  margin-top: 5px;
  font-size: 10px !important;
  margin-left: 5px;
}
.image-holder:hover{
  cursor: pointer;
  background: #ffaa81;
}
.active-image{
  background: #ffaa81;
}
.settings .error{
  height: 50px;
  font-size: 10px;
  text-align: center;
  width: 100%;
  float: left;
  line-height: 50px;
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
    this.search()
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      searchValue: null,
      data: null,
      prevIndex: null,
      default: this.object.content,
      loadingFlag: false
    }
  },
  props: ['object', 'view', 'index'],
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    search(){
      let parameter = null
      if(this.searchValue !== null && this.searchValue !== ''){
        parameter = {
          condition: [{
            value: '%' + this.searchValue + '%',
            column: 'url',
            clause: '='
          }, {
            value: this.user.userID,
            column: 'account_id',
            clause: '='
          }]
        }
      }else{
        parameter = {
          condition: [{
            value: this.user.userID,
            column: 'account_id',
            clause: '='
          }]
        }
      }
      this.loadingFlag = true
      this.APIRequest('account_images/retrieve', parameter).done(response => {
        this.loadingFlag = false
        if(response.data.length > 0){
          this.data = response.data
        }else{
          this.data = null
        }
      })
    },
    select(index){
      if(this.prevIndex === null){
        this.data[index].active = true
        this.prevIndex = index
      }else{
        if(this.prevIndex !== index){
          this.data[this.prevIndex].active = false
          this.data[index].active = true
          this.prevIndex = index
        }
      }
    },
    apply(){
      this.object.content = this.data[this.prevIndex].url
      if(this.view === 'table-view'){
        this.$parent.selectedBrowseImage = null
        this.$parent.updateText(this.object, this.index)
      }
    },
    applyProfile(params){
      this.object[params] = this.data[this.prevIndex].url
      this.$parent.selectedBrowseImage = null
    },
    cancel(){
      this.object.content = this.default
    },
    close(){
      this.prevIndex = null
      this.$parent.browseImagesFlag = false
    },
    closeTableView(){
      this.prevIndex = null
      this.$parent.selectedBrowseImage = null
    }
  }
}
</script>
