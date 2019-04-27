<template>
  <div id="updateProducts">
    <span v-if="errorMessage !== null" class="text-danger text-center">
        <label><b>Opps! </b>{{errorMessage}}</label>
    </span>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 600;">Price</label>
      <div>
        <select class="form-control form-control-custom" style="width: 20%; float: left;" v-model="flag">
          <option value="fixed">Fixed</option>
          <option value="variable">Variable</option>
        </select>
        <input type="text" class="form-control form-control-custom" style="float: left; width: 69%; margin-left: 1%;" placeholder="Type price here" v-model="price" @keyup.enter="createRequest()" v-if="flag === 'fixed'">
        <input type="text" class="form-control form-control-custom" style="float: left; width: 22%; margin-left: 1%;" placeholder="Minimum Qty" v-model="minimum" v-if="flag === 'variable'">
        <input type="text" class="form-control form-control-custom" style="float: left; width: 22%; margin-left: 1%;" placeholder="Maximum Qty" v-model="maximum" v-if="flag === 'variable'">
        <input type="text" class="form-control form-control-custom" style="float: left; width: 22%; margin-left: 2%;" placeholder="Type price here" v-model="price" @keyup.enter="createRequest()" v-if="flag === 'variable'">
        <button class="btn btn-primary form-control-custom" style="margin-left: 10px;" @click="createRequest()"><i class="fa fa-plus"></i></button>
      </div>
    </div>
    <div class="price-wrapper" v-if="item.price !== null">
      <div class="price-item" v-for="item, index in item.price" :key="index">
        <select class="form-control form-control-custom" style="width: 20%; float: left;" v-model="item.type">
          <option value="fixed">Fixed</option>
          <option value="variable">Variable</option>
        </select>
        <input type="text" class="form-control form-control-custom" style="float: left; width: 63%; margin-left: 1%;" placeholder="Type price here" v-model="item.price" @keyup.enter="updateRequest(item)" v-if="item.type === 'fixed'">
        <input type="text" class="form-control form-control-custom" style="float: left; width: 20%; margin-left: 1%;" placeholder="Minimum Qty" v-model="item.minimum" v-if="item.type === 'variable'">
        <input type="text" class="form-control form-control-custom" style="float: left; width: 20%; margin-left: 1%;" placeholder="Maximum Qty" v-model="item.maximum" v-if="item.type === 'variable'">
        <input type="text" class="form-control form-control-custom" style="float: left; width: 20%; margin-left: 2%;" placeholder="Type price here" v-model="item.price" @keyup.enter="updateRequest(item)" v-if="item.type === 'variable'">
        <button class="btn btn-primary form-control-custom" style="margin-left: 10px;" @click="updateRequest(item)"><i class="fa fa-sync"></i></button>
        <button class="btn btn-danger form-control-custom" style="margin-left: 10px;" @click="deleteRequest(item.id)"><i class="fa fa-trash"></i></button>
      </div>
    </div>
  </div>
</template>
<style scoped>
  .price-wrapper {
    width: 100%;
    float: left;
    min-height: 50px;
    overflow-y: hidden;
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
      flag: 'fixed',
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
    deleteRequest(id){
      let parameter = {
        id: id
      }
      this.APIRequest('pricings/delete', parameter).then(response => {
        if(response.data > 0){
          this.$parent.retrieve()
        }
      })
    },
    updateRequest(item){
      if(item.type === 'fixed' && isNaN(item.price)){
        this.errorMessage = 'The required field must be a number.'
        return false
      }else if(item.type === 'variable' && isNaN(item.price) && parseInt(item.price) <= 0){
        return false
      }
      this.APIRequest('pricings/update', item).then(response => {
        if(response.data > 0){
          this.errorMessage = null
          this.$parent.retrieve()
        }
      })
    },
    createRequest(){
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
