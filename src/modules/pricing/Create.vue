<template>
  <div>
    <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#createPriceModal"><i class="fa fa-plus"></i> New Price
    </button>
    <div class="modal fade" id="createPriceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">New Price</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="text-white">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <span v-if="errorMessage !== null" class="text-danger text-center">
                <label><b>Opps! </b>{{errorMessage}}</label>
            </span>
            <br v-if="errorMessage !== null">
            <br>
            <div class="form-group">
              <label for="exampleInputEmail1">Minimum # of Print</label>
              <input type="text" class="form-control" placeholder="Type minimum here..." v-model="minimum">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Maximum # of Print</label>
              <input type="text" class="form-control" placeholder="Type maximum here..." v-model="maximum">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Price</label>
              <input type="text" class="form-control" placeholder="PHP 0.00" v-model="price">
            </div>

          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#createPriceModal">Cancel</button>
              <button type="button" class="btn btn-primary" @click="submit()">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      product_id: 1,
      minimum: null,
      maximum: null,
      price: null
    }
  },
  props: ['params'],
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    submit(){
      if(this.validate()){
        let parameter = {
          account_id: this.user.userID,
          product_id: this.product_id,
          minimum: this.minimum,
          maximum: this.maximum,
          price: this.price
        }
        this.APIRequest('pricings/create', parameter).then(response => {
          if(response.data > 0){
            $('#createPriceModal').modal('hide')
            this.$parent.retrieve()
          }
        })
      }
    },
    validate(){
      if(this.minimum !== null || this.minimum !== '' || this.maximum !== null || this.maximum !== '' || this.price !== null || this.price !== ''){
        return true
      }
      return false
    }
  }
}
</script>
