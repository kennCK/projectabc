export default {
  name: 'webRTC',
  sockets: {
    connect: function() {
      console.log('Socket IO connected')
    },
    TestConnection: function() {
      console.log('Test connection successful')
    }
  },
  data: function() {
    return {
      localStream: null,
      remoteStream: null,
      pc1: null,
      pc2: null
    }
  },
  methods: {
    call: function() {
      this.pc1 = new RTCPeerConnection()
      this.pc1.addEventListener('onicecandidate', e => this.addIceCandidate(this.pc1, e))
      this.pc2 = new RTCPeerConnection()
      this.pc2.addEventListener('onicecandidate', e => this.addIceCandidate(this.pc2, e))
      this.pc2.addEventListener('track', this.gotRemoteStream)
      this.localStream.getTracks() .forEach(track => {
        console.log('Adding local stream')
        this.pc1.addTrack(track, this.localStream)
      })
      this.pc1.createOffer({offerToReceiveAudio: 1, offerToReceiveVideo: 1}).then(this.gotDescription)
    },
    gotRemoteStream: function(event) {
      console.log('Got Remote Stream')
      let remoteVideo = document.querySelector('#remoteVideo')
      this.remoteStream = event.streams[0]
      remoteVideo.srcObject = event.streams[0]
    },
    gotDescription: function(description) {
      console.log('Got Description 1')
      this.pc1.setLocalDescription(description)
      this.pc2.setRemoteDescription(description)
      this.pc2.createAnswer().then(this.gotDescription2)
    },
    gotDescription2: function(description) {
      console.log('Got Description 2')
      this.pc2.setLocalDescription(description)
      this.pc1.setRemoteDescription(description)
    },
    addIceCandidate: function(pc, event) {
      this.getOtherPC(pc).addIceCandidate(event.candidate).then(this.addIceCandidateSuccess).catch(this.addIceCandidateFailure)
    },
    addIceCandidateSuccess: function() {
      console.log('Ice candidate added Successfully')
    },
    addIceCandidateFailure: function() {
      cconsole.log('Ice candidate failure')
    },
    getOtherPC: function(pc) {
      if(pc === this.pc1){
        return this.pc2
      }
        return this.pc1
    },
    gotDevices: function(stream) {
      let localVideo = document.querySelector('#localVideo')
      this.localStream = stream
      localVideo.srcObject = stream
    },
    handleMediaError: function(error) {
      console.error('Error:' + error.name)
    }
  },
  created: function() {
    console.log('webRTC is Created!')
    let prom = navigator.mediaDevices.getUserMedia({audio: true, video: true}).then(this.gotDevices).catch(this.handleMediaError)
  }
}