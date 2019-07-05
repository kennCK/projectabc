<template>
  <div class="filter">
    <button class="btn btn-primary pull-right" data-toggle="modal" data-target=""><i class="fa fa-plus"></i> Add Template</button>
    <br></br>
    <div class="input-group">
      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
       Type
    </button>
      <div class="dropdown-menu">
        <a class="dropdown-item" value="personnal">Personnal</a>
        <a class="dropdown-item" value="location">Location</a>
      </div>
      <input type="text" class="form-control" v-model="searchValue" placeholder="Search files...">
      <select class="icons" @change="" v-model="filterValue">
        <option v-for="(item, index) in sort"  :key="index">
          {{item.title}}</option>
      </select>
      <select class="icons" v-model="arrangeValue">
         <option selected="selected" value="list"> &#xf0c9;</option>
         <option value="grid"> &#xf00a;</option>
        </select>
    </div>
    <br></br>
    <div> 
      <ul v-for="(item, index) in folders" :key="index" class="folder">
        <li id="file-list"><i id="file" class="fas fa-folder"></i> <span id="filename">{{item.title}}</span></li>
      </ul>
    </div>
  </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
ul{
  list-style: none;
}
#file{
  font-size: 300%;
  color: $primary;
}
li#file-list{
  position: relative;
}
.folder{
  font-size: 150%;
  
}
span#filename {
    position: absolute;
    bottom: 8px;
    left: 73px;
}
.icons{
  line-height: 40px !important;
  font-size: 13px !important;
  font-family: 'FontAwesome', 'Lato';
}
.arrange{
  margin-left: 600px !important;
  line-height: 40px !important;
  font-size: 15px !important;
  font-family: 'FontAwesome', 'Lato';
}
.filter{
  width: 80% !important;
  float: left !important;
  margin-top: 50px;
  margin-left: 10%;
}
.form-control{
  height: 40px !important;
  width: 15px !important;
  font: unset !important;
}
.input-group{
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
button.btn.btn-primary.dropdown-toggle {
    min-height: 40px;
}
@media (max-width: 991px){
  .partner-holder{
    width: 20%;
  }
  .input-filter{
  margin-bottom: 25px !important;
  margin-top: 20px !important;
  margin-left: 110px !important;
  height: 50% !important;
}
.arrange{
  margin-left: 600px !important;
  line-height: 40px !important;
  font-size: 15px !important;
  font-family: 'FontAwesome', 'Lato';
}
.input-group{
  margin-bottom: 25px !important;
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
.input-filter{
  margin-bottom: 25px !important;
  margin-top: 20px !important;
  margin-left: 110px !important;
  height: 50% !important;
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
      filterValue1: 'personnal',
      filterValue: 'Current date first',
      searchValue: null,
      arrangeValue: 'list',
      sort: [{
        title: 'Current date first', status1: true
      }, {
        title: 'Current date last', status1: false
      }],
      folders: [{
        title: 'T-shirts'
      }, {
        title: 'Mugs'
      }, {
        title: 'I.Ds'
      }, {
        title: 'Cellphones'
      }, {
        title: 'Tarpaulins'
      }, {
        title: 'Temp1'
      }, {
        title: 'Temp2'
      }, {
        title: 'Temp3'
      }, {
        title: 'Temp4'
      }, {
        title: 'Temp5'
      }, {
        title: 'Temp6'
      }, {
        title: 'Temp7'
      }, {
        title: 'Temp8'
      }, {
        title: 'Temp9'
      }],

      status1: true
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    retrieve(){
      this.$parent.filterValue1 = this.filterValue1
      this.$parent.searchValue = this.searchValue
      this.$parent.retrieve()
    }
  }
}
</script>
