<template>
  <div id="updateProducts">
    <span v-if="errorMessage !== null" class="text-danger text-center">
        <label><b>Opps! </b>{{errorMessage}}</label>
    </span>
    <br v-if="errorMessage !== null">
    
    <div class="form-group">
      <label for="exampleInputEmail1">Prices</label>
      <div>
        <select class="form-control form-control-custom" style="width: 100%; float: left;" v-model="flag">
          <option value="fixed">Fixed</option>
          <option value="variable">Variable</option>
        </select>
      </div>
    </div>
    <br>
    <br>
    <div class="input-group" style="width:100%;" v-if="flag === 'fixed'">
      <label class="text-danger" v-if="errorMessage !== null">{{errorMessage}}</label>
      <span class="input-group-addon" id="addon-1">Price</span>
      <input type="text" class="form-control form-control-custom" placeholder="..." aria-describedby="addon-1" v-model="price">
      <button class="btn btn-primary form-control-custom" style="margin-left: 5px;" @click="addPrice()">Submit</button>
    </div>

    <div class="input-group" style="width:100%;" v-if="flag === 'variable'">
      <span class="input-group-addon" id="addon-1">Minimum</span>
      <input type="text" class="form-control form-control-custom" placeholder="..." aria-describedby="addon-1" v-model="minimum" >
      <span class="input-group-addon" id="addon-1">Maximum</span>
      <input type="text" class="form-control form-control-custom" placeholder="..." aria-describedby="addon-1" v-model="maximum" >
      <span class="input-group-addon" id="addon-1">Price</span>
      <input type="text" class="form-control form-control-custom" placeholder="..." aria-describedby="addon-1" v-model="price" >
      <button class="btn btn-primary form-control-custom" style="margin-left: 5px;" @click="addPrice()">Submit</button>
    </div>
    <br>
    <div class="prices-content" v-if="item.type !== null">
      <label class="title">Fixed</label>
      <div class="prices-item" v-for="itemType, indexSize in item.type">
        <input type="text" class="form-control form-control-custom" style="float: left; width: 80%;" placeholder="Type variation value here..." v-model="itemType.payload_value" @keyup.enter="update(itemSize)">
        <button class="btn btn-primary form-control-custom" style="margin-left: 10px;" @click="update(itemSize)">
          <i class="fa fa-sync"></i>
        </button>
        <button class="btn btn-danger form-control-custom" style="margin-left: 10px;" @click="deleteItem(itemSize)">
          <i class="fa fa-trash"></i>
        </button>
      </div>
    </div>
    <div class="prices-content" v-if="item.type !==  null">
      <label class="title">Variable</label>
      <div class="prices-item" v-for="itemColor, indexColor in item.color">
        <input type="text" class="form-control form-control-custom" style="float: left; width: 80%;" placeholder="Type variation value here..." v-model="itemColor.payload_value" @keyup.enter="update(itemColor)">
        <button class="btn btn-primary form-control-custom" style="margin-left: 10px;" @click="update(itemColor)">
          <i class="fa fa-sync"></i>
        </button>
        <button class="btn btn-danger form-control-custom" style="margin-left: 10px;" @click="deleteItem(itemColor)">
          <i class="fa fa-trash"></i>
        </button>
      </div>
    </div>

  </div>
</template>
<style scoped>
  .prices-content{
    width: 100%;
    float: left;
    min-height: 50px;
    overflow-y: hidden;
  }
  .prices-content .title{
    height: 50px;
    width: 100%;
    float: left;
    font-weight: 600;
    line-height: 50px;
  }
  .prices-item{
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
