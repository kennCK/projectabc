<template>
	<div class="cw-banner">
    <div class="text text-white">
      <span class="title">
        <h1>Your one-stop shop ID printer.</h1>
      </span>
      <span class="description">
        <h4>
          ID Factory is an online application that lets you design and create custom IDs. Ideal for companies, corporate events and many more.
          (Create. Archive. Print. All in one place.)
        </h4>
        <h4>
          <a href="" class="" data-aos="zoom-in" data-aos-delay="400"> Create an ID template </a>
        </h4>
      </span>
    </div>
    <div class="image">
      <img src="../../../assets/img/banner.png" style="margin-bottom: 5px;" width="100%">
    </div>
	</div>
</template>
<style scoped>
.cw-banner{
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
