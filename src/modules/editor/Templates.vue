<template>
	<div class="template-holder">
		<create></create>
    <div class="template-list" v-if="data !==null">
      <item v-for="item, index in data" :item="item" :key="item.id" :index="index"></item>
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
    'create': require('modules/editor/Create.vue'),
    'item': require('modules/editor/Item.vue'),
    'marketplace': require('modules/marketplace/Marketplace.vue'),
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
      $('#loading').css({'display': 'block'})
      this.APIRequest('templates/retrieve', parameter).then(response => {
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

