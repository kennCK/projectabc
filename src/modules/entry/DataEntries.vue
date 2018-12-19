<template>
	<div class="employee-holder">
		<create></create>
    <div class="employee-list" v-if="data !==null">
      <div v-bind:class="{'make-active': item !== null && item.active === true}" v-for="item, index in data" >
        <span v-bind:style="{height: (parseInt(item.front_template_details.height) === config.LANDSCAPE) ? ((parseInt(item.front_template_details.height) * 2) + 50) + 'px' : (parseInt(item.front_template_details.height) + 50) + 'px', width: (parseInt(item.front_template_details.height) === config.LANDSCAPE) ? (parseInt(item.front_template_details.width) + 2)  + 'px' : ((parseInt(item.front_template_details.width) * 2) + 2)  + 'px'}" class="holder">
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
                      <span class="dropdown-item" v-if="item.status === 'verified' && item.checkout === null" @click="addToCart(item.id)">Add to Cart</span>
                      <span class="dropdown-item" v-if="item.status === 'not_verified'" @click="updateStatus('verified', item.id)">Verified</span>
                      <span class="dropdown-item" v-if="item.status === 'verified' || item.status === 'printed'" @click="updateStatus('not_verified', item.id)">Need Verification</span>
                      <span class="dropdown-item" @click="editProfile(item.id)">Edit Profile</span>
                      <span class="dropdown-item">Editor</span>
                  </div>
                </div>
              </li>
            </ul>
          </span>

          <span v-bind:style="{height: (parseInt(item.front_template_details.height)) + 'px', width: (parseInt(item.front_template_details.width) * 2)  + 'px'}" class="items" v-if="parseInt(item.front_template_details.width) === config.LANDSCAPE">
            <objects :objects="item.front_objects" :key="item.id" v-if="item.front_objects !== null" :heightTemplate="parseInt(item.front_template_details.height)" :widthTemplate="parseInt(item.front_template_details.width)">
            </objects>

            <objects :objects="item.back_objects" :key="item.id + 'b'" v-if="item.back_objects !== null" :heightTemplate="parseInt(item.front_template_details.height)" :widthTemplate="parseInt(item.front_template_details.width)">
            </objects>
          </span>

          <span v-bind:style="{height: (parseInt(item.front_template_details.height) * 2) + 'px', width: (parseInt(item.front_template_details.width))  + 'px'}" class="items" v-if="parseInt(item.front_template_details.width) === config.PORTRAIT">
            <objects :objects="item.front_objects" :key="item.id" v-if="item.front_objects !== null" :heightTemplate="parseInt(item.front_template_details.height)" :widthTemplate="parseInt(item.front_template_details.width)">
            </objects>

            <objects :objects="item.back_objects" :key="item.id + 'b'" v-if="item.back_objects !== null" :heightTemplate="parseInt(item.front_template_details.height)" :widthTemplate="parseInt(item.front_template_details.width)">
            </objects>
          </span>
        </span>
      </div>
    </div>
    <empty v-if="data === null" :title="'Looks like you have not added an employee to your template!'" :action="'Click the  New Employee Button to get started.'"></empty>
    <update></update>
    <editor></editor>
    <edit></edit>
    <print></print>
	</div>
</template>
<style scoped>
.employee-holder{
  width: 98%;
  float: left;
  margin-right: 2%;
}
.employee-list{
  width: 100%;
  float: left;
  margin-top: 25px;
}

.holder{
  float: left;
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
    'create': require('modules/entry/Create.vue'),
    'objects': require('modules/object/Objects.vue'),
    'update': require('modules/editor/Update.vue'),
    'editor': require('modules/editor/Editor.vue'),
    'comments': require('modules/comment/Comments.vue'),
    'edit': require('modules/entry/Edit.vue'),
    'print': require('modules/print/Print.vue'),
    'empty': require('modules/empty/Empty.vue')
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
      for (var i = 0; i < this.$children.length; i++) {
        if(this.$children[i].$el.id === ('comment' + id)){
          this.$children[i].retrieve()
        }
      }
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
    },
    addToCart(id){
      let parameter = {
        account_id: this.user.userID,
        payload: 'employee',
        payload_value: id,
        price: 0
      }
      this.APIRequest('checkout_items/create', parameter).then(response => {
        if(response.data > 0){
          AUTH.checkAuthentication(null)
          this.retrieve()
        }
      })
    }
  }
}
</script>
