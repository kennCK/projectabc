<template>
  <div class="cw-bizmarketplace">
    <div class="text text-white">
      <span class="title">
        <h1>Welcome to Marketplace</h1>
      </span>
      <span class="description">
        <h4>
          Looking for something? ID Factory Marketplace is the best place to find all things related to printing and other graphics and design related services.
        </h4>
        <button class="btn btn-warning btn-banner" v-on:click="redirect('/signup')"> Search Marketplace </button>
      </span>
    </div>
    <div class="image">
      <img src="../../../assets/img/banner.png" style="margin-bottom: 5px;" width="100%">
    </div>
  </div>
</template>
<style scoped>
.btn-banner {
  padding-top: 0px !important;
  margin-top: 20px;
  font-size: 20px !important;
  height: 50px !important;
  line-height: 50px !important;
}
.cw-bizmarketplace{
  width: 100%;
  float: left;
  height: 600px;
  background: #028170;
}
.text{
  width: 45%;
  float: left;
  margin-left: 5%;
  margin-top: 150px;
}
.text .title{
  width: 100%;
  float: left;
}
.title h1{
  font-size: 50px;
}
.text .description{
  margin-top: 25px;
  width: 100%;
  float: left;
  text-align: justify;
}
.image{
  width: 40%;
  margin-right: 5%;
  float: left;
  margin-left: 5%;
  margin-top: 100px;
  display: block;
}

@media screen and (max-width: 992px){
  .text{
    width: 90%;
    margin-left: 5%;
    margin-right: 5%;
    margin-top: 50px;
  }
  .title{
    text-align: center;
  }

  .image{
    display: none;
  }
}
</style>
<script>
import ROUTER from '../../../router'
import AUTH from '../../../services/auth'
export default {
  mounted(){
  },
  data(){
    return {
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    }
  }
}
</script>
