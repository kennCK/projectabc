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
        <div class="form-group" style="margin-top: 25px;">
          <label for="address">Paypal</label>
          <input type="text" class="form-control" placeholder="Enter Nickname">
        </div>

        <button class="btn btn-primary" style="margin-bottom: 25px;" >Authorize</button>
      
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
export default {
  mounted(){
  },
  data(){
    return {
      user: AUTH.user,
      tokenData: AUTH.tokenData,
      config: CONFIG,
      data: null
    }
  },
  methods: {
  }
}
</script>
