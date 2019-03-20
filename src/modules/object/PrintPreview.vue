<template>
  <div>
    <div v-if="objects !== null" v-bind:style="{height: heightTemplate, width: widthTemplate}" class="item">
      <span v-bind:style="{height: heightTemplate, width: widthTemplate}" class="body">
        <span v-bind:style="{height: heightTemplate, width: widthTemplate}" class="preview">
          <span v-for="obj, innerIndex in objects" v-if="objects !== null">
              <div class="division" v-if="obj.type === 'division'" v-bind:style="obj.attributes">
              </div>
              <label class="text" v-if="obj.type === 'text'" v-bind:style="obj.attributes">{{obj.content}}</label>
              <img class="photo" :src="config.BACKEND_URL + obj.content" v-if="obj.type === 'photo'" :style="obj.attributes">
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
  props: ['objects', 'heightTemplate', 'widthTemplate'],
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
