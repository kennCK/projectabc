<template>
  <div class="audioModal" v-bind:style="initialPosition" draggable="true" v-on:dragstart="moveObject($event)" v-on:dragend="drag($event)" v-on:drag="drag($event)" id="audio-call">
    <span class="holder" v-if="auth.audio.status === 0">   <!--  Ringing,Receiver -->
      <div class="call-animation" v-if="auth.audio.senderUser.profile.url !== null">
          <img class="img-circle" :src="config.BACKEND_URL + auth.audio.senderUser.profile.url" alt="" width="120"/>
      </div>
      <div class="call-animation" v-else>
        <i class="fa fa-user-circle-o"></i>
      </div>
      <i class="fa fa-phone pull-left bg-danger icons" @click="ignoreAudio"></i>
      <!-- <video id="localVideo" playsinline autoplay controls muted></video> -->
      <i class="fa fa-phone pull-right bg-primary icons" @click="acceptCall" id = "call" v-on:click='oncall'></i>
      <!-- <video id="remoteVideo" playsinline autoplay controls></video> -->
      <h6 style="margin-top: 10px" class="text-center text-white">Incoming Call</h6>
      <h6 style="margin-top: 10px" class="text-center text-white">{{auth.audio.senderUser.username}}</h6>
    </span>
    <span class="holder" v-if="auth.audio.status === 1">   <!--  Ongoing -->
      <div class="call-animation" v-if="user.username === auth.audio.senderUser.username">
        <img class="img-circle pull-right" v-if="auth.audio.receiverUser.profile.url !== null" :src="config.BACKEND_URL + auth.audio.receiverUser.profile.url" alt="" width="120"/>
        <i class="fa fa-user-circle-o" v-else></i>
      </div>
      <div class="call-animation" v-else>
        <img class="img-circle pull-right" v-if="auth.audio.senderUser.profile.url !== null" :src="config.BACKEND_URL + auth.audio.senderUser.profile.url" alt="" width="120"/>
        <i class="fa fa-user-circle-o" v-else></i>
      </div>
        <i class="fa fa-phone pull-right bg-danger endicon" @click="endAudio"></i>
        <h6 style="margin-top: 10px" class="text-center text-white">{{auth.audio.senderUser.username}}</h6>
        <h6 style="margin-top: 10px" class="text-center text-white">{{auth.audio.timeDisplay}}</h6>
    </span>
     <span class="holder" v-if="auth.audio.status === 2">   <!--  Calling, Sender -->
      <div class="call-animation" v-if="auth.audio.receiverUser.profile.url !== null">
        <img class="img-circle pull-right" :src="config.BACKEND_URL + auth.audio.receiverUser.profile.url" alt="" width="120"/>
      </div>
      <div class="call-animation" v-else>
        <i class="fa fa-user-circle-o"></i>
      </div>
      <i class="fa fa-phone pull-right bg-danger endicon" @click="endAudio"></i>
       <h6 style="margin-top: 10px" class="text-center text-white">Calling</h6>
      <h6 style="margin-top: 10px" class="text-center text-white">{{auth.audio.receiverUser.username}}</h6>
    </span>
  </div>
