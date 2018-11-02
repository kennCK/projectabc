<template>
  <div>
    <div class="modal fade" id="templateEditorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" v-if="item !== null">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">{{item.title}}</h5>
            <button type="button" class="close" @click="close()" aria-label="Close">
              <span aria-hidden="true" class="text-white">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <span v-if="errorMessage !== null" class="text-danger text-center">
                <label><b>Opps! </b>{{errorMessage}}</label>
            </span>
            <span class="editor-holder">
              <span class="tools">
                <ul>
                  <li @click="setObject('text')">T</li>
                  <li @click="setObject('division')">
                    <i class="far fa-clone"></i>
                  </li>
                  <li @click="setObject('photo')">
                    <i class="fa fa-picture-o"></i>
                  </li>
                  <li>
                    <i class="fas fa-search-plus"></i>
                  </li>
                  <li>
                    <i class="fas fa-search-minus"></i>
                  </li>
                </ul>
                
              </span>
              <span class="preview">
                <span class="card-holder">
                </span>
                <span class="object-settings">
                  <division v-if="selected === 'division'"></division>
                  <photo v-if="selected === 'photo'"></photo>
                  <c-text v-if="selected === 'text'"></c-text>
                </span>
              </span>
            </span>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" @click="close()">Cancel</button>
              <button type="button" class="btn btn-primary" @click="submit()">Save</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.editor-holder{
  width: 100%;
  float: left;
  height: 55vh;
}
.tools{
  width: 5%;
  float: left;
  height: 55vh;
  border-right: solid 1px #eee;
}
.preview{
  width: 95%;
  float: left;
  height: 55vh;
}
ul{
  list-style: none;
  width: 100%;
  float: left;
  padding: 0px;
  margin: 0px;
}
ul li{
  width: 100%;
  float: left;
  height: 40px;
  line-height: 40px;
  text-align: center;
  border-bottom: solid 1px #028170;
}
ul li:hover{
  cursor: pointer;
  background: #028170;
  color: #fff;
}
.card-holder{
  width: 204px;
  height: 324px;
  left: 35%;
  position: absolute;
  border: solid 1px #ddd;
}
.object-settings{
  width: 200px;
  min-height: 10px;
  overflow-y: hidden;
  position: absolute;
  border: solid 1px #ddd;
  right: 10px;
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
      errorMessage: null,
      item: null,
      selected: 'text'
    }
  },
  components: {
    'division': require('modules/editor/Div.vue'),
    'photo': require('modules/editor/Photo.vue'),
    'c-text': require('modules/editor/Text.vue')
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    close(){
      this.item = null
      $('#templateEditorModal').modal('hide')
    },
    setObject(object){
      this.selected = object
    }
  }
}
</script>
