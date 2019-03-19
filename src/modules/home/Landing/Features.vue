<template>
	<div class="cw-features">
    <div class="header">
      <span class="title text-green">
        <h1>Made for you to have more time to relax</h1>
      </span>
      <span class="description">
        <h6></h6>
      </span>
    </div>
    <div class="holder">

      <span class="item" v-for="item, index in data" v-if="data !== null">
        <span class="icon text-green text-center">
          <i :class="item.icon"></i>
        </span>
        <span class="title text-center text-green">
          <h5>{{item.title}}</h5>
        </span>
        <span class="description">
          {{item.description}}
        </span>
      </span>
    </div>
	</div>
</template>
<style scoped>
.cw-features{
  width: 100%;
  float: left;
  min-height: 500px;
  background: #fff;
  overflow-y: hidden;
}
.header{
  width: 90%;
  float: left;
  margin-left: 5%;
  margin-right: 5%;
  margin-top: 50px;
}
.holder{
  width: 90%;
  float: left;
  margin: 50px 5% 0 5%;
}
.item{
  width: 21%;
  float: left; 
  margin-right: 2%;
  min-height: 350px;
  margin-left: 2%;
}
.item span{
  width: 100%;
  float: left;
}
.item .icon{
  font-size: 50px;
}
.item .title{
  margin-top: 25px;
}

.item .description{
  text-align: justify;
  margin-top: 25px;
}

@media screen and (max-width: 992px){
  .holder, .item{
    width: 90%;
    margin: 25px 5% 0 5%;
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
        {title: 'Comments', description: 'Allows our customers and printing partners to exchange ideas and provide timely feedback through our collaboration feature for design specific concerns.', icon: 'fas fa-comments'},
        {title: 'ID Generator', description: 'Automatically generates ID based on specifications and the ID template created', icon: 'fas fa-id-badge'},
        {title: 'Marketplace', description: 'ID templates and designs can be purchased for a hassle free ID experience. This is also where our printing partners can sell and advertise their products.', icon: 'fas fa-store'},
        {title: 'Messenger', description: 'Ease of communication between users through an embedded messenger feature within our platform.', icon: 'fab fa-facebook-messenger'},
        {title: 'Pricing', description: 'Customers can view the priceing of our different printing partners, as this is one way to promote transparency', icon: 'fas fa-money-bill-alt'},
        {title: 'Printing', description: 'A fully integrated printing experience at just one click of the button. This is possible through integration with printing partners who meet the compatibility requirements.', icon: 'fas fa-print'},
        {title: 'Template Editor', description: 'Creativity knows no bounds just as how you can put your dream IDs into reality through our interactive template editor.', icon: 'fas fa-edit'},
        {title: 'Verification', description: '2-step verification requires our customer and printing partners to confirm design specifications before the IDs can be generated.', icon: 'fas fa-check'}
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
