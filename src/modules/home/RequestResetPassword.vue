<template>
  <div class="row">
    <div class="col-lg-4 col-md-6 mx-auto custom-holder">
      <div class="signup-header" style="margin-top: 50px;">
        <img src="../../assets/img/logo.png" v-on:click="redirect('/')">
      </div>
      <span style="width:100%;float:left;text-align:center;font-size:20px;margin-bottom:20px;">
        Request to Reset
      </span>
      <div class="input-holder">
        <div class="login-message-holder login-spacer" v-if="errorMessage != ''">
            <span class="text-danger text-center" v-if="successMessage === null && errorMessage !== null"><b>Oops!</b> {{errorMessage}}</span>
            <span class="text-primary text-center" v-else>{{successMessage}}</span>
        </div>
        <div class="login-spacer" style="margin-bottom: 25px !important;text-align: justify;" v-if="hide === true">
          We send recovery email to your email address at <b>{{email}}</b>.
          Please give us a moment, it may take few minutes. Please check your email address to continue.
        </div>
        <input type="text" name="username" placeholder="Type your Email Address" class="form-control" v-model="email" v-if="hide === false">
        <br>
        <button class="btn btn-primary btn-block login-spacer" v-on:click="request()" v-if="hide === false">Send Request</button><button class="btn btn-danger btn-block login-spacer" v-on:click="redirect('/')">Back to Login</button>
        <br>
        <br>
     </div>
    </div>
  </div>
</template>
<style scoped>
.custom-holder{
  margin-top: 100px;
}

.signup-header{
  height: 100px;
  color: #006600;
  width: 100%;
  float: left;
  text-align: center;
}

.signup-header img{
  width: 70px;
  height: 70px;
}

.signup-header img:hover{
  cursor: pointer;
}

.header-title{
  width: 90%;
  margin:  25px 5% 0 5%;
  font-size: 24px;
  font-weight: 700px;
}

.input-holder{
  width: 90%;
  margin:  0 5% 0 5%;
}

.btn{
  height: 50px !important;
}

.form-control{
  height: 45px !important;
}

.site-title{
  margin-top: 25px;
  width: 100%;
  float: left;
}
.site-title img{
  width: 50px;
  width: 50px;
  float: left;
  margin-right: 10px;
  margin-left: 5%;
}
.site-title .app-name{
  float: left;
}
/*-------------- Extra Small Screen for Mobile Phones --------------*/
@media (max-width: 991px){
  .custom-holder{
    box-shadow: 0 0 0 0 #fff !important;
    margin-top: 50px !important;
  }
}
</style>

<script>
import ROUTER from '../../router'
export default {
  name: '',
  components: {
    'input-group': require('components/input_field/InputGroup.vue')
  },
  mounted(){
  },
  data(){
    return{
      email: null,
      flag: false,
      errorMessage: null,
      successMessage: null,
      hide: false
    }
  },
  methods: {
    request(){
      this.validate()
      let parameter = {
        email: this.email
      }
      if(this.flag === true){
        $('#loading').css({display: 'block'})
        this.APIRequest('accounts/request_reset', parameter).then(response => {
          $('#loading').css({display: 'none'})
          this.hide = true
        })
      }
    },
    validate(){
      if(this.email === null || this.email === ''){
        this.flag = false
        this.errorMessage = 'Please enter your Email Address'
      }else{
        this.flag = true
      }
    },
    redirect(parameter){
      ROUTER.push(parameter)
    }
  }
}
</script>
