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
                  <li @click="addObject('text')">T</li>
                  <li @click="addObject('division')">
                    <i class="far fa-clone"></i>
                  </li>
                  <li @click="addObject('photo')">
                    <i class="fa fa-picture-o"></i>
                  </li>
                  <li @click="unSelected()">
                    <i class="fas fa-close"></i>
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
                <span class="layers">
                  <span class="header">Layers</span>
                  <span class="layers-holder">
                    <span class="item" v-bind:class="{'layer-selected': item.selected === true}" v-for="item, index in objects" v-if="objects !== null" @click="setSelectedObject(item, index)" >{{item.type}}</span>
                  </span>
                </span>
                <span class="card-holder">
                  <span v-for="item, index in objects" v-bind:class="{'text': item.type === 'text', 'division': item.type === 'division', 'photo': item.type === 'photo', 'object-selected': item.selected === true}" v-bind:style="item.attributes" @click="setSelectedObject(item, index)">
                    <label v-if="item.type === 'text'">{{item.content}}</label>
                    <img :src="config.BACKEND_URL + item.content" v-if="item.type === 'photo' && item.content !== null && item.content.includes('storage')" height="100%" width="
                    100%">
                  </span>
                </span>
                <span class="object-settings" v-if="selected !== null">
                  <division v-if="selected !== null && selected.type === 'division'" :object="selected"></division>
                  <photo v-if="selected !== null && selected.type === 'photo'" :object="selected"></photo>
                  <c-text v-if="selected !== null && selected.type === 'text'" :object="selected"></c-text>
                </span>
              </span>
            </span>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" @click="close()">Cancel</button>
              <button type="button" class="btn btn-primary" @click="save()">Save</button>
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
.layers{
  width: 150px;
  height: 200px;
  overflow-y: hidden;
  position: absolute;
  border: solid 1px #ddd;
  left: 8%;
}

.layers .header{
  height: 30px;
  width: 100%;
  float: left;
  text-align: center;
  line-height: 30px;
  border-bottom: solid 1px #eee;
}
.layers .layers-holder{
  min-height: 170px;
  max-height: 170px;
  float: left;
  width: 100%;
  overflow-y: scroll;
}
.layers-holder .item{
  width: 100%;
  height: 30px;
  float: left;
  padding-left: 5px;
  border-bottom: solid 1px #eee;
  line-height: 30px;
}
.layers-holder .item:hover{
  cursor: pointer;
}
.card-holder{
  width: 204px;
  height: 324px;
  left: 35%;
  position: absolute;
  border: solid 1px #ddd;
}
.object-settings{
  width: 225px;
  min-height: 10px;
  overflow-y: hidden;
  position: absolute;
  border: solid 1px #ddd;
  right: 10px;
}

.division, .text, .photo{
  position: absolute;
  cursor: move;
}
.text, .photo{
  background: rgba(250, 250, 250, 0) !important;
}
.object-selected{
  border: dashed 1px #22b173;
}
.layer-selected{
  background: #22b173;
  color: #fff;
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
      prevIndex: null,
      selected: null,
      objects: null
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
      ROUTER.go('/')
    },
    addObject(type){
      if(this.objects === null){
        this.objects = []
      }else{
        //
      }
      let object = null
      if(type === 'text'){
        object = {
          template_id: this.item.id,
          new: true,
          name: null,
          content: 'TEXT',
          settings: 'static',
          type: 'text',
          selected: false,
          attributes: {
            height: '50px',
            width: '100%',
            fontFamily: 'Arial',
            fontSize: '100%',
            fontStyle: 'normal',
            textDecoration: 'normal',
            background: '#fff',
            color: '#028170',
            top: '40%',
            bottom: '0%',
            left: '0%',
            right: '0%',
            borderRadius: '0%',
            textAlign: 'center',
            fontWeight: '500',
            zIndex: 3,
            lineHeight: '50px'
          }
        }
      }else if(type === 'division'){
        object = {
          template_id: this.item.id,
          new: true,
          name: null,
          content: null,
          settings: 'static',
          type: 'division',
          selected: false,
          attributes: {
            height: '50px',
            width: '100%',
            background: '#028170',
            color: '#028170',
            top: '40%',
            bottom: '0%',
            left: '0%',
            right: '0%',
            borderRadius: '0%',
            zIndex: 1
          }
        }
      }else if(type === 'photo'){
        object = {
          template_id: this.item.id,
          new: true,
          name: null,
          content: '/storage/image/default.png',
          settings: 'static',
          type: 'photo',
          selected: false,
          attributes: {
            height: '35%',
            width: '60%',
            background: '#028170',
            color: '#028170',
            top: '10%',
            bottom: '0%',
            left: '0%',
            right: '0%',
            borderRadius: '0%',
            zIndex: 2
          }
        }
      }
      this.objects.push(object)
      this.setSelectedObject(this.objects[this.objects.length - 1], this.objects.length - 1)
    },
    setSelectedObject(object, index){
      if(this.prevIndex === null){
        this.prevIndex = index
        this.objects[this.prevIndex].selected = true
      }else{
        if(this.prevIndex !== index){
          this.objects[this.prevIndex].selected = false
          this.objects[index].selected = true
          this.prevIndex = index
        }
      }
      this.selected = object
    },
    unSelected(){
      this.objects[this.prevIndex].selected = false
      this.prevIndex = null
      this.selected = null
    },
    retrieve(){
      if(this.item !== null){
        let parameter = {
          condition: [{
            value: this.item.id,
            column: 'template_id',
            clause: '='
          }]
        }
        this.APIRequest('objects/retrieve', parameter).then(response => {
          if(response.data.length > 0){
            this.objects = response.data
            this.prevIndex = null
            this.setSelectedObject(this.objects[0], 0)
          }else{
            this.objects = null
            this.prevIndex = null
            this.selected = null
          }
        })
      }
    },
    save(){
      let parameter = {
        'objects': this.objects
      }
      this.APIRequest('objects/create', parameter).then(response => {
        if(response.data === true){
          this.retrieve()
        }else{
          // error
        }
      })
    }
  }
}
</script>
