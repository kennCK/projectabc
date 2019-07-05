<template>
  <div class="audioModal" v-bind:style="position" draggable="true" v-on:dragstart="moveObject($event)" v-on:dragend="dragEnd($event)" id="audio-call">
    <span class="holder" v-if="status === 0">   <!--  Ringing -->
      <div class="call-animation">
          <img class="img-circle" src="https://www.bsn.eu/wp-content/uploads/2016/12/user-icon-image-placeholder.jpg" alt="" width="120"/>
      </div>
      <i class="fa fa-phone pull-left bg-danger icons" @click="ignoreAudio"></i>
      <i class="fa fa-phone pull-right bg-primary icons" @click="accCall"></i>
      <h6 style="margin-top: 10px" class="text-center text-white">Calling...</h6>
      <h6 style="margin-top: 10px" class="text-center text-white">{{user.username}}</h6>
    </span>

    <span class="holder" v-if="status === 1">   <!--  Ongoing -->
      <div class="call-animation">
        <img class="img-circle pull-right" src="https://www.bsn.eu/wp-content/uploads/2016/12/user-icon-image-placeholder.jpg" alt="" width="120"/>
      </div>
      <i class="fa fa-phone pull-right bg-danger endicon" @click="endAudio"></i>
      <h6 style="margin-top: 10px" class="text-center text-white">{{user.username}}</h6>
      <h6 style="margin-top: 5px" class="text-center text-white">{{timeDisplay}}</h6>
    </span>

  </div>
</template>
<script>
import AUTH from 'src/services/auth'
import { setInterval, clearInterval } from 'timers'
export default {
  data(){
    return{
      user: AUTH.user,
      position: {
        top: '0',
        right: '0'
      },
      status: 0,
      seconds: 0,
      minutes: 0,
      hours: 0,
      timer: null,
      timeDisplay: `00:00:00`,
      posX: 0,
      posY: 0,
      selected: null
    }
  },
  methods: {
    endAudio(){
      this.status = 0
      $('#audio-call').css({'display': 'none'})
      clearInterval(this.timer)
      this.seconds = 0
      this.minutes = 0
      this.hours = 0
    },
    accCall(){
      this.status = 1
      this.timeDisplay = `00:00:00`
      this.timer = setInterval(() => {
        this.seconds++
        if (this.seconds === 60){
          this.seconds = 0
          this.minutes++
        }
        if (this.minutes === 60){
          this.minutes = 0
          this.hours++
        }
        let s = this.seconds.toString().padStart(2, '0')
        let m = this.minutes.toString().padStart(2, '0')
        let h = this.hours.toString().padStart(2, '0')
        console.log('counting')
        this.timeDisplay = `${h}:${m}:${s}`
      }, 1000)
    },
    ignoreAudio(){
      this.status = 0
      $('#audio-call').css({'display': 'none'})
    },
    moveObject(event){
      this.posX = event.x
      this.posY = event.y
    },
    dragEnd(event){
      let x = this.posX - event.x
      let y = this.posY - event.y
      this.manageAttributes(x, y * -1)
    },
    manageAttributes(x, y){
      var top = this.position.top
      var right = this.position.right
      if(String(top).indexOf('p') > -1){
        top = parseInt(top.substr(0, top.length - 2))
      }
      if(String(right).indexOf('p') > -1){
        right = parseInt(right.substr(0, right.length - 2))
      }
      this.position.top = (top + y) + 'px'
      this.position.right = (right + x) + 'px'
    }
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.audioModal{
  position: absolute;
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
 // right:0;
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
.endicon{
    // font-size: 3em;
    font-size: 32px;
    height: 50px;
    width: 50px;
    border-radius: 50%;
    color: white;
    line-height: 50px;
    padding: 0%;
    text-align: center;
    position: absolute; 
    top: 19px;
    right: 19px;
}
#end-call:hover{
    cursor: pointer;
    color: $hover;
}
.call-animation {
    background: white;
    width: 80px;
    height: 80px;
    position: relative;
    margin: 0 auto;
    border-radius: 100%;
    border: solid 5px white;
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
