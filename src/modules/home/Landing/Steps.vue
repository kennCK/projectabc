<template>
  <div class="cw-snetwork">
    <div class="text text-green">
      <h1>Do it in just 4 Steps</h1>
    </div>
    <div class="card-holder">
      <div class="card" v-for="item, index in data" v-if="data !== null">
        <img class="card-img-top" src="../../../assets/img/step.png" v-if="index === 0">
        <img class="card-img-top" src="../../../assets/img/step.png" v-if="index === 1">
        <img class="card-img-top" src="../../../assets/img/step.png" v-if="index === 2">
        <img class="card-img-top" src="../../../assets/img/step.png" v-if="index === 3">
        <div class="card-body">
          <h5 class="card-title text-green">{{item.title}}</h5>
          <p class="card-text">{{item.description}}</p>
          <button class="btn btn-primary">Step {{index + 1}}</button>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.cw-snetwork{
  width: 100%;
  float: left;
  min-height: 650px;
  overflow-y: hidden;
}

.text{
  width: 90%;
  float: left;
  margin-right: 10%;
  margin-top: 50px;
  height: 50px;
  margin-left: 5%;
  margin-right: 5%;
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
  margin-left: 10%;
  float: left;
  margin-top: 150px;
  display: block;
}
.card-holder{
  width: 90%;
  float: left;
  margin-left: 5%;
  margin-right: 5%;
}
.card{
  width: 24%;
  float: left;
  margin-right: 1%;
  margin-top: 50px;
  margin-bottom: 50px;
}
.card-body{
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

  .card{
    width: 100%;
    margin-left: 0%;
    margin-right: 0%;
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
      data: [
        {title: 'Create or purchase template', description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', image: '../../assets/img/banner.png'},
        {title: 'Add entries', description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', image: '../../../assets/img/banner.png'},
        {title: 'Review entries', description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', image: '../../../assets/img/banner.png'},
        {title: 'Checkout and Print', description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', image: '../../../assets/img/banner.png'}
      ]
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    }
  }
}
</script>
