<template>
  <div class="filter">
    <div class="input-group">
      <span class="input-group-addon">Filter By</span>
      <select class="form-control" v-model="filterValue" @change="retrieve()">
        <option value="name">Name</option>
        <option value="address">Location</option>
      </select>
      <span class="input-group-addon">Search</span>
      <input type="text" class="form-control" v-model="searchValue" @keyup.enter="retrieve()" placeholder="Search here...">
    </div>
  </div>
</template>
<style scoped>
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
@media (max-width: 991px){
  .partner-holder{
    width: 100%;
  }
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
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      filterValue: 'name',
      searchValue: null
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    retrieve(){
      this.$parent.filterValue = this.filterValue
      this.$parent.searchValue = this.searchValue
      this.$parent.retrieve()
    }
  }
}
</script>
