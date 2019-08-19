<template>
  <div>
    christine here...
  <button class="btn btn-primary" @click="showAudio">Call</button>
  <!-- <label>Your ID</label>
  <textarea id="yourId"></textarea>
  <label>Other ID</label>
  <textarea id="otherId"></textarea>
  <button id="connect">connect</button>

  <label>Enter Message</label>
  <textarea id="yourMessage"></textarea>
  <button id="send">send</button>
  <pre id="messages"></pre> -->
  </div>
</template>
<style>

</style>
<script>
import AUTH from 'src/services/auth'
export default {
  methods: {
    showAudio(){
      AUTH.triggerAudioCall(2, 2)
    }
  }
}
</script>
