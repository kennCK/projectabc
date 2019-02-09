<template>
  <div v-if="data !== null">
    <div class="title">
      <b @click="redirect('/marketplace')">
        <label class="text-primary action-link">Marketplace</label>
      </b>
      <label class="text-primary">/ {{data.title}}</label>
    </div>
    <div class="product-item-holder">
      <div class="product-image">
        <img :src="config.BACKEND_URL + selectedImage" class="main-image" v-if="selectedImage !== null">
        <img :src="config.BACKEND_URL + data.featured.url" class="main-image" v-if="selectedImage === null && data.featured !== null">
        <i class="fa fa-image" v-if="selectedImage === null && data.featured === null"></i>
       <div class="images-holder" v-if="data.images !== null">
        <div v-for="item, index in data.images" class="image-item" @click="selectImage(item.url)">
          <img :src="config.BACKEND_URL + item.url" class="other-image">
          <div class="overlay"></div>
        </div>
       </div>
      </div>
      <div class="product-details">
        <div class="product-title">
          <h3>{{data.title}}</h3>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
  .title{
    width: 100%;
    float: left;
    font-size: 16px;
  }
  .product-item-holder{
    width: 100%;
    float: left;
    min-height: 10px;
    overflow-y: hidden;
  }
  .product-image{
    width: 40%;
    float: left;
    min-height: 410px;
    overflow-y: hidden;
    text-align: center;
  }
  .product-image .main-image{
    height: 350px;
    float: left;
    width: 100%;
  }
  .product-image .fa-image{
    font-size: 250px;
    line-height: 350px;
  }
  .product-image .image-item{
    height: 60px;
    float: left;
    width: 80px;
  }
  .product-image .other-image{
    height: 60px;
    float: left;
    width: 80px;
  }
  .product-image .image-item:hover{
    cursor: pointer;
    background: #ffaa81;
  }
  .images-holder .overlay{
    height: 60px;
    z-index: 2;
    width: 80px;
    margin-top: -60px;
    float: left;
    background: rgba(0, 0, 0, 0.5);
  }
  .images-holder{
    width: 100%;
    float: left;
    min-height: 60px;
    overflow-y: hidden;
  }
  .product-details{
    height: 50px;
    width: 58%;
    margin-left: 2%;
    float: left;
  }
  .product-title{
    width: 100%;
    float: left;
    min-height: 50px;
    overflow-y: hidden;
    margin-top: 25px;
  }
  .product-row{
    width: 100%;
    float: left;
    min-height: 40px;
    overflow-y: hidden;
    font-weight: 600;
    font-size: 16px;
    line-height: 40px;
  }
  .product-row-tags{
    width: 100%;
    float: left;
    min-height: 40px;
    overflow-y: hidden;
    font-weight: 600;
    line-height: 40px;
  }
  .product-row-rating{
    width: 100%;
    float: left;
    min-height: 40px;
    overflow-y: hidden;
    font-size: 16px;
    line-height: 40px;
  }
  .product-row label{
    float: left;
    width: 15%;
  }
  .qty-input{
    width: 50px;
    height: 40px;
    float: left;
    border-radius: 5px;
    border: solid 1px #ffaa81;
    text-align: center !important;
  }
  .product-row-tags label{
    float: left;
  }
  .tag-label{
    height: 35px;
    line-height: 35px;
    background: #ffaa81;
    padding-left: 10px;
    padding-right: 10px;
    color: #fff;
    margin-right: 5px;
    border-radius: 5px;
    margin-top: 2px;
  }
  .attribute{
    width: 50px;
    height: 40px;
    float: left;
    border-radius: 5px;
    border: solid 1px #ffaa81;
    margin-right: 5px;
  }
  .attribute:hover{
    cursor: pointer;
  }
  .product-more-details{
    width: 100%;
    float: left;
    margin-bottom: 100px;
    min-height: 50px;
    overflow-y: hidden;
    border-top: solid 1px #ffaa81;
  }
  .product-more-details .details-holder{
    width: 60%;
    float: left;
    min-height: 10px;
    overflow-y: hidden;
    margin-top: 25px;
  }
  .product-menu{
    list-style: none;
    padding: 0px;
    margin: 0;
    width: 60%;
    margin-right: 40%;
    float: left;
    color: #fff;
  }
  .product-menu li{
    height: 50px;
    float: left;
    width: 25%;
    line-height: 50px;
    padding-left: 10px;
    font-weight: 600;
    border-right: solid 1px #fff;
    background: #ffaa81;
  }
  .product-menu li:hover{
    cursor: pointer;
    color: #000;
  }
  .menu-active{
    color: #000;
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
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    }
  }
}
</script>
