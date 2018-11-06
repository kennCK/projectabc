<template>
  <div>
    <div v-bind:class="{'make-active': item !== null && item.active === true}" class="item" v-if="item !== null" v-on:click="makeActive()">
      <span v-bind:class="{'make-active-header': item.active === true}" class="header">
        <b>
          {{item.title}}
        </b>
      </span>
      <span class="body">
        <span class="preview">
          <span v-for="obj, innerIndex in item.objects" v-if="item.objects !== null">
              <span class="division" v-if="obj.type === 'division'" v-bind:style="obj.attributes">
              </span>
              <label class="text" v-if="obj.type === 'text'" v-bind:style="obj.attributes">{{obj.content}}</label>
              <img class="photo" :src="config.BACKEND_URL + obj.content" v-if="obj.type === 'photo'" :style="obj.attributes">
          </span>
        </span>
        <ul v-if="item.active === true">
          <li v-on:click="editor(item)" style="border-left: 0px;">Editor</li>
          <li v-on:click="update(item)">Settings</li>
        </ul>
      </span>
    </div>
    <update></update>
    <editor></editor>
  </div>
</template>
<style scoped>
.item{
  width: 204px;
  height: 374px;
  float: left;
  border: solid 1px #ddd;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
  margin-right: 25px;
  margin-bottom: 25px;
}
.item:hover{
  cursor: pointer;
  border: solid 1px #22b173;
}
.make-active{
  border: solid 1px #22b173;
}
.header{
  width: 100%;
  float: left;
  height: 50px;
  text-align: center;
  line-height: 50px;
  border-bottom: solid 1px #ddd;
}
.make-active-header{
  background: #22b173;
  color: #fff;
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
ul{
  padding: 0px;
  margin: 0px;
  width: 100%;
  float: left;
  z-index: 30;
  list-style: none;
  bottom: 0;
  height: 40px;
  background: #22b173;
  position: absolute;
  transition: 1s;
}
ul li{
  width: 50%;
  float: left;
  height: 40px;
  text-align: center;
  line-height: 40px;
  border-left: solid 1px #028170;
  color: #fff;
}
ul li:hover{
  cursor: pointer;
  background: #028170;
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
  components: {
    'update': require('modules/editor/Update.vue'),
    'editor': require('modules/editor/Editor.vue')
  },
  props: ['item', 'index'],
  methods: {
    makeActive(){
      this.$parent.makeActive(this.index)
    },
    redirect(parameter){
      ROUTER.push(parameter)
    },
    update(item){
      this.$children[0].item = item
      setTimeout(() => {
        $('#updateTemplateModal').modal({
          backdrop: 'static',
          show: true,
          keyboard: false
        })
      }, 50)
    },
    editor(item){
      this.$children[1].item = item
      this.$children[1].retrieve()
      setTimeout(() => {
        $('#templateEditorModal').modal({
          backdrop: 'static',
          show: true,
          keyboard: false
        })
      }, 50)
    }
  }
}
</script>
