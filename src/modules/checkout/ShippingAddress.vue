<template>
  <div>
    <div class="modal fade" id="shippingAddressModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <div class="form-group alert alert-success" v-if="address === 'billing'">
              <i class="fas fa-map-marker-alt"></i>
              {{item.account_details.billing.company}}, {{item.account_details.billing.address + ',' + item.account_details.billing.city + ' ' + item.account_details.billing.postal_code}}, {{item.account_details.billing.state + ', ' + item.account_details.billing.country}}
            </div>

            <div class="form-group">
              <input type="radio" class="form-check-input" id="exampleCheck1" name="address" value="other" v-model="address">
              <label class="form-check-label" for="exampleCheck1"><b>Use this address</b></label>
              <textarea type="text" class="form-control" placeholder="Type code here..." v-model="newAddress" rows="10"></textarea>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#shippingAddressModal">Close</button>
              <button type="button" class="btn btn-primary">Update</button>
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
      newAddress: null
    }
  },
  props: ['item'],
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    }
  }
}
</script>
