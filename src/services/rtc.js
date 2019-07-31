export default {
  rtcmConnection: null,
  join() {
    var that = this
    this.rtcmConnection.openOrJoin(this.audio.roomId, function (isRoomExist, roomid) {
      if (isRoomExist === false && that.rtcmConnection.isInitiator === true) {
        // that.$emit('opened-room', roomid)
      }
    })
  }
}
