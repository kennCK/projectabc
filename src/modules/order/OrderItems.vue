<template>
  <div class="employee-holder">
    <div class="title">
      <b @click="redirect('/orders')">
        <label class="text-primary action-link">My Orders</label>
      </b>
      <label class="text-primary">/ {{orderNumber}}</label>
    </div>
    <div class="employee-list" v-if="data !==null">
      <div v-bind:class="{'make-active': item !== null && item.active === true}" v-for="item, index in data.items">
        <span v-bind:style="{height: (parseInt(item.employee.front_template_details.height) === config.LANDSCAPE) ? ((parseInt(item.employee.front_template_details.height) * 2) + 50) + 'px' : (parseInt(item.employee.front_template_details.height) + 50) + 'px', width: (parseInt(item.employee.front_template_details.height) === config.LANDSCAPE) ? (parseInt(item.employee.front_template_details.width) + 2)  + 'px' : ((parseInt(item.employee.front_template_details.width) * 2) + 2)  + 'px'}" class="holder" v-if="item.employee !== null">
          <span class="header">
            <ul class="menu">
              <li style="width: 50%;">
                <label @click="showComments(item.employee.id)" class="option">
                  Comments
                  <span class="badge badge-danger" v-if="parseInt(item.employee.total_comments) > 0">{{item.employee.total_comments}}</span>
                </label>
                <div class="overlay first-overlay" v-bind:id="'overlay-' + item.employee.id">
                  <div class="header">
                    Comments
                    <i class="pull-right fa fa-close" @click="hideComments(item.employee.id)"></i>
                  </div>
                  <div class="contents">
                    <comments :payloadValue="item.employee.id" :payload="'employees'"></comments>
                  </div>
                </div>
              </li>
              <li @click="print(item.employee)">
                <i v-bind:class="{'gray': item.employee.status !== 'printed', 'green': item.employee.status === 'printed'}" class="fas fa-print"></i>
              </li>
              <li style="border-right: 0px;">
                <div class="dropdown">
                  <label id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cog"></i>
                  </label>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <span class="dropdown-item disabled">Settings</span>
                      <span class="dropdown-item" v-if="item.status !== 'printing'" @click="updateStatus('printing', item.id)">Printing</span>
                      <span class="dropdown-item" v-if="item.status !== 'printed'" @click="updateStatus('printed', item.id)">Printed</span>
                  </div>
                </div>
              </li>
            </ul>
          </span>

          <span v-bind:style="{height: (parseInt(item.employee.front_template_details.height)) + 'px', width: (parseInt(item.employee.front_template_details.width) * 2)  + 'px'}" class="items" v-if="parseInt(item.employee.front_template_details.width) === config.LANDSCAPE">
            <objects :objects="item.employee.front_objects" :key="item.id" v-if="item.employee.front_objects !== null" :heightTemplate="parseInt(item.employee.front_template_details.height)" :widthTemplate="parseInt(item.employee.front_template_details.width)">
            </objects>

            <objects :objects="item.employee.back_objects" :key="item.employee.id + 'b'" v-if="item.employee.back_objects !== null" :heightTemplate="parseInt(item.employee.front_template_details.height)" :widthTemplate="parseInt(item.employee.front_template_details.width)">
            </objects>
          </span>

          <span v-bind:style="{height: (parseInt(item.employee.front_template_details.height) * 2) + 'px', width: (parseInt(item.employee.front_template_details.width))  + 'px'}" class="items" v-if="parseInt(item.employee.front_template_details.width) === config.PORTRAIT">
            <objects :objects="item.employee.front_objects" :key="item.id" v-if="item.employee.front_objects !== null" :heightTemplate="parseInt(item.employee.front_template_details.height)" :widthTemplate="parseInt(item.employee.front_template_details.width)">
            </objects>

            <objects :objects="item.employee.back_objects" :key="item.id + 'b'" v-if="item.employee.back_objects !== null" :heightTemplate="parseInt(item.employee.front_template_details.height)" :widthTemplate="parseInt(item.employee.front_template_details.width)">
            </objects>
          </span>
        </span>


        <span v-bind:style="{height: (parseInt(item.templates.front.height) === config.LANDSCAPE) ? ((parseInt(item.templates.front.height) * 2) + 50) + 'px' : (parseInt(item.templates.front.height) + 50) + 'px', width: (parseInt(item.templates.front.height) === config.LANDSCAPE) ? (parseInt(item.templates.front.width) + 2)  + 'px' : ((parseInt(item.templates.front.width) * 2) + 2)  + 'px'}" class="holder" v-if="item.profile !== null">
          <span class="header">
            <ul class="menu">
              <li style="width: 50%;">
                <label @click="showComments(item.profile.id)" class="option">
                  Comments
                  <span class="badge badge-danger" v-if="parseInt(item.profile.total_comments) > 0">{{item.profile.total_comments}}</span>
                </label>
                <div class="overlay first-overlay" v-bind:id="'overlay-' + item.profile.id">
                  <div class="header">
                    Comments
                    <i class="pull-right fa fa-close" @click="hideComments(item.profile.id)"></i>
                  </div>
                  <div class="contents">
                    <comments :payloadValue="item.profile.id" :payload="'profiles'"></comments>
                  </div>
                </div>
              </li>
              <li @click="printBadge(item)">
                <i v-bind:class="{'gray': item.status !== 'printed', 'green': item.status === 'printed'}" class="fas fa-print"></i>
              </li>
              <li style="border-right: 0px;">
                <div class="dropdown">
                  <label id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-cog"></i>
                  </label>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <span class="dropdown-item disabled">Settings</span>
                      <span class="dropdown-item" v-if="item.status !== 'printing'" @click="updateStatus('printing', item.id)">Printing</span>
                      <span class="dropdown-item" v-if="item.status !== 'printed'" @click="updateStatus('printed', item.id)">Printed</span>
                  </div>
                </div>
              </li>
            </ul>
          </span>

          <span v-bind:style="{height: (parseInt(item.templates.front.height)) + 'px', width: (parseInt(item.templates.front.width) * 2)  + 'px'}" class="items" v-if="parseInt(item.templates.front.width) === config.LANDSCAPE">
            <badge-profile :objects="item.templates.front.objects" :key="item.id" v-if="item.templates.front !== null" :heightTemplate="parseInt(item.templates.front.height)" :widthTemplate="parseInt(item.templates.front.width)" :profile="item.profile">
            </badge-profile>

            <badge-profile :objects="item.templates.back.objects" :key="item.id + 'b'" v-if="item.templates.back !== null" :heightTemplate="parseInt(item.templates.front.height)" :widthTemplate="parseInt(item.templates.front.width)" :profile="item.profile">
            </badge-profile>
          </span>

          <span v-bind:style="{height: (parseInt(item.templates.front.height) * 2) + 'px', width: (parseInt(item.templates.front.width))  + 'px'}" class="items" v-if="parseInt(item.templates.front.width) === config.PORTRAIT">
            <badge-profile :objects="item.templates.front.objects" :key="item.id" v-if="item.templates.front !== null" :heightTemplate="parseInt(item.templates.front.height)" :widthTemplate="parseInt(item.templates.front.width)" :profile="item.profile">
            </badge-profile>

            <badge-profile :objects="item.templates.back.objects" :key="item.id + 'b'" v-if="item.templates.back !== null" :heightTemplate="parseInt(item.templates.front.height)" :widthTemplate="parseInt(item.templates.front.width)" :profile="item.profile">
            </badge-profile>
          </span>
        </span>

      </div>
    </div>
    <empty v-if="data === null" :title="'Looks like you do not have an order yet!'" :action="'Be back again soon.'"></empty>
    <update></update>
    <editor></editor>
    <edit></edit>
    <print></print>
    <print-badge></print-badge>
  </div>
