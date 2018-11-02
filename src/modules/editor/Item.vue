<template>
  <div>
    <div class="item" v-if="item !== null">
      <span class="header">
        <b>
          {{item.title}}
        </b>
      </span>
      <span class="body">
        <span class="preview">
          
        </span>
        <ul>
          <li v-on:click="editor(item)">Editor</li>
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
  border-radius: 5px;
  margin-right: 1%;
  margin-top: 10px;
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
  position: absolute;
  height: 350px;
  width: 100%;
  float: left;
  z-index: 0;
}
ul{
  padding: 0px;
  margin: 0px;
  width: 100%;
  float: left;
  z-index: 1;
  position: absolute;
  list-style: none;
  bottom: 0;
}
ul li{
  width: 100%;
  float: left;
  height: 40px;
  text-align: center;
  line-height: 40px;
  border-top: solid 1px #eee;
}
ul li:hover{
  cursor: pointer;
  background: #eee;
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
      errorMessage: null
    }
  },
  components: {
    'update': require('modules/editor/Update.vue'),
    'editor': require('modules/editor/Editor.vue')
  },
  props: {
    item: Object
  },
  methods: {
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
