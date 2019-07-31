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
      <i class="fa fa-phone pull-right bg-primary icons" @click="acceptCall" id = "call"></i>
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
        <h6 style="margin-top: 10px" class="text-center text-white">
          {{user.username === auth.audio.senderUser.username ? auth.audio.receiverUser.username : auth.audio.senderUser.username}}</h6>
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
import RTCMultiConnection from 'rtcmulticonnection'
// import Vue from 'vue'
// import { WebRTC } from 'plugin';
// import { find, head } from 'lodash';

// Vue.component(WebRTC.name, WebRTC);
export default {
  data(){
    return{
      rtcmConnection: null,
      localVideo: null,
      videoList: [],
      canvas: null,
      user: AUTH.user,
      config: CONFIG,
      posX: null,
      posY: null,
      auth: AUTH,
      timer: null,
      selected: null,
      position: {
        top: '0',
        right: '0',
        charTop: null,
        charRight: null
      },
      computed: {
      },
      watch: {
      },
      initialPosition: {
        top: '0',
        right: '0'
      }
    }
  },
  props: {
    roomId: {
      type: String,
      default: 'public-room'
    },
    socketURL: {
      type: String,
      default: 'https://rtcmulticonnection.herokuapp.com:443/'
    },
    cameraHeight: {
      type: [Number, String],
      default: 160
    },
    autoplay: {
      type: Boolean,
      default: true
    },
    screenshotFormat: {
      type: String,
      default: 'image/jpeg'
    },
    enableAudio: {
      type: Boolean,
      default: true
    },
    enableVideo: {
      type: Boolean,
      default: true
    },
    enableLogs: {
      type: Boolean,
      default: false
    }
  },
  mounted() {
    var that = this
    this.rtcmConnection = new RTCMultiConnection()
    this.rtcmConnection.socketURL = this.socketURL
    this.rtcmConnection.autoCreateMediaElement = false
    this.rtcmConnection.enableLogs = this.enableLogs
    this.rtcmConnection.session = {
      audio: this.enableAudio,
      video: this.enableVideo
    }
    this.rtcmConnection.sdpConstraints.mandatory = {
      OfferToReceiveAudio: this.enableAudio,
      OfferToReceiveVideo: this.enableVideo
    }
    this.rtcmConnection.onstream = function (stream) {
      let found = that.videoList.find(video => {
        return video.id === stream.streamid
      })
      if (found === undefined) {
        let video = {
          id: stream.streamid,
          muted: stream.type === 'local'
        }

        that.videoList.push(video)

        if (stream.type === 'local') {
          that.localVideo = video
        }
      }

      setTimeout(function(){
        for (var i = 0, len = that.$refs.videos.length; i < len; i++) {
          if (that.$refs.videos[i].id === stream.streamid) {
            that.$refs.videos[i].srcObject = stream.stream
            break
          }
        }
      }, 1000)
      that.$emit('joined-room', stream.streamid)
    }
    this.rtcmConnection.onstreamended = function (stream) {
      var newList = []
      that.videoList.forEach(function (item) {
        if (item.id !== stream.streamid) {
          newList.push(item)
        }
      })
      that.videoList = newList
      that.$emit('left-room', stream.streamid)
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
      this.auth.endAudioCallTimer()
    },
    acceptCall(){
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
  }
}
</script>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.audioModal{
  position: fixed;
  background: #555;
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
}
.holder{
    float: left;
    width: 100%;
    height: 100%;
    padding: 0% 10%;
}
.icons{
    font-size: 32px;
    height: 50px;
    width: 50px;
    border-radius: 50%;
    color: white;
    line-height: 50px;
    padding: 0%;
    text-align: center;
}
.endicon{
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
video {
  max-width: 100%;
  width: 320px;
}
#audio-call:hover {
  cursor: default;
  cursor: default;
}
#audio-call:hover:active {
  cursor: default;
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
