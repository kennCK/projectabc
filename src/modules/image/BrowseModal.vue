<template>
  <div>
    <div class="modal fade" id="browseImagesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Images</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="close()">
              <span aria-hidden="true" class="text-white">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <span class="search">
              <input type="text" class="form-control form-control-custom" v-model="searchValue" placeholder="Search something..." @keyup.enter="search()">
              <!-- <i class="fa fa-search" @click="search()"></i> -->
            </span>
            <span class="settings" v-if="data !== null">
              <span v-bind:class="{'active-image': item.active === true}" class="image-holder" v-for="item, index in data" @click="select(index)">
                <img :src="config.BACKEND_URL + item.url">
              </span>
            </span>
            <span class="settings text-danger" v-if="data === null && loadingFlag === false">
              <label class="error">No results!</label>
            </span>
          </div>
          <div class="modal-footer">
            <button class="btn btn-danger" @click="cancel()">Cancel</button>
            <button class="btn btn-primary" @click="apply()" v-if="object.url !== null">Apply</button>
            <button class="btn btn-primary" @click="applyCreate()" v-if="object.url === null">Apply</button>
          </div>
        </div>
      </div>
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
  height: 50px;
  text-align: center;
  line-height: 50px;
  text-align: center;
}

.header .fa-close{
  padding-right: 5px;
}

.settings{
  min-height: 200px;
  float: left;
  width: 100%;
  overflow-y: hidden;
}
.search .form-control-custom{
  width: 100%;
  float: left;
  height: 45px !important;
  margin-top: 2px;
  padding-top: 3px !important;
}
.search i{
  float: right;
  padding-right: 7px;
  margin-top: -50px;
  font-size: 14px !important;
}
.search i:hover{
  cursor: pointer;
}
.image-holder{
  width: 200px;
  float: left;
  height: 200px;
  margin-bottom: 5px;
  border: solid 1px #ddd;
  border-radius: 2px;
}
.image-holder img{
  max-height: 200px;
  max-width: 100%;
  float: left;
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
  border: solid 1px #ffaa81;
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
      default: this.object.url,
      loadingFlag: false
    }
  },
  props: ['object'],
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
      this.APIRequest('images/retrieve', parameter).done(response => {
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
      this.object.url = this.data[this.prevIndex].url
      this.$parent.updatePhoto(this.object)
    },
    applyCreate(){
      this.object.url = this.data[this.prevIndex].url
      this.$parent.createPhoto(this.object)
    },
    cancel(){
      this.object.url = this.default
      this.close()
    },
    close(){
      this.prevIndex = null
      $('#browseImagesModal').modal('hide')
    }
  }
}
</script>
