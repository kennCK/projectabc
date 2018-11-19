<template>
  <div class="holder">
    <span class="header"><i class="fa fa-paypal"></i>PayPal</span>
    <span class="content">
      <span class="inputs">
        <div class="form-group" style="margin-top: 25px;">
          <label for="address">Paypal</label>
          <input type="text" class="form-control" placeholder="Enter Nickname">
        </div>

        <button class="btn btn-primary" style="margin-bottom: 25px;" >Authorize</button>
      
      </span>
      <span class="sidebar">
      </span>
    </span>
    <span class="header"><i class="fa fa-credit-card"></i>Credit Card</span>
    <span class="content">
      <span class="inputs">
            
            <div :class="{complete}" class="">
              <div class="form-group">
                <label for="address">Card Number</label>
                <card-number class="stripe-element card-number"
                  ref="cardNumber"
                  :stripe="stripeSK"
                  @change="number = $event.complete"
                  :options="options"
                />
              </div>

              <div class="form-group">
                <label for="address">Expiration</label>
                <card-expiry class="stripe-element card-expiry"
                  ref="cardExpiry" 
                  :stripe="stripeSK" 
                  @change="expiry = $event.complete"
                  :options="options"
                />
              </div>

              <div class="form-group">
                <label for="address">CVC</label>
                  <card-cvc class='stripe-element card-cvc'
                    ref='cardCvc'
                    :stripe="stripeSK" 
                    @change="cvc = $event.complete" 
                    :options="options"
                  />
                </div>
            </div>

        <button class="btn btn-primary" style="margin-bottom: 25px;" @click="createCustomer()">Authorize</button>
      
      </span>
      <span class="sidebar">
      </span>
    </span>
  </div>
</template>
<style scoped>
.holder{
  width: 95%;
  float: left;
  margin-left: 5%;
}
.header{
  width: 100%;
  height: 50px;
  line-height: 50px;
  font-size: 24px;
  border-bottom: solid 1px #ddd;
  float: left;
}
.content{
  width: 100%;
  min-height: 50px;
  float: left;
  overflow-y: hidden;
}
.inputs{
  width: 65%;
  float: left;
  margin-right: 5%;
  min-height: 50px;
  overflow-y: hidden;
}
.sidebar{
  width: 30%;
  float: left;
  min-height: 50px;
  overflow-y: hidden;
}
.sidebar-header{
  height: 40px;
  line-height: 40px;
  width: 100%;
  float: left;
}
.sidebar .image{
  width: 100%;
  float: left;
  min-height: 200px;
  overflow-y: hidden;
  text-align: center;
}
.image i{
  font-size: 150px;
  line-height: 200px;
}
.image img{
  border-radius: 5px;
}
.custom-block{
  width: 100%;
  float: left;
}
.custom-block input{
  display: none;
}

.stripe-element{
  height: 45px;
  display: block;
  width: 100%;
  padding: .90rem .75rem;
  font-size: 12px;
  background-color: #fff;
  background-image: none;
  background-clip: padding-box;
  border: 1px solid rgba(0,0,0,.15);
  border-radius: .25rem;
  transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}

.stripe-element .card-number, .stripe-element .card-expiry, .stripe-element .card-cvc{
  padding: 0px;
}

.StripeElement{
  padding: .90rem .75rem;
  color: #495057;
  line-height: 1.25;
}


@media screen and (max-width: 992px){
  .holder{
    width: 96%;
    margin-left: 2%;
    margin-right: 2%;
  }
  .sidebar, .inputs{
    width: 100%;
    margin-right: 0%;
    margin-left: 0%;
  }
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import axios from 'axios'
import CONFIG from '../../config.js'
import OPKEYS from '../../payment.js'
import CardExpiry from '../../components/stripe/CardExpiry'
import CardCvc from '../../components/stripe/CardCvc'
import CardNumber from '../../components/stripe/CardNumber'
import { Stripe } from '../../components/stripe/stripeElements'
export default {
  mounted(){
  },
  data(){
    return {
      user: AUTH.user,
      tokenData: AUTH.tokenData,
      config: CONFIG,
      data: null,
      complete: false,
      number: false,
      expiry: false,
      cvc: false,
      stripeSK: (OPKEYS.flag === false) ? OPKEYS.stripe.dev_pk : OPKEYS.stripe.live_pk,
      options: {
      }
    }
  },
  components: {
    CardExpiry,
    CardCvc,
    CardNumber
  },
  methods: {
    createCustomer(){
      $('#loading').css({'display': 'block'})
      Stripe.createSource().then(data => {
        if(data.error !== undefined){
          $('#loading').css({'display': 'none'})
          // console.log(data.error)
          this.errorMessage = data.error.message
        }else{
          let parameter = {
            email: this.user.email,
            source: data.source,
            account_id: this.user.userID,
            name: 'Kennette Canales',
            payment_keys: OPKEYS
          }
          this.APIRequest('stripes/create', parameter).then(response => {
            if(response.data > 0){
              $('#loading').css({'display': 'none'})
            }
          })
        }
      })
    }
  }
}
</script>
