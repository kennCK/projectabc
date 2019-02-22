<template>
  <div>
    <div class="modal fade" id="shippingAddressModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Shipping Address</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="text-white">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <span v-if="errorMessage !== null" class="text-danger text-center">
                <label><b>Opps! </b>{{errorMessage}}</label>
            </span>
            <div class="form-group">
              <input type="radio" class="form-check-input" id="exampleCheck1" name="address" value="billing" v-model="address">
              <label class="form-check-label" for="exampleCheck1"><b>Company Address</b></label> <br>
            </div>
            <div class="form-group alert alert-success" v-if="item.account_details !== null">
              <i class="fas fa-map-marker-alt"></i>
              {{item.account_details.billing.company}}, {{item.account_details.billing.address + ',' + item.account_details.billing.city + ' ' + item.account_details.billing.postal_code}}, {{item.account_details.billing.state + ', ' + item.account_details.billing.country}}
            </div>

            <div class="form-group">
              <input type="radio" class="form-check-input" id="exampleCheck1" name="address" value="other" v-model="address">
              <label class="form-check-label" for="exampleCheck1"><b>Use this address</b></label>
              <textarea type="text" class="form-control" placeholder="Type your address here..." v-model="newAddress" rows="5"  v-if="item.shipping_address === null"></textarea>
              <textarea type="text" class="form-control" placeholder="Type your address here..." v-model="item.shipping_address.payload_value" rows="5"  v-if="item.shipping_address !== null"></textarea>
            </div>

            <div class="form-group">
              <label class="form-check-label" for="exampleCheck1"><b>Shipping Notes</b></label>
              <textarea type="text" class="form-control" placeholder="Type additional notes here(Optional)..." v-model="notes" rows="5" v-if="item.shipping_address === null"></textarea>
              <textarea type="text" class="form-control" placeholder="Type additional notes here(Optional)..." v-model="item.shipping_address.notes" rows="5" v-if="item.shipping_address !== null"></textarea>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#shippingAddressModal">Close</button>
              <button type="button" class="btn btn-primary" @click="update()">Update</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.form-check-input{
  float: left !important;
  position: inherit !important;
  margin-left: 0px;
}
.form-check-label{
  padding-left: 10px !important;
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
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      address: 'billing',
      newAddress: null,
      notes: null
    }
  },
  props: ['item'],
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    update(){
      if(this.item.shipping_addresses === null){
        let parameter = {
          checkout_id: this.item.id,
          payload: this.address,
          payload_value: (this.address === 'billing') ? this.item.account_details.billing.id : this.newAddress,
          notes: this.notes
        }
        this.APIRequest('shipping_addresses/create', parameter).then(response => {
          if(response.data > 0){
            this.$parent.retrieve()
          }
        })
      }else{
        let parameter = {
          id: this.item.shipping_address.id,
          payload: this.address,
          payload_value: (this.address === 'billing') ? this.item.account_details.billing.id : this.item.shipping_address.payload_value,
          notes: this.item.shipping_address.notes
        }
        this.APIRequest('shipping_addresses/update', parameter).then(response => {
          if(response.data === true){
            this.$parent.retrieve()
          }
        })
      }
    }
  }
}
</script>
