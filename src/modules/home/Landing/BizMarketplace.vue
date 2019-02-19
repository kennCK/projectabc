<template>
  <div class="cw-bizmarketplace">
    <div class="text text-white">
      <span class="title">
        <h1>Find products on our Marketplace</h1>
      </span>
      <span class="description">
        <h4>
          We are more than just your production facility. With Marketplace you get to find all things related to printing and other graphics and design related services.
        </h4>
      </span>
    </div>
    <div class="buttons-menu">
      <button class="btn btn-warning btn-banner" v-on:click="redirect('/signup')"> Register</button>
       <button class="btn btn-primary btn-banner1" v-on:click="redirect('/login')"> Login</button>
    </div>
  </div>
</template>
<style scoped>
.btn-banner {
  padding-top: 0px !important;
  padding: 50px;
  margin-top: 25px;
  font-size: 20px !important;
  height: 50px !important;
  line-height: 50px !important;
  border-radius: 98px;
}
.btn-banner1 {
  padding-top: 0px !important;
  padding: 50px;
  margin-top: 25px;
  font-size: 20px !important;
  height: 50px !important;
  line-height: 50px !important;
  margin-left: 1%;
  border-radius: 98px;
}
.cw-bizmarketplace{
  width: 100%;
  float: left;
  height: 300px;
  background: #ffaa81;
}
.text{
  width: 90%;
  float: left;
  margin-left: 5%;
  margin-top: 50px;
}
.text .title{
  width: 100%;
  float: left;
  text-align: center;
}
.title h1{
  font-size: 40px;
}
.text .description{
  margin-top: 20px;
  width: 80%;
  margin-left: 10%;
  margin-right: 10%;
  float: left;
  text-align: center;
}
.image{
  width: 40%;
  margin-right: 5%;
  float: left;
  margin-left: 5%;
  margin-top: 100px;
  display: block;
}

.buttons-menu{
  width: 100%;
  float: left;
  text-align: center;
}

@media screen and (max-width: 992px){
  .cw-bizmarketplace{
    width: 100%;
    float: left;
    height: 370px;
    background: #ffaa81;
  }
  .text{
    width: 90%;
    margin-left: 5%;
    margin-right: 5%;
    margin-top: 50px;
  }
  .text .title{
    text-align: center;
    margin-left: 1%;
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
