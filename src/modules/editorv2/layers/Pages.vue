<template>
  <div class="pages-holder">
    <ul class="pages-wrapper">
      <li class="pages-item">
        <i class="fas fa-plus pull-right" @click="add()"></i>
      </li>
      <li class="pages-item" v-for="(item, index) in pages" :key="index">
        <i class="fa" v-bind:class="{'fa-eye': item.eye === true,  'fa-eye-slash': item.eye === false}" @click="item.eye = !item.eye"></i>
        <span>{{item.title}}</span>
        <i class="fa fa-trash text-danger pull-right"></i>
        <i class="fa fa-clone text-primary pull-right"></i>
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
</style>
<script>
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
import axios from 'axios'
export default {
  data(){
    return {
      pages: []
    }
  },
  props: ['template'],
  methods: {
    add(){
    	let newPage = {
    		stlye: {
    			height: this.template.style.height,
    			width: this.template.style.width,
    			background: this.template.style.background
    		}
    	}
    }
  }
}
</script>
