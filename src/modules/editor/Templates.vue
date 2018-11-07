<template>
	<div class="template-holder">
		<create></create>
    <div class="template-list" v-if="data !==null">
      <item v-for="item, index in data" :item="item" :key="item.id" :index="index"></item>
    </div>
    <marketplace></marketplace>
	</div>
</template>
<style scoped>
.template-holder{
  width: 100%;
  float: left;
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
    'marketplace': require('modules/marketplace/Marketplace.vue')
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
      this.APIRequest('templates/retrieve', parameter).then(response => {
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

