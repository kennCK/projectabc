<template>
  <div class="holder">
    <span class="list" v-if="data !== null">
      <span class="items">
        <span class="title">
          <b>Your Items</b>
        </span>
        <span class="item" v-for="item, index in data[0].items" v-if="data[0].items !== null">
          <span class="objects-holder" v-if="item.payload === 'template'">
            <objects :objects="item.objects" v-if="item.objects !== null"></objects>
          </span>
          <span class="objects-holder" v-if="item.payload === 'employee' && item.employee.front_objects !== null">
            <objects :objects="item.employee.front_objects"></objects>
          </span>
          <span class="objects-holder" v-if="item.payload === 'employee' && item.employee.back_objects !== null">
            <objects :objects="item.employee.back_objects"></objects>
          </span>
          <span class="details" v-if="item.payload === 'template' || (item.payload === 'employee' && (item.employee.back_objects === null || item.employee.front_objects === null))">
              <label style="margin-top: 10px;" v-if="item.payload === 'employee'">
                Price: Php {{item.employee.price}}
                <i class="fa fa-trash pull-right text-danger delete" style="font-size: 24px; padding-right: 25px;" @click="remove(item.id)"></i>
              </label>
              <label style="margin-top: 10px;" v-if="item.payload === 'template'">
                <b>{{item.template.title}}</b>
                <i class="fa fa-trash pull-right text-danger delete" style="font-size: 24px; padding-right: 25px;" @click="remove(item.id)"></i>
              </label>
              <label v-if="item.payload === 'template'">Price Php {{item.template.price}}</label>
              <label v-if="item.payload === 'template'">Cetegory: {{item.template.categories}}</label>
              <label v-if="item.payload === 'template'">
                <rating :payload="'template'" :payloadValue="item.payload_value"></rating>
              </label>
          </span>
          <span class="two-details" v-if="item.payload === 'employee' && item.employee.back_objects !== null && item.employee.front_objects !== null">
              <label style="margin-top: 10px;">
                Price Php {{item.employee.price}}
                <i class="fa fa-trash pull-right text-danger delete" style="font-size: 24px; padding-right: 25px;" @click="remove(item.id)"></i>
              </label>
          </span>
        </span>
      </span>
      <span class="sidebar">
        <span class="title">Order Summary</span>
        <span class="item">
          <label>Subtotal</label>
          <label class="pull-right" style="padding-right: 10px;">PHP {{data[0].sub_total}}</label>
        </span>
        <span class="item">
          <label>Tax</label>
          <label class="pull-right" style="padding-right: 10px;">PHP {{data[0].tax}}</label>
        </span>
        <span class="item" style="border-bottom: 0px;">
          <label><b>Total</b></label>
          <label class="pull-right" style="padding-right: 10px;"><b>PHP {{data[0].total}}</b></label>
        </span>
        <span class="item" style="border-bottom: 0px;">
          {{success}}
        </span>
        <span class="item" style="border-bottom: 0px;">
            <PayPal
              v-bind:amount="data[0].total"
              currency="PHP"
              :client="paypal"
              :button-style="myStyle"
              env="sandbox"
              payment-completed="">
            </PayPal>
        </span>
        <span class="item" style="border-bottom: 0px;" v-if="method !== null && method.stripe !== null">
          <label>Active Payment Method</label>
          
          <label class="pull-right" style="padding-right: 10px;">******** {{method.stripe.last4}} <i class="fa fa-edit text-danger" @click="redirect('/profile/payment_method')"></i></label>
        </span>
        <span class="item" style="border-bottom: 0px;" v-if="method !== null && method.paypal !== null">
          <label>Active Payment Method</label>
          
          <label class="pull-right" style="padding-right: 10px;"> {{method.paypal.nickname}} <i class="fa fa-edit text-danger" @click="redirect('/profile/payment_method')"></i></label>
        </span>

        <span class="item" style="border-bottom: 0px;" v-if="method !== null && method.payload === 'cod'">
          <label>Active Payment Method</label>
          
          <label class="pull-right" style="padding-right: 10px;"> {{method.payload_value}} <i class="fa fa-edit text-danger" @click="redirect('/profile/payment_method')"></i></label>
        </span>
        <button class="btn btn-primary custom-btn" @click="redirect('/profile/payment_method')" v-if="method === null">Add Payment Method</button>
        <button class="btn btn-warning custom-btn" @click="update()"> Complete Purchase</button>
      </span>
    </span>
  </div>
