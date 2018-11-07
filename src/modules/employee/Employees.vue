<template>
	<div class="employee-holder">
		<create></create>
    <div class="employee-list" v-if="data !==null">
      <div v-bind:class="{'make-active': item !== null && item.active === true}" v-for="item, index in data" >
        <span class="holder">
          <span class="header">
            <ul class="menu">
              <li>
                <label @click="showComments(item.id)" class="option">
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
              <li>
                <i v-bind:class="{'gray': item.status === 'not_verified', 'green': item.status === 'verified'}" class="fas fa-check"></i>
              </li>
              <li @click="print(item)">
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
                      <span class="dropdown-item">Editor</span>
                  </div>
                </div>
              </li>
            </ul>
          </span>

          <span class="items">
            <objects :objects="item.front_objects" :key="item.id" v-if="item.front_objects !== null">
            </objects>

            <objects :objects="item.back_objects" :key="item.id + 'b'" v-if="item.back_objects !== null">
            </objects>
          </span>
        </span>
      </div>
    </div>
    <update></update>
    <editor></editor>
    <edit></edit>
    <print></print>
	</div>
</template>
<style scoped>
.employee-holder{
  width: 100%;
  float: left;
}
.employee-list{
  width: 100%;
  float: left;
  margin-top: 25px;
}

.holder{
  width: 410px;
  float: left;
  height: 374px;
  margin-right: 25px;
  border: solid 1px #ddd;
  margin-bottom: 25px;
}
.holder:hover{
  cursor: pointer;
  border: solid 1px #22b173;
}
.make-active{
  border: solid 1px #22b173;
}
.header{
  width: 100%;
  float: left;
  min-height: 50px;
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

.menu li .option{
  width: 100%;
  float: left;
  height: 50px;
  color: #22b173;
}
.menu li i{
  font-size: 15px;
}
.menu li:hover, .menu li .option{
  cursor: pointer;
}
.items{
  width: 408px;
  height: 324px;
  float: left;
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
.gray{
  color: #555;
}
.green{
  color: #22b173;
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
  margin-top: 50px;
  z-index: 10;
}
.first-overlay{
  margin-left: 0px;
}
.second-overlay{
  margin-left: 0px;
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
  color: #fff;
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
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      data: null,
      prevIndex: null
    }
  },
  components: {
    'create': require('modules/employee/Create.vue'),
    'objects': require('modules/object/Objects.vue'),
    'update': require('modules/editor/Update.vue'),
    'editor': require('modules/editor/Editor.vue'),
    'comments': require('modules/comment/Comments.vue'),
    'edit': require('modules/employee/Edit.vue'),
    'print': require('modules/print/Print.vue')
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    retrieve(){
      let parameter = {
        condition: [{
          value: this.user.userID,
          column: 'account_id',
          clause: '='
        }]
      }
      this.APIRequest('employees/retrieve', parameter).then(response => {
        if(response.data.length > 0){
          this.data = response.data
        }else{
          this.data = null
        }
      })
    },
    makeActive(index){
      if(this.prevIndex === null){
        this.prevIndex = index
        this.data[index].active = true
      }else{
        if(this.prevIndex !== index){
          this.data[this.prevIndex].active = false
          this.data[index].active = true
          this.prevIndex = index
        }
      }
    },
    showComments(id){
      $('#overlay-' + id).css({'display': 'block'})
    },
    hideComments(id){
      $('#overlay-' + id).css({'display': 'none'})
    },
    print(item){
      for (var i = 0; i < this.$children.length; i++) {
        if(this.$children[i].$el.id === 'printer'){
          console.log('Hi')
          this.$children[i].item = item
          this.$children[i].modal()
        }
      }
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
          this.retrieve()
        }
      })
    }
  }
}
</script>
