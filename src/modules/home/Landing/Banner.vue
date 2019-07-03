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
      <div class="device">
      </div>
   </div> 
 </div>
</template>
</span>
<style scoped>
.device{
  border: 1px solid black;
  width: 350px;
  float: left;
  height: 400px;
  overflow-y: auto;
  margin-top: 40px;
  margin-bottom: 20px;
  font-size: 90px;
}
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