</template>
<script>
import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'
// import { setInterval, clearInterval } from 'timers'
export default {
  data(){
    return{
      user: AUTH.user,
      config: CONFIG,
      posX: null,
      posY: null,
      auth: AUTH,
      timer: null,
      selected: null,
      // localStream: null,
      // remoteStream: null,
      // pc1: null,
      // pc2: null,
      position: {
        top: '0',
        right: '0',
        charTop: null,
        charRight: null
      },
      initialPosition: {
        top: '0',
        right: '0'
      }
    }
  },
  methods: {
    endAudio(){
      this.position = {
        top: '0',
        right: '0'
      }
      let parameter = {
        receiver: this.auth.audio.receiverId,
        sender: this.user.userID,
        action: 0
      }
      this.APIRequest('audio_calls/send', parameter, (response) => {
        console.log(response)
      })
      this.auth.audio.status = 0
      // $('#audio-call').css({'display': 'none'})
      this.auth.endAudioCallTimer()
    },
    oncall(){
      let parameter = {
        receiver: this.auth.audio.receiverId,
        sender: this.user.userID,
        action: 1
      }
      this.APIRequest('audio_calls/send', parameter, (response) => {
      })
      this.auth.audio.status = 1
      this.auth.startAudioCallTimer()
    },
    ignoreAudio(){
      $('#audio-call').css({'display': 'none'})
      this.position = {
        top: '0',
        right: '0'
      }
      let parameter = {
        receiver: this.auth.audio.receiverId,
        sender: this.user.userID,
        action: 0
      }
      this.APIRequest('audio_calls/send', parameter, (response) => {
        console.log(response)
      })
      this.auth.audio.status = 0
    },
    moveObject(event){
      this.posX = event.x
      this.posY = event.y
      this.position.top = this.initialPosition.top
      this.position.right = this.initialPosition.right
      if(String(this.position.top).indexOf('%') > -1){
        this.position.top = parseInt(this.position.top.substr(0, this.position.top.length - 1))
        this.position.charTop = '%'
      }
      if(String(this.position.top).indexOf('p') > -1){
        this.position.top = parseInt(this.position.top.substr(0, this.position.top.length - 2))
        this.position.charTop = 'px'
      }
      if(String(this.position.right).indexOf('%') > -1){
        this.position.right = parseInt(this.position.right.substr(0, this.position.right.length - 1))
        this.position.charRight = '%'
      }
      if(String(this.position.right).indexOf('p') > -1){
        this.position.right = parseInt(this.position.right.substr(0, this.position.right.length - 2))
        this.position.charRight = 'px'
      }
    },
    drag(event){
      let x = this.posX - event.x
      let y = this.posY - event.y
      this.changePosition(x, y * -1)
    },
    changePosition(x, y){
      this.position.top = parseInt(this.position.top)
      this.position.right = parseInt(this.position.right)
      this.initialPosition.top = (this.position.top + y) + 'px'
      this.initialPosition.right = (this.position.right + x) + 'px'
    }
  //   call(){
  //     this.pc1 = new RTCPeerConnection()
  //     this.pc1.addEventListener('onicecandidate', e => this.addIceCandidate(this.pc1, e))
  //     this.pc2 = new RTCPeerConnection()
  //     this.pc2.addEventListener('onicecandidate', e => this.addIceCandidate(this.pc2, e))
  //     this.pc2.addEventListener('track', this.gotRemoteStream)
  //     this.localStream.getTracks().forEach(track => {
  //       console.log('Adding local stream')
  //       this.pc1.addTrack(track, this.localStream)
  //     })
  //     this.pc1.createOffer({offerToReceiveAudio: 1, offerToReceiveVideo: 1})
  //     .then(this.gotDescription)
  //     .catch(e => console.log(e))
  //   },
  //   gotRemoteStream(event){
  //     console.log('Got Remote Stream')
  //     let remoteVideo = document.querySelector('#remoteVideo')
  //     this.remoteStream = event.streams[0]
  //     remoteVideo.srcObject = event.streams[0]
  //   },
  //   gotDescription(description){
  //     console.log('Got Description 1')
  //     this.pc1.setLocalDescription(description)
  //     this.pc2.setRemoteDescription(description)
  //     this.pc2.createAnswer().then(this.gotDescription2)
  //   },
  //   gotDescription2(description){
  //     console.log('Got Description 2')
  //     this.pc2.setLocalDescription(description)
  //     this.pc1.setRemoteDescription(description)
  //   },
  //   addIceCandidate(pc, event){
  //     this.getOtherPC(pc).addIceCandidate(event.candidate).then(this.addIceCandidateSuccess).catch(this.addIceCandidateFailure)
  //   },
  //   addIceCandidateSuccess(){
  //     console.log('Ice candidate added Successfully')
  //   },
  //   addIceCandidateFailure(){
  //     console.log('Ice candidate failure')
  //   },
  //   getOtherPC(pc){
  //     if(pc === this.pc1){
  //       return this.pc2
  //     }
  //     return this.pc1
  //   },
  //   gotDevices(stream){
  //     let localVideo = document.querySelector('#localVideo')
  //     this.localStream = stream
  //     localVideo.srcObject = stream
  //   },
  //   handleMediaError(error){
  //     console.error('Error:' + error.name)
  //   }
  // },
  //
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.audioModal{
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
#audio-call:hover {
  cursor: grabbing;
  cursor: grab;
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