</template>
<style scoped>
.holder{
  width: 100%;
  float: left;
  margin-top: 25px;
}
.list{
  width: 100%;
  float: left;
  margin-top: 25px;
}
.items{
  width: 70%;
  float: left;
  min-height: 50px;
  overflow-y: hidden;
}
.items .title{
  height: 50px;
  width: 100%;
  float: left;
  line-height: 50px;
  padding-left: 10px;
  font-size: 24px;
  border-bottom: solid 1px #eee;
  color: #22b173;
}
.items .item{
  width: 100%;
  float: left;
  min-height: 100px;
  overflow-y: hidden;
  border-bottom: solid 1px #eee;
}
.objects-holder{
  float: left;
  width: 30%;
}
.details{
  float: left;
  width: 70%;
}
.two-objects-holder{
  float: left;
  width: 80%;
}
.two-details{
  float: left;
  width: 40%;
}
.details label, .two-details label{
  width: 100%;
  float: left;
}
.sidebar{
  width: 30%;
  float: left;
  min-height: 50px;
  overflow-y: hidden;
}
.sidebar .title, .sidebar .item{
  height: 50px;
  width: 100%;
  float: left;
  line-height: 50px;
  border-bottom: solid 1px #eee;
  padding-left: 10px;
}
.sidebar .title{
  font-size: 24px;
  border-bottom: 0px;
  background: #22b173;
  color: #fff;
}
.custom-btn{
  margin-top: 25px !important; 
  width: 100% !important;
  height: 50px !important;
}
.fa-edit{
  font-size: 24px;
  line-height: 50px;
  float: left;
}
.delete:hover{
  cursor: pointer;
}
.fa-edit:hover{
  cursor: pointer;
  color: #22b173;
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
import PayPal from 'vue-paypal-checkout'
export default {
  mounted(){
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      data: null,
      method: null,
      paypal: {
        sandbox: 'Ad3i7TApZLrGnTTF_BWrXZYFlz1sDUMRjWGeGn6ED8POGj1gp6Z43n4ph31ASUqlPtZguFqR7KMp2ZqH',
        production: 'Ad3i7TApZLrGnTTF_BWrXZYFlz1sDUMRjWGeGn6ED8POGj1gp6Z43n4ph31ASUqlPtZguFqR7KMp2ZqH'
      },
      credentials: {
        sandbox: 'Ad3i7TApZLrGnTTF_BWrXZYFlz1sDUMRjWGeGn6ED8POGj1gp6Z43n4ph31ASUqlPtZguFqR7KMp2ZqH',
        production: 'Ad3i7TApZLrGnTTF_BWrXZYFlz1sDUMRjWGeGn6ED8POGj1gp6Z43n4ph31ASUqlPtZguFqR7KMp2ZqH'
      },
      myStyle: {
        label: 'checkout',
        size: 'responsive',
        shape: 'pill',
        color: 'gold'
      },
      success: null
    }
  },
  components: {
    'objects': require('modules/object/Objects.vue'),
    'rating': require('modules/rating/Ratings.vue'),
    PayPal
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
      this.APIRequest('checkouts/retrieve', parameter).then(response => {
        if(response.data.length > 0){
          this.data = response.data
          this.method = response.method
          this.initPaypal()
        }else{
          this.data = null
        }
      })
    },
    remove(id){
      let parameter = {
        id: id
      }
      this.APIRequest('checkout_items/delete', parameter).then(response => {
        AUTH.checkAuthentication(null)
        this.retrieve()
      })
    },
    update(){
      if(this.data !== null){
        let parameter = {
          id: this.data[0].id,
          payment_method_id: this.method.id,
          sub_total: this.data[0].sub_total,
          total: this.data[0].total,
          tax: this.data[0].tax,
          account_id: this.user.userID,
          email: this.user.email,
          order_number: '10101'
        }
        this.APIRequest('checkouts/update', parameter).then(response => {
          if(response.data === true){
            AUTH.checkAuthentication(null)
            ROUTER.push('/thankyou')
          }
        })
      }
    },
    initPaypal(){
    }
  }
}
</script>

