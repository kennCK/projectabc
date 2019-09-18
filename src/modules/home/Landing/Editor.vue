<template>
  <div class="cw-banner">
    <div class="text text-white">
      <span class="title">
        <h1>Showcase your Creativity.</h1>
      </span>
      <span class="description">
        <h3>
          Explore and make use of our editor tools to create your own template and design. Our editor tools can provide you customizable layouts that will help you in creating better content. 
        </h3>
      </span>
      <span class="feature">
        <h3>
          With its creative adjustment tools, it lets you get creative when you want to and saves time when you need. Learn to use all the features in the editor. 
        </h3>  
      </span>
      <span class="designer">
        <h3>
          Make your designs your source of income.
        </h3>
      </span>
      <span class="description1">
        <h4>
          For graphic designers and editors, you can publish your arts and works in marketplace and get revenue every time customers pick and purchase your designs and templates. Start your investment here. 
        </h4>        
      </span>
    </div>
    <div class="image">
       <img src="../../../assets/img/editor.png" style="margin-bottom: 5px;" width="100%">
    </div>
  </div>
</template>
<style scoped>        
.cw-banner{
  width: 100%;
  background: #33a2d0;
  min-height: 150px;
  overflow-y: hidden;
}
.text{
  width: 45%;
  float: right;
  margin-top: 70px;
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
  margin-top: 50px;
  width: 100%;
  float: right;
  text-align: justify;
}

.text .feature{
  margin-top: 50px;
  width: 100%;
  float: left;
  text-align: justify;
}
.text .designer{
  width: 100%;
  float: left;
  margin-top: 50px;
}

.text .description1{
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
