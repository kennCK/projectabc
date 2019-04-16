<template>
	<div class="holder">
    <create></create>
    <div class="products-holder" v-for="item, index in data" @click="redirect('/product/edit/' + item.code)">
      <div class="products-image">
        <img :src="config.BACKEND_URL + item.featured[0].url" v-if="item.featured !== null">
        <i class="fa fa-image" v-else></i>
      </div>
      <div class="products-details">
        <div class="products-title">
          <label style="padding-top: 5px;"><b>{{item.title}}</b></label>
          <label>{{item.description}}</label>
        </div>  
        <div class="products-price">
          <label v-if="item.price !== null">
            <label v-if="item.price.length === 1">PHP {{item.price[0].price}}</label>
            <label v-if="item.price.length > 1">PHP {{item.price[item.price.length - 1].price + ' - ' + item.price[0].price}}</label>
          </label>
        </div>
      </div>
    </div>
    <empty v-if="data === null" :title="'Looks like you have not added a product!'" :action="'Click the New Product Button to get started.'"></empty>
	</div>
</template>
<style>
	.holder{  
    width: 98%;
    float: left;
    margin-right: 2%;
	  margin-top: 25px;
	  margin-bottom: 50px;
	}
  .results{
    width: 100%;
    float: left;
    margin-top: 25px;
  }
  .item:hover{
    cursor: pointer;
  }

  .products-holder{
    width: 24%;
    float: left;
    height: 300px;
    margin-right: 1%;
    border: solid 1px #ddd;
    margin-bottom: 10px;
    color: #555;
    margin-top: 25px;
  }
  .products-holder:hover{
    cursor: pointer;
    border: solid 1px #ffaa81;
    background: #ffaa81;
    color: #fff;
  }

  .products-image{
    width: 100%;
    float: left;
    position: relative;
    height: 250px;
    text-align: center;
  }

  .products-image img{
    height: 250px;
    float: left;
    width: 100%;
  }
  .products-image .fa-image{
    font-size: 150px;
    line-height: 250px;

  }
  .products-details{
    height: 50px;
    width: 100%;
    float: left;
    border-top: solid 1px #ddd;
  }
  .products-title{
    width: 50%;
    float: left;
    height: 50px;
  }
  .products-title label{
    width: 100%;
    float: left;
    font-size: 12px;
    margin: 0px !important;
    padding-left: 10px;
  }
  .products-price{
    width: 50%;
    float: left;
    height: 50px;
    line-height: 50px;
    font-weight: 600;
    text-align: right;
    padding-right: 5px;
  }

  .products-wishlist{
    height: 50px;
    text-align: center;
    line-height: 50px;
    width: 100%;
    position: absolute;
    top: 50%;
    z-index: 10;
    display: none;
  }

  .products-wishlist:hover, .products-wishlist i:hover, .products-wishlist label:hover{
    cursor: pointer;
  }

  .products-wishlist label{
    line-height: 50px;
    float: left;
    width: 50%;
    text-align: center;
  }
  
  .products-wishlist i{
    font-size: 32px;
    line-height: 50px;
  }

  .products-holder:hover .products-wishlist{
    display: block;
  }

</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
    AUTH.checkPlan()
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      data: null,
      selectedItem: null,
      selectedIndex: null
    }
  },
  components: {
    'create': require('modules/product/Create.vue'),
    'empty': require('modules/empty/Empty.vue')
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    retrieve(){
      let parameter = {
        condition: [{
          value: this.user.userID,
          column: 'account_id',
          clause: '='
        }],
        account_id: this.user.userID
      }
      $('#loading').css({'display': 'block'})
      this.APIRequest('products/retrieve', parameter).then(response => {
        $('#loading').css({'display': 'none'})
        if(response.data.length > 0){
          this.data = response.data
          if(this.selectedItem !== null){
            this.selectedItem = this.data[this.selectedIndex]
          }
        }else{
          this.data = null
          this.selectedIndex = null
          this.selectedItem = null
        }
      })
    },
    editModal(item, index){
      for (var i = 0; i < this.$children.length; i++) {
        if(this.$children[i].$el.id === 'updateProducts'){
          this.selectedItem = item
          this.selectedIndex = index
          this.$children[i].modal()
        }
      }
    }
  }
}
</script>