</template>
<style scoped>
.employee-holder{
  width: 98%;
  float: left;
  margin-right: 2%;
}
.title{
  width: 100%;
  float: left;
  font-size: 16px;
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
    AUTH.checkPlan()
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      data: null,
      prevIndex: null,
      orderNumber: this.$route.params.orderNumber
    }
  },
  components: {
    'objects': require('modules/object/Objects.vue'),
    'badge-profile': require('modules/object/BadgeProfile.vue'),
    'update': require('modules/editor/Update.vue'),
    'editor': require('modules/editor/Editor.vue'),
    'comments': require('modules/comment/Comments.vue'),
    'edit': require('modules/entry/Edit.vue'),
    'print': require('modules/print/Print.vue'),
    'print-badge': require('modules/print/PrintBadge.vue'),
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
          column: 'partner',
          clause: '='
        }, {
          value: this.orderNumber,
          column: 'order_number',
          clause: '='
        }]
      }
      $('#loading').css({'display': 'block'})
      this.APIRequest('orders/retrieve_order_items', parameter).then(response => {
        $('#loading').css({'display': 'none'})
        if(response.data.length > 0){
          this.data = response.data[0]
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
          this.$children[i].item = item
          this.$children[i].modal()
        }
      }
    },
    printBadge(item){
      for (var i = 0; i < this.$children.length; i++) {
        if(this.$children[i].$el.id === 'printBadge'){
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
      this.APIRequest('checkout_items/update', parameter).then(response => {
        if(response.data === true){
          this.retrieve()
        }
      })
    }
  }
}
</script>
