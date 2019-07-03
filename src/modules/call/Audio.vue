<template>
  <div class="container1">
    <div class="customModal" style="float: right" id="audio-call">
      <span class="holder">   <!--  Ringing -->
        <div class="call-animation">
            <img class="img-circle" src="https://www.bsn.eu/wp-content/uploads/2016/12/user-icon-image-placeholder.jpg" alt="" width="120"/>
            </div>
            <i class="fa fa-phone pull-left bg-danger icons" @click="endAudio"></i>
            <i class="fa fa-phone pull-right bg-primary icons" @click="accCall"></i>
            <h6 style="margin-top: 10px" class="text-center text-white">Calling...</h6>
            <h6 style="margin-top: 10px" class="text-center text-white">{{user.username}}</h6>
      </span>
    </div>
    <div class="customModal" style="float: right" id="accept-call">
       <span class="holder">   <!--  Ongoing -->
        <div class="call-animation">
            <img class="img-circle pull-right" src="https://www.bsn.eu/wp-content/uploads/2016/12/user-icon-image-placeholder.jpg" alt="" width="120"/>
            </div>
            <i class="fa fa-phone pull-left bg-danger icons" @click="endAudio"></i>
            <h6 style="margin-top: 10px" class="text-center text-white">{{user.username}}</h6>
            <h6 style="margin-top: 5px" class="text-center text-white">Ongoing Call</h6>
        </span>
    </div>
  </div>
</template>
<script>
import AUTH from 'src/services/auth'
export default {
  data(){
    return{
      user: AUTH.user,
      top: 200,
      right: 300,
      status: 1
    }
  },
  methods: {
    endAudio(){
      $('#accept-call').css({'display': 'none'})
      $('#audio-call').css({'display': 'none'})
    },
    accCall(){
      $('#accept-call').css({'display': 'block'})
      $('#audio-call').css({'display': 'none'})
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.container1 {
  position: relative;
  width: 100%;
}
.customModal{
  position: fixed;
  background: #555;
  // top: 60px;
  // right: 0;
  width: 300px;
  height: 200px;
  z-index: 100000 !important;
  -webkit-transition: all 0.1s;
  -moz-transition: all 0.1s;
  transition: all 0.1s;
  text-align: right;
  display: none;
  padding-right: 10px;
  padding-top: 50px;
  right:0;
}
.holder{
    float: left;
    width: 100%;
    height: 100%;
    padding: 0% 10%;
}
.icons{
    // font-size: 3em;
    font-size: 32px;
    height: 50px;
    width: 50px;
    border-radius: 50%;
    color: white;
    line-height: 50px;
    padding: 0%;
    text-align: center;
    // padding-right: 10px;
}
#end-call:hover{
    cursor: pointer;
    color: $hover;
}
.call-animation {
    background: #fff;
    width: 80px;
    height: 80px;
    position: relative;
    margin: 0 auto;
    border-radius: 100%;
    border: solid 5px #fff;
    animation: play 2s ease infinite;
    -webkit-backface-visibility: hidden;
    -moz-backface-visibility: hidden;
    -ms-backface-visibility: hidden;
    backface-visibility: hidden;
    top:-3px;
  
}
 img {
        width: 70px;
        height: 70px;
        border-radius: 100%;
        position: absolute;
        left: 0px;
        top: 0px;
    }
@keyframes play {

    0% {
        transform: scale(1);
    }
    15% {
        box-shadow: 0 0 0 5px rgba(255, 255, 255, 0.4);
    }
    25% {
        box-shadow: 0 0 0 10px rgba(255, 255, 255, 0.4), 0 0 0 20px rgba(255, 255, 255, 0.2);
    }
    25% {
        box-shadow: 0 0 0 15px rgba(255, 255, 255, 0.4), 0 0 0 30px rgba(255, 255, 255, 0.2);
    }
}
</style>
