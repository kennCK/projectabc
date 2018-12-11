<template>
	<div class="cw-banner">
    <div class="text text-white">
      <span class="title">
        <h1>Built to ease the editing and printing of Identification Card.</h1>
      </span>
      <span class="description">
        <h4>
          ID Factory is a web-based ID editor and printing inspired to ease the bottleneck of the hassle of manual editing of photos, signatures, and details of every employee.
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
  height: 500px;
  background: #028170;
}
.text{
  width: 40%;
  float: left;
  margin-left: 10%;
  margin-top: 100px;
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
  margin-right: 10%;
  float: left;
  margin-top: 50px;
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
