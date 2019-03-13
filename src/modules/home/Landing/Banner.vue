<template>
	<div class="cw-banner bg-secondary">
    <div class="text text-white">
      <span class="title">
        <h1>Design an ID. We Print.</h1>
      </span>
      <span class="description">
        <h4>
          ID Factory is an online application that lets you design and create custom IDs. Ideal for companies, corporate events and many more.
          (Create. Archive. Print. All in one place.)
        </h4>
        <button class="btn btn-warning btn-banner" v-on:click="redirect('/signup')"> Get started for 30 days trial</button>
      </span>
    </div>
    <div class="image">
      <img src="../../../assets/img/banner.png" width="100%">
    </div>
  </div>
</template>
<style scoped>
.btn-banner {
  padding-top: 0px !important;
  padding: 50px;
  margin-top: 20px;
  font-size: 20px !important;
  height: 50px !important;
  line-height: 50px !important;
  border-radius: 98px;
}
.cw-banner{
  width: 100%;
  float: left;
  min-height: 100px;
  overflow-y: hidden;
  position: relative;
}
.text{
  width: 45%;
  float: left;
  margin-left: 5%;
  margin-top: 150px;
  margin-bottom: 100px;
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
  right: 10%;
  bottom: -10px;
  display: block;
  position: absolute;
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
  .btn-banner{
    width: 100%;
    float: left;
    margin-left: 0%;
    margin-right: 0%;
    padding: 0;
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
