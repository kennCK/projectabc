<template>
  <div class="editor-v2">
    <div class="editor-header">
      <span class="pull-left">
        <i class="fa fa-bars editor-menu" v-bind:class="{'gray': activeDropdown === 'mainMenu'}" @click="showDropdown('mainMenu')"></i>
        <dropdown-menu v-if="activeDropdown === 'mainMenu'"></dropdown-menu>
      </span>
      
      <span class="editor-dropdown text-white" @click="showDropdown('moveScale')">
        <label>{{selectedMoveScale}}</label>
        <i class="fa fa-chevron-down"></i>
        <dropdown-movescale v-if="activeDropdown === 'moveScale'" @moveEvent="selectedMoveScale = $event"></dropdown-movescale>
      </span>
      
      <span class="editor-dropdown text-white" @click="showDropdown('zoom')">
        <label>{{selectedZoom}}%</label>
        <i class="fa fa-chevron-down"></i>
        <dropdown-zoom v-if="activeDropdown === 'zoom'" @zoomEvent="selectedZoom = $event"></dropdown-zoom>
      </span>

      <span class="editor-dropdown text-white" @click="showDropdown('text')">
        <label style="padding: 0px 5px;">T</label>
      </span>

      <span class="editor-dropdown text-white" @click="showDropdown('image')">
        <label style="padding: 0px 5px;">
          <i class="fa fa-image"></i>
        </label>
      </span>
      <span class="editor-dropdown text-white" @click="showDropdown('frame')">
        <label style="padding: 0px 5px;">
          <i class="fas fa-dice-d6"></i>
        </label>
      </span>

      <span class="editor-dropdown text-white" @click="showDropdown('object')">
        <label>
          <i v-bind:class="selectedObject" class="text-white"></i>
        </label>
        <i class="fa fa-chevron-down"></i>
        <dropdown-object v-if="activeDropdown === 'object'" @objectEvent="selectedObject = $event"></dropdown-object>
      </span>

      <span class="editor-dropdown text-white" @click="showDropdown('settings')">
        <label>
          <i class="fas fa-cog text-white"></i>
        </label>
        <i class="fa fa-chevron-down"></i>
        <dropdown-settings v-if="activeDropdown === 'settings'" @objectEvent="selectedObject = $event"></dropdown-settings>
      </span>

      <label class="text-white" style="font-size: 13px; padding-left: 100px;">
        {{title}}
      </label>
      <span class="pull-right">
        <button class="btn btn-danger">Save</button>
        <button class="btn btn-warning">Add to cart</button>
        <i class="fa fa-phone audio-call bg-white text-primary action-link" @click="auth.triggerAudioCall()"></i>
      </span>
    </div>
    <div class="editor-body">
      <editor-body :color="color"></editor-body>
<!--       <color-picker :color="color" @selectedColor="color = $event"></color-picker> -->
    </div>
  </div>
</template>
<style lang="scss" scoped>
@import "~assets/style/colors.scss";
.editor-v2{
  width: 100%;
  float: left;
  height: auto;
  font-size: 11px;
}
.editor-header{
  width: 100%;
  float: left;
  height: 40px;
  background: $primary;
}


.editor-menu{
  font-size: 16px;
  color: white;
  width: 40px;
  height: 40px;
  line-height: 40px;
  text-align: center;
  float: left;
}

.editor-header button{
  margin-top: 5px;
  margin-right: 5px;
  height: 30px !important;
  padding-top: 5px;
  font-size: 12px;
}

.editor-header label{
  line-height: 40px;
  margin-bottom: 0px;
  float: left;
}

.editor-menu:hover, .editor-dropdown:hover, .editor-dropdown label:hover{
  background: gray;
  cursor: pointer;
}

.audio-call{
  width: 30px;
  height: 30px;
  text-align: center;
  border-radius: 50%;
  line-height: 30px;
  margin-top: 5px;
  font-size: 16px;
  float: left;
  margin-right: 5px;
  float: left;
}

.editor-tools{
  width: 100%;
  float: left;
  height: 40px;
  border-bottom: solid 1px #ccc;
  border-top: solid 1px #ccc;
  line-height: 40px;
}
.gray{
  background: gray;
}

.editor-body{
  width: 100%;
  float: left;
  height: calc(100vh - 40px);
  background: white;
}

.editor-dropdown{
  height: 40px;
  float: left;
  padding-left: 10px;
  padding-right: 10px;
  line-height: 40px;
}

.editor-dropdown label{
  padding-right: 5px;
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      title: 'Test',
      auth: AUTH,
      selectedZoom: 100,
      selectedMoveScale: 'Move',
      selectedObject: 'fas fa-square',
      activeDropdown: null,
      color: '#ffffff'
    }
  },
  components: {
    'dropdown-menu': require('modules/editorv2/dropdowns/Menu.vue'),
    'editor-body': require('modules/editorv2/Body.vue'),
    'dropdown-zoom': require('modules/editorv2/dropdowns/Zoom.vue'),
    'dropdown-movescale': require('modules/editorv2/dropdowns/MoveScale.vue'),
    'dropdown-object': require('modules/editorv2/dropdowns/Objects.vue'),
    'dropdown-settings': require('modules/editorv2/dropdowns/Settings'),
    'color-picker': require('modules/editorv2/colors/Picker.vue')
  },
  methods: {
    showDropdown(item){
      if(item === this.activeDropdown){
        this.activeDropdown = null
      }else{
        this.activeDropdown = item
      }
    }
  }
}
</script>
