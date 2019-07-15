<template>
  <div class="pages-holder" v-if="contents !== null">
    <ul class="pages-wrapper">
      <li class="pages-item">
        <i class="fas fa-plus pull-right" @click="global.addPage()"></i>
        <i class="fa fa-trash text-danger pull-right"></i>
        <i class="fa fa-clone text-primary pull-right"></i>
      </li>
      <li class="pages-item" v-for="(item, index) in contents.pages" :key="index" @click="makeActive(item, index)" v-bind:class="{'active': contents.selected_page === index}">
        <i class="fa" v-bind:class="{'fa-eye': item.eye === true,  'fa-eye-slash': item.eye === false}" @click="item.eye = !item.eye"></i>
        <i class="fas" v-bind:class="{'fa-unlock': item.locked === false,  'fa-lock': item.locked === true}" @click="item.locked = !item.locked"></i>
        <span>{{item.title + ' ' + (index + 1)}}</span>
      </li>
    </ul>
  </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
  .pages-holder{
    width: 100%;
    float: left;
    min-height: 50px;
    overflow-y: hidden;
  }

  ul{
    width: 100%;
    float: left;
    min-height: 50px;
    padding: 0px;
    margin: 0px;
    overflow-y: hidden;
  }

  ul li{
    width: 100%;
    float: left;
    min-height: 30px;
    line-height: 30px;
    padding-left: 5px;
    color: black;
    overflow-y: hidden;
  }

  ul li i{
    color: black;
    padding-right: 5px;
  }

  ul li:hover{
    cursor: pointer;
    border-bottom: solid 1px $secondary;
  }

  input{
    border: none;
    height: 30px;
  }

  .pull-right{
    line-height: 30px;
  }

  .active{
    background: $gray;
    color: white;
  }
</style>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import axios from 'axios'
import GLOBAL from 'src/modules/editorv2/global.js'
export default {
  data(){
    return {
      global: GLOBAL
    }
  },
  props: ['contents'],
  methods: {
    makeActive(item, index){
      this.contents.selected_page = index
      GLOBAL.template.activePageIndex = index
      GLOBAL.template.objectSettings = item.style
    }
  }
}
</script>
