<template>
  <div class="inventories-holder">
    <div class="error text-danger" v-if="errorMessage !== null">{{errorMessage}}</div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 600;">Stocks</label>
      <div>
        <input type="text" class="form-control form-control-custom" style="float: left; width: 50%;" placeholder="Type qty value here..." v-model="newItem.qty" @keyup.enter="create()">
        <button class="btn btn-primary form-control-custom" style="margin-left: 10px;" @click="create()"><i class="fa fa-plus"></i></button>
      </div>
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 600;">Available:</label>
      <label v-if="parseInt(item.qty) > 0" class="alert alert-success">{{item.qty}}</label>
      <label v-if="parseInt(item.qty) <= 0" class="alert alert-warning">Out of Stock</label>
    </div>
    <div class="inventories-content" v-if="item.inventories !== null">
      <table class="table table-bordered">
        <thead>
          <tr>
            <td>Qty</td>
            <td>Data Added</td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="itemI, indexI in item.inventories">
            <td>
              {{itemI.qty}}
            </td>
            <td>
              {{itemI.created_at_human}}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<style scoped>
.inventories-holder{
  width: 100%;
  float: left;
  min-height: 100px;
  overflow-y: hidden;
}
.error{
  width: 100%;
  float: left;
  line-height: 50px;
}
.inventories-content{
  width: 100%;
  float: left;
  min-height: 50px;
  overflow-y: hidden;
}
.inventories-content .title{
  height: 50px;
  width: 100%;
  float: left;
  font-weight: 600;
  line-height: 50px;
}
.inventories-item{
  width: 100%;
  float: left;
  height: 50px;
  margin-bottom: 15px;
}
.form-control-custom{
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
      newItem: {
        product_id: this.item.id,
        qty: null
      }
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    create(){
      if(this.newItem.qty !== null && this.newItem.qty !== '' && isNaN(this.newItem.qty) === false){
        this.APIRequest('product_inventories/create', this.newItem).then(response => {
          if(response.data > 0){
            this.newItem.qty = null
            this.errorMessage = null
            this.$parent.retrieve()
          }
        })
      }else{
        this.errorMessage = 'Input must be a number greater than 0.'
      }
    },
    deleteItem(item){
      let parameter = {
        id: item.id
      }
      this.APIRequest('product_inventories/delete', parameter).then(response => {
        this.$parent.retrieve()
      })
    },
    update(item){
      if(item.qty !== null && item.qty !== '' && isNaN(item.qty) === false){
        this.APIRequest('product_inventories/update', item).then(response => {
          if(response.data === true){
            this.$parent.retrieve()
          }
        })
      }else{
        this.errorMessage = 'Input must be a number greater than 0.'
      }
    }
  }
}
</script>
