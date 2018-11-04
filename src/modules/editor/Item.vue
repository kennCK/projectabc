<template>
  <div>
    <div class="item" v-if="item !== null" v-on:click="makeActive()">
      <span class="header">
        <b>
          {{item.title}}
        </b>
      </span>
      <span class="body">
        <span class="preview">
          <span v-for="obj, innerIndex in item.objects" v-bind:class="{'text': obj.type === 'text', 'division': obj.type === 'division', 'photo': obj.type === 'photo', 'object-selected': obj.selected === true}" v-bind:style="obj.attributes" v-if="item.objects !== null">
            <label v-if="obj.type === 'text'">{{obj.content}}</label>
            <img :src="obj.content" v-if="obj.type === 'photo' && obj.content !== null" height="100%" width="
            100%">
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
  width: 24%;
  height: 400px;
  float: left;
  border: solid 1px #eee;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
  margin-right: 1%;
  margin-bottom: 25px;
}
.item:hover{
  cursor: pointer;
  border: solid 1px #22b173;
}
.header{
  width: 100%;
  float: left;
  height: 50px;
  text-align: center;
  line-height: 50px;
  border-bottom: solid 1px #eee;

}
.body{
  width: 100%;
  float: left;
  height: 350px;
  position: relative;
}
.preview{
  height: 350px;
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
  background: #028170;
  position: absolute;
  transition: 1s;
}
ul li{
  width: 50%;
  float: left;
  height: 40px;
  text-align: center;
  line-height: 40px;
  border-left: solid 1px #22b173;
  color: #fff;
}
ul li:hover{
  cursor: pointer;
  background: #22b173;
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
