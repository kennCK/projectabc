import RTCMultiConnection from 'rtcmulticonnection'
// import { WebRTC } from 'plugin';
// import { find, head } from 'lodash';

// Vue.component(WebRTC.name, WebRTC)
export default {
  name: 'vue-webrtc',
  components: {
    RTCMultiConnection
  },
  rtcmConnection: null,
  socketURL: 'https://rtcmulticonnection.herokuapp.com:443/',
  enableAudio: true,
  enableVideo: true,
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
  initializeRTC() {
    var that = this
    this.rtcmConnection = new RTCMultiConnection()
    this.rtcmConnection.socketURL = this.socketURL
    this.rtcmConnection.autoCreateMediaElement = false
    // this.rtcmConnection.enableLogs = this.enableLogs
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
    }
    this.rtcmConnection.onstreamended = function (stream) {
      var newList = []
      that.videoList.forEach(function (item) {
        if (item.id !== stream.streamid) {
          newList.push(item)
        }
      })
      that.videoList = newList
    }
  },
  join(roomId) {
    let that = this
    this.rtcmConnection.openOrJoin(roomId, function (isRoomExist, roomid) {
      console.log(isRoomExist, roomid)
      if (isRoomExist === false && that.rtcmConnection.isInitiator === true) {
        // that.$emit('opened-room', roomid)
      }
    })
    // console.log(this.rtcmConnection)
  }
}
