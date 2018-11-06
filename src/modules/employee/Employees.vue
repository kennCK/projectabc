<template>
	<div class="employee-holder">
		<create></create>
    <div class="employee-list">
      <div v-for="item, index in data" v-if="data !==null" >
        <item-front :item="item" :key="item.id" :index="index" v-if="item.front_objects !== null">

        </item-front>
        <item-back :item="item" :key="item.id + 'b'" :index="index" v-if="item.back_objects !== null">
          
        </item-back>
      </div>
    </div>
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
    'item-front': require('modules/employee/ItemFront.vue'),
    'item-back': require('modules/employee/ItemBack.vue')
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
    }
  }
}
</script>
