<template>
  <div class="row">
    <div class="col-md-6 col-lg-4 mx-auto signup-container">
      <div class="login-wrapper">
        <div class="signup-header" style="margin-top: 50px;">
          <img src="../../assets/img/logo.png" v-on:click="redirect('/')">
        </div>
        <span style="width:100%;float:left;text-align:center;font-size:20px;margin-bottom:10px;">
          Verification
        </span>
        <div class="signup-holder">
          <br>  
          <div>
            <div  style="margin-bottom: 25px !important;text-align: justify;" v-bind:class="{'text-danger': flag === false}" class="login-spacer">
              {{message}}
            </div>
            <button class="btn btn-primary btn-block login-spacer" v-on:click="update()" v-if="verified === false">Continue</button>  
            <button class="btn btn-danger btn-block login-spacer" v-on:click="redirect('/')" v-if="verified === true && user.userID <= 0">Back to Login</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.signup-container{
  margin-top: 50px;
}
.signup-header{
  height: 100px;
  color: #006600;
  width: 100%;
  float: left;
  text-align: center;
}

.signup-header img{
  height: 100px !important;
  width: 100px !important;
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

.form-control{
  height: 45px !important;
}
.btn{
  height: 50px !important;
}
.input-group{
  margin-top: 5px;
  margin-bottom: 5px;
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
import AUTH from '../../services/auth'
export default {
  mounted(){
    this.username = this.$route.params.username
    this.code = this.$route.params.code
    this.retrieveAccount()
    this.setMessage()
    if(this.account !== null){
      this.validate()
    }
  },
  data(){
    return {
      username: this.$route.params.username,
      code: this.$route.params.code,
      account: null,
      flag: null,
      message: null,
      user: AUTH.user,
      verified: false
    }
  },
  methods: {
    setMessage(){
      this.message = 'Hi ' + this.username + '! Please click the button to verify your email address here in ClassWorx'
    },
    retrieveAccount(){
      let parameter = {
        'condition': [
          {
            'column': 'username',
            'value': this.username,
            'clause': '='
          },
          {
            'column': 'code',
            'value': this.code,
            'clause': '='
          }
        ]
      }
      this.APIRequest('accounts/retrieve', parameter).then(response => {
        if(response.data.length > 0){
          this.account = response.data[0]
        }else{
          this.account = null
        }
      })
    },
    update(){
      this.retrieveAccount()
      if(this.validate() === true && this.account !== null){
        let parameter = {
          'id': this.account.id,
          'status': 'VERIFIED'
        }
        $('#loading').css({display: 'block'})
        this.APIRequest('accounts/update_verification', parameter).then(response => {
          $('#loading').css({display: 'none'})
          if(response.data === true){
            this.message = 'Congratulations! You\'ve have successfully verified your account. Kindly click Continue Button to login.'
            this.flag = true
            this.verified = true
          }else{
            this.flag = false
            this.verified = false
            this.message = 'Sorry! Internal Error. Kindly verify again or contact the system support.'
          }
        })
      }else{
        this.flag = false
        this.message = 'Sorry! Internal Error. Kindly verify again or contact the system support.'
      }
    },
    validate(){
      if(this.username !== null || this.code !== null){
        this.flag = true
        return true
      }else{
        this.flag = false
        return false
      }
    },
    redirect(parameter){
      ROUTER.push(parameter)
    }
  }
}
</script>
