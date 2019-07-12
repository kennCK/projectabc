<template>
  <div class="filter">
    <button class="btn btn-primary pull-right" data-toggle="modal" data-target=""><i class="fa fa-plus"></i> Add Template</button>
    <div class="input-group">
      <select class="btn btn-primary" v-model="typeValue">
          <option v-for="(item, index) in type"  :key="index">
              {{item.title}}
          </option>
      </select>
      <select class="btn btn-primary" @change="" v-model="filterValue">
        <option v-for="(item, index) in sort"  :key="index">
          {{item.title}}</option>
      </select>
      <input type="text" class="form-control" v-model="searchValue" :placeholder="'Search ' + typeValue + '...'">
      <select class="icons" v-model="arrangeValue">
         <option selected="selected" value="list"> &#xf0c9;</option>
         <option value="grid"> &#xf00a;</option>
        </select>
    </div>
    <hr>
    <div class="container-files"> 
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
.container-files{
  border: 1px solid rgba(0,0,0,0.1);
}
select.btn.btn-primary {
    min-height: 40px;
    margin-right: 2px;
}
button.btn.btn-primary.pull-right {
    margin-bottom: 10px;
}
select.icons {
    border-color: lightgray;
}
#file{
  font-size: 300%;
  color: $primary;
}
li#file-list{
  position: relative;
}
#filename:hover{
  color: $primary;
  cursor: pointer;
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
  width: 100% !important;
  float: left !important;
  margin-top: 10px;
}
.form-control{
  height: 40px !important;
  width: 15px !important;
  font: unset !important;
}
.input-group{
  margin-bottom: 10px;
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
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      typeValue: 'Personnal',
      filterValue: 'Current date first',
      searchValue: null,
      arrangeValue: 'list',
      type: [{
        title: 'Personnal'
      }, {
        title: 'Customers'
      }],
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
      this.$parent.typeValue = this.typeValue
      this.$parent.searchValue = this.searchValue
      this.$parent.retrieve()
    }
  },
  computed: {
    sortedData(){
      return this.data.filter(type => {
        if(this.typeValue === 'Personnal'){
          return (
            type.title.toLowerCase().includes(this.searchValue.toLowerCase())
          )
        }
      })
    }
  }
}
</script>
