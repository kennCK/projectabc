<template>
  <div class="cw-banner">
    <div class="text text-white">
      <span class="title">
        <h1>Manage your files Seamlessly</h1>
      </span>
      <span class="description">
        <h3> 
          We always make sure that everything is convenient and efficient for you. 
        </h3>
      </span>
      <span class="partners">
        <h3>
          To our printing partners, with file management you can organize well your designs and templates. Tracking down all completed transactions will be easier. Effective file management helps you save time, work smoothly and handle current transactions with no hassle.
        </h3>
      </span>
      <span class="customers">
        <h3>
          To our valued customers, you can also attach and publish your designs and template and sort your files in a systematic manner.
        </h3>
      </span>
    </div>
    <div class="image">
       <img src="../../../assets/img/filemanagement.png" style="margin-bottom: 5px;" width="100%">
    </div>
  </div>
</template>
<style scoped>
.cw-banner{
  width: 100%;
  background: #f4c236;
  min-height: 150px;
  overflow-y: hidden;
}
.text{
  width: 45%;
  float: right;
  margin-top: 50px;
  margin-bottom: 70px;
  margin-right: 5%;
} 
.text .title{
  width: 100%;
  float: left;
  text-align: left;
  margin-right: 50px;
}
.title h1{
  font-size: 40px;
}
.text .description{
  margin-top: 25px;
  width: 100%;
  float: right;
  text-align: justify;
}
.text .partners{
  margin-top: 50px;
  width: 100%;
  float: left;
  text-align: justify;
}
.text .customers{
  margin-top: 50px;
  width: 100%;
  float: left;
  text-align: justify;
}

.image{
  width: 40%;
  margin-right: 5%;
  margin-left: 5%;
  float: left;
  display: block;
  margin-top: 125px;
  margin-bottom: 125px;
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
