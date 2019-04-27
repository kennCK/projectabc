<template>
  <div id="updateProducts">
    <span v-if="errorMessage !== null" class="text-danger text-center">
        <label><b>Opps! </b>{{errorMessage}}</label>
    </span>
    <br v-if="errorMessage !== null">
    
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 600;">Price</label>
      <div>
        <select class="form-control form-control-custom" style="width: 45%; float: left;" v-model="newAttribute.payload">
          <option value="color">Color</option>
          <option value="size">Size</option>
        </select>
        <input type="text" class="form-control form-control-custom" style="float: left; width: 40%; margin-left: 10px;" placeholder="Type attribute value here..." v-model="newAttribute.payload_value" @keyup.enter="create()">
        <button class="btn btn-primary form-control-custom" style="margin-left: 10px;" @click="create()"><i class="fa fa-plus"></i></button>
      </div>
    </div>
    <div class="priceList-wrapper" v-if="item.price !== null">
      <div class="container">
        <div class="row priceList-item" v-for="(item, index) in item.price" :key="index">
          <div class="col">
            {{item.flag}}
          </div>
          <div class="col">
            {{item.price}}
          </div>
          <div class="col-auto">
            <button @click="delPrice()" type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>
<style scoped>
  .priceList-wrapper {
    width: 100%;
    background: #f4f4f4;
    border-bottom: 1px #ccc solid;
    border-left: 1px #ccc solid;
    border-right: 1px #ccc solid;
    border-top: 1px #ccc solid;
    border-radius: 0.25em
  }
  .priceList-item {
    border-bottom: 1px #ccc solid
  }
  .price-content{
    width: 100%;
    float: left;
    min-height: 50px;
    overflow-y: hidden;
  }
  .price-content .title{
    height: 50px;
    width: 100%;
    float: left;
    font-weight: 600;
    line-height: 50px;
  }
  .price-item{
    width: 100%;
    float: left;
    height: 50px;
    margin-bottom: 15px;
  }
  .form-control-custom {
    height: 50px !important;
  }
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
  },
  props: ['item'],
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      flag: null,
      price: null,
      minimum: null,
      maximum: null
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    validate(){
      if(this.minimum !== null && this.minimum !== '' && this.maximum !== null && this.maximum !== '' && this.price !== null && this.price !== ''){
        return true
      }
      return false
    },
    delPrice(parameter){
      this.APIRequest('pricings/delete', parameter).then(response => {
        if(response.data > 0){
          this.$parent.retrieve()
        }
      })
    },
    addPrice(){
      if(parseFloat(this.price) > 0 && this.flag === 'fixed'){
        this.errorMessage = null
        let parameter = {
          account_id: this.user.userID,
          product_id: this.item.id,
          type: this.flag,
          minimum: null,
          maximum: null,
          price: this.price
        }
        this.APIRequest('pricings/create', parameter).then(response => {
          if(response.data > 0){
            this.$parent.retrieve()
          }
        })
      }else if(this.validate() && this.flag === 'variable'){
        this.errorMessage = null
        let parameter = {
          account_id: this.user.userID,
          product_id: this.item.id,
          type: this.flag,
          minimum: this.minimum,
          maximum: this.maximum,
          price: this.price
        }
        this.APIRequest('pricings/create', parameter).then(response => {
          if(response.data > 0){
            this.$parent.retrieve()
          }
        })
      }
    }
  }
}
</script>
