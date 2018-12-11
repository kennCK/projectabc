<template>
  <div class="cw-banner bg-green">
    <div class="text text-white">
      <span class="title">
        <h1>Comment and Chat with our Printing Partners</h1>
      </span>
      <span class="description">
        <h4>
          Best way of communication between you and our printing partners. Chat or Comment to your created entries of your templates.
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
  background: #22b173;
  height: 650px;
}
.text{
  width: 45%;
  float: left;
  margin-left: 5%;
  margin-top: 200px;
}
.text .title{
  width: 100%;
  float: left;
}
.title h1{
  font-size: 40px;
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
  margin-left: 5%;
  float: left;
  margin-top: 150px;
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
