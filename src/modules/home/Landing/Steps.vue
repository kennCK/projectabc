<template>
  <div class="cw-snetwork">
    <div class="text text-green">
      <h1>Four easy steps to your printed ID</h1>
    </div>
    <div class="card-holder">
      <div class="card" v-for="item, index in data" v-if="data !== null">
        <img class="card-img-top" src="../../../assets/img/template.png" v-if="index === 0">
        <img class="card-img-top" src="../../../assets/img/entry.png" v-if="index === 1">
        <img class="card-img-top" src="../../../assets/img/review.png" v-if="index === 2">
        <img class="card-img-top" src="../../../assets/img/checkout.png" v-if="index === 3">
        <div class="card-body">
          <h5 class="card-title text-green">Step {{index + 1}}: {{item.title}}</h5>
          <p class="card-text">{{item.description}}</p>
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
        {title: 'Create or Choose a Template', description: 'Create custom templates using our editor tool or choose from the ID templates gallery', image: '../../assets/img/banner.png'},
        {title: 'Data Entry', description: 'All the information required for each ID you create will automatically be exported to the template. No need to go to the editor to edit each template. ', image: '../../../assets/img/banner.png'},
        {title: 'Review', description: 'Once IDs are generated you may review them in the gallery section.', image: '../../../assets/img/banner.png'},
        {title: 'Check Out and Print', description: 'When you are satisfied with your output, you can now proceed to checkout and print using your printer or from any of our partner printers near your locale.', image: '../../../assets/img/banner.png'}
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
