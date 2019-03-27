<template>
  <div>
    <div v-if="objects !== null" v-bind:style="{height: heightTemplate + 'px', width: widthTemplate + 'px'}" class="item">
      <span v-bind:style="{height: heightTemplate + 'px', width: widthTemplate + 'px'}" class="body">
        <span v-bind:style="{height: heightTemplate + 'px', width: widthTemplate + 'px'}" class="preview">
          <span v-for="obj, innerIndex in objects" v-if="objects !== null">
            <div class="division" v-if="obj.type === 'division'" v-bind:style="obj.attributes">
            </div>
            <label class="text" v-if="obj.type === 'text' && obj.settings === 'dynamic' && obj.name === 'complete_name'" v-bind:style="obj.attributes">
            {{profile.first_name + ' ' + profile.middle_name + ' ' + profile.last_name}}</label>
            <label class="text" v-if="obj.type === 'text' && obj.settings === 'dynamic' && obj.name !== 'complete_name'" v-bind:style="obj.attributes">
            {{profile[obj.name]}}</label>
            <label class="text" v-if="obj.type === 'text' && obj.settings === 'static'" v-bind:style="obj.attributes">{{obj.content}}</label>
            <img class="photo" :src="config.BACKEND_URL + obj.content" v-if="obj.type === 'photo' && obj.settings === 'static'" :style="obj.attributes">
            <img class="photo" :src="config.BACKEND_URL + profile[obj.name]" v-if="obj.type === 'photo' && obj.settings === 'dynamic'" :style="obj.attributes">
          </span>
        </span>
      </span>
    </div>
  </div>
</template>
<style scoped>
@media print {
    .division {
        -webkit-print-color-adjust: exact; 
    }
}

@media print {
    .division {
        color: white !important;
    }
}
.item{
  float: left;
}

#dropdownMenuButton:hover{
  cursor: pointer;
}
.make-active-header{
}
.body{
  float: left;
  position: relative;
}
.preview{
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
  props: ['objects', 'heightTemplate', 'widthTemplate', 'profile'],
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
