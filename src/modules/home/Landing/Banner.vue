<template>
	<div class="cw-banner bg-secondary">
    <div class="text text-white">
      <span class="title">
        <h1>Design and printing is made a lot easier.</h1>
      </span>
      <span class="description">
        <h4>
          Here in PaPrint, we help customers with low graphic design skills and connect them easily to the best printing companies.
        </h4>
        <button class="btn btn-warning btn-banner" v-on:click="redirect('/signup')"> Start free 30-day trial</button>
      </span>
    </div> 
    <div class="division">
      <div class="phone-wrapper">
    <label class="speaker"></label>
    <div class="phone-body">
      <HtmlContent :content="content"></HtmlContent>
    </div>
    <label class="home-swipe">
      <font-awesome-icon icon="caret-left" class="icon"></font-awesome-icon>
      <font-awesome-icon icon="circle" class="icon"></font-awesome-icon>
      <font-awesome-icon icon="square" class="icon"></font-awesome-icon>
    </label>
  </div>
   </div> 
 </div>
</template>
</span>
<style scoped>

.division{
  border:1px solid black;
  width: 50%;
  min-height: 450px;
  overflow-y: hidden;
  margin-top: 75px;
  margin-bottom: 25px;
}
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
.phone-wrapper{
  width: 100%;
  height: 100%;
  float: left;
  border-radius: 20px;
  background: black;
  position: relative;
}

.phone-body{
  width: 96%;
  height: 97%;
  margin: 2%;
  background:white;
  border-radius: 20px;
  padding-top: 25px;
}
.phone-body{
  width: 96%;
  height: 97%;
  margin: 2%;
  background:white;
  border-radius: 20px;
  padding-top: 25px;
}
.speaker{
  background: black;
  height: 25px;
  width: 10%;
  margin-left: 45%;
  position: absolute;
  border-bottom-left-radius: 25px;
  border-bottom-right-radius: 25px;
}
.home-swipe{
  height: 35px;
  width: 96%;
  margin-left: 2%;
  margin-right: 2%;
  bottom: 0px;
  background: white;
  border-top: solid 1px $hover;
  position: absolute;
  border-bottom-left-radius: 20px;
  border-bottom-right-radius: 20px;
  text-align: center;
}
.home-swipe .icon{
  font-size: 16px;
  width: 20%;
  margin-top: 10px;
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
