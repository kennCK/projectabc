<template>
  <div class="holder">
    <span class="list" v-if="data !== null">
      <span class="items">
        <span class="title">
          Cart Items
        </span>
        <span class="item" v-for="item, index in data">
          <span class="objects-holder">
            <objects :objects="item.objects" v-if="item.objects !== null"></objects>
          </span>
          <span class="details">
              <label style="margin-top: 10px;">
                <b>{{item.template.title}}</b>
                <i class="fa fa-trash pull-right text-danger delete" style="font-size: 24px; padding-right: 25px;" @click="remove(item.id)"></i>
              </label>
              <label>Price Php {{item.template.price}}</label>
              <label>Cetegory: {{item.template.categories}}</label>
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
        <button class="btn btn-warning custom-btn"> Checkout</button>
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
.details label{
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
.delete:hover{
  cursor: pointer;
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      data: null
    }
  },
  components: {
    'objects': require('modules/object/Objects.vue')
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
        }]
      }
      this.APIRequest('checkouts/retrieve', parameter).then(response => {
        if(response.data.length > 0){
          this.data = response.data
        }else{
          this.data = null
        }
      })
    },
    remove(id){
      let parameter = {
        id: id
      }
      this.APIRequest('checkouts/delete', parameter).then(response => {
        AUTH.checkAuthentication(null)
        this.retrieve()
      })
    }
  }
}
</script>

