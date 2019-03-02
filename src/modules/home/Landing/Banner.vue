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
      <img src="../../../assets/img/banner.png" style="margin-bottom: 5px;" width="100%">
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
  height: 600px;
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
