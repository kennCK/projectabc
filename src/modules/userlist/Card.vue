<template>
  <div class="holder" @click="selected(index, moduleText)" v-if="group !== null  && group.title !== null">
    <img :src="config.BACKEND_URL + group.title.profile.profile_url" class="profile" v-if="group.title.profile !== null">
    <i class="fa fa-user-circle-o" v-else></i>
    <label>{{group.title.username}}
      <!-- <span class="badge badge-primary">{{group.total_members}}</span> -->
    </label>
    
  </div>
</template>
<style scoped>
.holder{
  width: 100%;
  float: left;
  height: 50px;
  padding-left: 5px;
  border-bottom: solid 1px #eee;
}
.profile{
  width: 40px;
  height: 40px;
  margin-top: 5px;
  border-radius: 50%; 
  float: left;

}
label{
  line-height: 50px;
  padding-left: 10px;
  float: left;
  align: center;
}

i{
  font-size: 40px;
  line-height: 50px;
  float: left;
}

.holder:hover{
  cursor: pointer;
  background: #ddd;
}

</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
export default {
  data(){
    return {
      config: CONFIG
    }
  },
  props: ['group', 'index', 'moduleText'],
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    selected(index, moduleText){
      this.$parent.makeActive(index, moduleText)
    }
  }
}
</script>

