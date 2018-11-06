<template>
  <div>
    <div v-bind:class="{'make-active': item !== null && item.active === true}" class="item" v-if="item !== null" v-on:click="makeActive()">
      <span v-bind:class="{'make-active-header': item.active === true}" class="header">
        <ul class="menu">
          <li>
            <span class="badge badge-danger" v-if="parseInt(item.total_comments) > 0">{{item.total_comments}}</span>
          </li>
          <li>
            <i v-bind:class="{'gray': item.status === 'not_verified', 'green': item.status === 'verified'}" class="fas fa-check"></i>
          </li>
          <li>
            <i v-bind:class="{'gray': item.status !== 'printed', 'green': item.status === 'printed'}" class="fas fa-print"></i>
          </li>
          <li style="border-right: 0px;">
            <div class="dropdown">
              <label id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-cog"></i>
              </label>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <span class="dropdown-item disabled">Settings</span>
                  <span class="dropdown-item" v-if="item.status === 'not_verified'" @click="updateStatus('verified', item.id)">Verified</span>
                  <span class="dropdown-item" v-if="item.status === 'verified' || item.status === 'printed'" @click="updateStatus('not_verified', item.id)">Need Verification</span>
                  <span class="dropdown-item" @click="editProfile(item.id)">Edit Profile</span>
              </div>
            </div>
          </li>
        </ul>
      </span>
      <span class="body">
        <span class="preview">
          <span v-for="obj, innerIndex in item.front_objects" v-if="item.front_objects !== null">
              <span class="division" v-if="obj.type === 'division'" v-bind:style="obj.attributes">
              </span>
              <label class="text" v-if="obj.type === 'text'" v-bind:style="obj.attributes">{{obj.content}}</label>
              <img class="photo" :src="config.BACKEND_URL + obj.content" v-if="obj.type === 'photo'" :style="obj.attributes">
          </span>
        </span>
        <ul v-if="item.active === true" class="footer">
          <li style="border-left: 0px;">Editor</li>
          <li>
            <label @click="showComments(item.id)" class="menu">
              Comments
              <span class="badge badge-danger" v-if="parseInt(item.total_comments) > 0">{{item.total_comments}}</span>
            </label>
            <div class="overlay" v-bind:class="{'first-overlay': parseInt(item.counter) === 0,'second-overlay': parseInt(item.counter) === 1,'third-overlay': parseInt(item.counter) === 2, 'fourth-overlay': parseInt(item.counter) === 3}" v-bind:id="'overlay-' + item.id">
              <div class="header">
                Comments
                <i class="pull-right fa fa-close" @click="hideComments(item.id)"></i>
              </div>
              <div class="contents">
                <comments :payloadValue="item.id" :payload="'employees'"></comments>
              </div>
            </div>
          </li>
        </ul>
      </span>
    </div>
    <update></update>
    <editor></editor>
    <edit></edit>
  </div>
</template>
<style scoped>
.item{
  width: 204px;
  height: 374px;
  float: left;
  border: solid 1px #ddd;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
  margin-right: 25px;
  margin-bottom: 25px;
}
.item:hover{
  cursor: pointer;
  border: solid 1px #22b173;
}
.make-active{
  border: solid 1px #22b173;
}
.header{
  width: 100%;
  float: left;
  height: 50px;
  text-align: center;
  line-height: 50px;
  border-bottom: solid 1px #ddd;
}

.header .menu{
  padding: 0px;
  margin: 0px;
  height: 50px;
  float: left;
  width: 100%;
  list-style: none;
}

.menu li{
  width: 25%;
  float: left;
  height: 50px;
  border-right: solid 1px #ddd;
}

.menu li label{
  width: 100%;
  float: left;
  height: 50px;
}
.menu li i{
  font-size: 15px;
}

.menu li:hover{
  cursor: pointer;
}

#dropdownMenuButton:hover{
  cursor: pointer;
}
.make-active-header{
}
.body{
  width: 100%;
  float: left;
  height: 324px;
  position: relative;
}
.preview{
  height: 324px;
  position: absolute;
  width: 100%;
  float: left;

}

.division, .text, .photo{
  position: absolute;
}
.text, .photo{
  background: rgba(250, 250, 250, 0) !important;
}
.footer{
  padding: 0px;
  margin: 0px;
  width: 100%;
  float: left;
  z-index: 30;
  list-style: none;
  bottom: 0;
  height: 40px;
  background: #22b173;
  position: absolute;
  transition: 1s;
}
.footer li{
  width: 50%;
  float: left;
  height: 40px;
  text-align: center;
  line-height: 40px;
  border-left: solid 1px #028170;
  color: #fff;
}
.footer li .menu{
  width: 100%;
  float: left;
  line-height: 40px;
}
.footer li:hover, .footer li .menu:hover{
  cursor: pointer;
  background: #028170;
}
.overlay{
  position: absolute; 
  height: 350px;
  width: 600px;
  background: #fff;
  border: solid 1px #22b173 !important;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
  margin-top: -350px;
  display: none;
  cursor: default;
}
.first-overlay{
  margin-left: -103px;
}
.second-overlay{
  margin-left: -103px;
}
.third-overlay{
  margin-left: -500px; 
}
.fourth-overlay{
  margin-left: -500px;
}
.overlay .header{
  height: 50px;
  width: 100%;
  float: left;
  line-height: 50px;
  background: #22b173;
}
.overlay .header i{
  color: #fff;
  padding-right: 10px;
  line-height: 50px;
}
.overlay .contents{
  overflow-y: scroll;
  height: 295px;
  width: 100%;
  float: left;
  color: #555;
}
.gray{
  color: #555;
}
.green{
  color: #22b173;
}

.dropdown-menu{
  padding: 0px !important;
}

.dropdown-item{
  height: 35px !important;
  line-height: 35px !important;
  padding-top: 0px !important;
  padding-bottom: 0px !important;
}
.dropdown-item:hover{
  background: #eee;
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
      prevId: null
    }
  },
  components: {
    'update': require('modules/editor/Update.vue'),
    'editor': require('modules/editor/Editor.vue'),
    'comments': require('modules/comment/Comments.vue'),
    'edit': require('modules/employee/Edit.vue')
  },
  props: ['item', 'index'],
  methods: {
    makeActive(){
      this.$parent.makeActive(this.index)
    },
    redirect(parameter){
      ROUTER.push(parameter)
    },
    showComments(id){
      $('#overlay-' + id).css({'display': 'block'})
    },
    hideComments(id){
      $('#overlay-' + id).css({'display': 'none'})
    },
    retrieve(){
      this.$parent.retrieve()
    },
    editProfile(id){
      for (var i = 0; i < this.$children.length; i++) {
        if(this.$children[i].$el.id === 'editProfile'){
          this.$children[i].id = id
          this.$children[i].modal()
        }
      }
    },
    updateStatus(status, id){
      let parameter = {
        id: id,
        status: status
      }
      this.APIRequest('employees/update', parameter).then(response => {
        if(response.data === true){
          this.$parent.retrieve()
        }
      })
    }
  }
}
</script>
