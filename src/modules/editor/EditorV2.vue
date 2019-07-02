<template>
  <div class="editor-v2">
    <div class="editor-header">
      <span class="pull-left">
        <label class="text-primary" style="font-size: 18px;">{{title}}</label>
      </span>
      <span class="pull-right">
        <button class="btn btn-primary">Save</button>
        <button class="btn btn-warning">Add to cart</button>
        <i class="fa fa-phone audio-call bg-primary action-link"></i>
      </span>
    </div>
    <div class="editor-tools">
    </div>
  </div>
</template>
<style lang="scss" scoped>
@import "~assets/style/colors.scss";
.editor-v2{
  width: 100%;
  float: left;
  height: auto;
}
.editor-header{
  width: 100%;
  float: left;
  height: 50px;
  line-height: 50px;
}

.editor-tools{
  width: 100%;
  float: left;
  height: 40px;
  border-bottom: solid 1px #ccc;
  border-top: solid 1px #ccc;
  line-height: 40px;
}

.audio-call{
  width: 40px;
  height: 40px;
  text-align: center;
  border-radius: 50%;
  line-height: 40px;
  margin-top: 7px;
  font-size: 24px;
  float: left;
  margin-right: 5px;
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
      title: 'Test'
    }
  },
  components: {
    'division': require('modules/editor/Div.vue'),
    'photo': require('modules/editor/Photo.vue'),
    'c-text': require('modules/editor/Text.vue'),
    'basic-text': require('modules/editor/BasicText.vue'),
    'basic-photo': require('modules/editor/BasicPhoto.vue'),
    'basic-div': require('modules/editor/BasicDiv.vue'),
    'browse-images': require('components/increment/generic/image/BrowseImages.vue')
  },
  methods: {
  }
}
</script>
