<template>
  <div class="cw-banner bg-green">
    <div class="text text-white">
      <span class="title">
        <h1>Experience our Communication Tools.</h1>
      </span>
      <span class="description">
        <h3>
          As a customer-first business, we need constant communication to ensure quality prints all the time. Always get in touch and easily connect with the printing partners to make orders, get customer support and find deals through the messenger and comment feature.
        </h3>
      </span>
      <span class="feature1">
        <h3>
          Get more with Chat Extensions
        </h3>
      </span>
      <span class="descriptionFeature1">
        <h4>
          Search and find products right in your chatbox for faster enquiries and transactions. 
        </h4>
      </span>
      <span class="feature2">
        <h3>
          Hop on an Audio Call
        </h3>
      </span>
      <span class="descriptionFeature2">
        <h4>
          Too busy to chat? You can hop on our audio call to assist you swiftly.  
        </h4>
      </span>
    </div>
    <div class="image">
      <img src="../../../assets/img/communication.png" style="margin-bottom: 5px;" width="100%">
    </div>
  </div>
</template>
<style scoped>
.cw-banner{
  width: 100%;
  float: left;
  background: #4d529f;
  min-height: 150px;
  overflow-y: hidden;
}
.text{
  width: 45%;
  float: left;
  margin-left: 5%;
  margin-top: 100px;
  margin-bottom: 100px;
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
.text .feature1{
  width: 100%;
  float: left;
  margin-top: 50px;
  text-align: justify;
}
.text .feature2{
  width: 100%;
  float: left;
  margin-top: 50px;
  text-align: justify;
}
.image{
  width: 40%;
  margin-right: 5%;
  margin-left: 5%;
  float: left;
  display: block;
  margin-top: 50px;
  margin-bottom: 100px;
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
