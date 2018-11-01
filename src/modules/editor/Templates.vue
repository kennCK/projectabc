<template>
	<div class="template-holder">
		<create></create>
    <div class="template-list">
      <item v-for="item, index in data" v-if="data !==null" :item="item" :key="item.id"></item>
    </div>
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
      data: null
    }
  },
  components: {
    'create': require('modules/editor/Create.vue'),
    'item': require('modules/editor/Item.vue')
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    submit(){
      if(this.validate()){
      }
    },
    validate(){
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
    }
  }
}
</script>

