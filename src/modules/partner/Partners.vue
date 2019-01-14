<template>
  <div class="partner-holder">
    <div class="filter">
      <div class="input-group">
        <span class="input-group-addon">Filter By</span>
        <select class="form-control">
          <option>Company Name</option>
          <option>Company Location</option>
          <option>Products</option>
        </select>
        <span class="input-group-addon">Search</span>
        <input type="text" class="form-control" placeholder="Search here...">
      </div>
    </div>
    <div class="partner-list" v-if="data !== null">
      <partner v-for="item, index in data" v-if="data !==null" :item="item" :key="item.id" :index="index"></partner>
    </div>
    <empty v-if="data === null" :title="'No printing partners available!'" :action="'Please be back soon.'">
    </empty>
  </div>
</template>
<style scoped>
.partner-holder{
  width: 70%;
  float: left;
  margin-top: 25px;
}
.filter{
  width: 100%;
  float: left;
  height: 45px;
}

.form-control{
  height: 45px !important;
}
.input-group{
  margin-bottom: 10px !important;
}
.input-group-addon{
  width: 100px !important;
  background: #22b173 !important;
  color: #fff !important;
}
.input-group-title{
  width: 100px !important;
  background: #028170 !important;
  color: #fff !important;
}

.partner-list{
  width: 100%;
  float: left;
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
      prevIndex: null
    }
  },
  components: {
    'partner': require('modules/partner/Partner.vue'),
    'empty': require('modules/empty/Empty.vue')
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    retrieve(){
      let parameter = {
        condition: [{
          value: 'PARTNER',
          column: 'account_type',
          clause: '='
        }, {
          value: 'VERIFIED',
          column: 'status',
          clause: '='
        }]
      }
      $('#loading').css({'display': 'block'})
      this.APIRequest('partners/retrieve', parameter).then(response => {
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
