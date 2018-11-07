<template>
  <div>
    <div class="item" v-if="objects !== null">
      <span class="body">
        <span class="preview">
          <span v-for="obj, innerIndex in objects" v-if="objects !== null">
              <span class="division" v-if="obj.type === 'division'" v-bind:style="obj.attributes">
              </span>
              <label class="text" v-if="obj.type === 'text'" v-bind:style="obj.attributes">{{obj.content}}</label>
              <img class="photo" :src="config.BACKEND_URL + obj.content" v-if="obj.type === 'photo'" :style="obj.attributes">
          </span>
        </span>
      </span>
    </div>
  </div>
</template>
<style scoped>
.item{
  width: 204px;
  height: 324px;
  float: left;
}

#dropdownMenuButton:hover{
  cursor: pointer;
}
.make-active-header{
}
.body{
  width: 100%;
  float: left;
  height: 324px;
  position: relative;
}
.preview{
  height: 324px;
  position: absolute;
  width: 100%;
  float: left;

}

.division, .text, .photo{
  position: absolute;
}
.text, .photo{
  background: rgba(250, 250, 250, 0) !important;
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      prevId: null
    }
  },
  props: ['objects'],
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    retrieve(){
      this.$parent.retrieve()
    }
  }
}
</script>
