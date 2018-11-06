<template>
  <div>
    <div class="item" v-if="item !== null">
      <span class="body">
        <span class="preview">
          <span v-for="obj, innerIndex in item.back_objects" v-if="item.back_objects !== null">
              <span class="division" v-if="obj.type === 'division'" v-bind:style="obj.attributes">
              </span>
              <label class="text" v-if="obj.type === 'text'" v-bind:style="obj.attributes">{{obj.content}}</label>
              <img class="photo" :src="config.BACKEND_URL + obj.content" v-if="obj.type === 'photo'" :style="obj.attributes">
          </span>
        </span>
      </span>
    </div>
    <update></update>
    <editor></editor>
    <edit></edit>
    <print></print>
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
  components: {
    'update': require('modules/editor/Update.vue'),
    'editor': require('modules/editor/Editor.vue'),
    'comments': require('modules/comment/Comments.vue'),
    'edit': require('modules/employee/Edit.vue'),
    'print': require('modules/print/Print.vue')
  },
  props: ['item', 'index'],
  methods: {
    makeActive(){
      this.$parent.makeActive(this.index)
    },
    redirect(parameter){
      ROUTER.push(parameter)
    },
    showComments(id){
      $('#overlay-' + id).css({'display': 'block'})
    },
    hideComments(id){
      $('#overlay-' + id).css({'display': 'none'})
    },
    retrieve(){
      this.$parent.retrieve()
    },
    editProfile(id){
      for (var i = 0; i < this.$children.length; i++) {
        if(this.$children[i].$el.id === 'editProfile'){
          this.$children[i].id = id
          this.$children[i].modal()
        }
      }
    },
    updateStatus(status, id){
      let parameter = {
        id: id,
        status: status
      }
      this.APIRequest('employees/update', parameter).then(response => {
        if(response.data === true){
          this.$parent.retrieve()
        }
      })
    },
    print(){
      for (var i = 0; i < this.$children.length; i++) {
        if(this.$children[i].$el.id === 'printer'){
          this.$children[i].item = this.item
          this.$children[i].objects = this.item.front_objects
          this.$children[i].modal()
        }
      }
    }
  }
}
</script>
