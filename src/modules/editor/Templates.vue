<template>
	<div class="template-holder">
	 <div class="entry-viewer">
      <label v-bind:class="{'active-menu-icon': viewIcon === 'badge'}" class="menu-icons"  @click="changeViewBy('badge')">
        <i class="fas fa-id-badge"></i>
      </label>
      <label v-bind:class="{'active-menu-icon': viewIcon === 'table'}"  class="menu-icons" @click="changeViewBy('table')">
         <i class="fas fa-table"></i>
      </label>
      <create></create>
    </div>
    <div class="template-list" v-if="data !==null && viewIcon === 'badge'">
      <item v-for="item, index in data" :item="item" :key="item.id" :index="index"></item>
    </div>
    <div class="template-list-table" v-if="data !==null && viewIcon === 'table'">
      <table-view :data="data"></table-view>
    </div>
    <empty v-if="data === null" :title="'Looks like you have not created or purchased a tempate!'" :action="'Click the New Template Button or Purchase a template to get started.'"></empty>
    <marketplace></marketplace>
	</div>
</template>
<style scoped>
.template-holder{
  width: 98%;
  float: left;
  margin-right: 2%;
}
.template-list{
  width: 100%;
  float: left;
  margin-top: 25px;
  margin-bottom: 50px;
}
.template-list-table{
  width: 100%;
  float: left;
  margin-bottom: 50px;
}
.entry-viewer{
  width: 100%;
  float: left;
  height: 50px;
  line-height: 50px;
  border-bottom: solid 1px #ddd;
}
.entry-viewer .menu-icons{
  height: 40px;
  width: 40px;
  float: left;
  line-height: 40px;
  text-align: center;
  margin-top: 5px;
}
.menu-icons i{
  line-height: 40px;
  font-size: 20px;
}
.menu-icons:hover{
  border-radius: 50%;
  background: #ddd;
  cursor: pointer;
}
.active-menu-icon{
  border-radius: 50%;
  background: #ddd;
  cursor: pointer;
  color: #22b173;
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
    this.prevIndex = 0
    this.retrieve(0)
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      data: null,
      prevIndex: null,
      viewIcon: 'badge'
    }
  },
  components: {
    'create': require('modules/editor/Create.vue'),
    'item': require('modules/editor/Item.vue'),
    'marketplace': require('modules/editor/Marketplace.vue'),
    'table-view': require('modules/editor/TableView.vue'),
    'empty': require('modules/empty/Empty.vue')
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    changeViewBy(parameter){
      this.viewIcon = parameter
    },
    retrieve(index){
      let tempData = (this.data !== null) ? this.data.length : 0
      this.prevIndex = tempData
      let parameter = {
        condition: [{
          value: this.user.userID,
          column: 'account_id',
          clause: '='
        }],
        active: (index !== false) ? index : tempData
      }
      $('#loading').css({'display': 'block'})
      this.APIRequest('templates/retrieve', parameter).then(response => {
        this.prevIndex = (index !== false) ? index : tempData
        $('#loading').css({'display': 'none'})
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
        }else{
          this.data[this.prevIndex].active = false
          this.prevIndex = null
        }
      }
    }
  }
}
</script>

