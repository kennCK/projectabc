<template>
  <div id="editor">
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
                <span v-bind:style="{height: parseInt(item.height) + 'px', width: parseInt(item.width)  + 'px', left: (parseInt(item.height) === config.PORTRAIT) ? '35%' : '29%'}" class="card-holder">
                  <span v-for="item, index in objects">
                    <span class="division" v-bind:class="{'object-selected': item.selected === true}" v-if="item.type === 'division'" v-bind:style="item.attributes" @click="setSelectedObject(item, index)">
                    </span>
                    <label class="text" v-bind:class="{'object-selected': item.selected === true}" v-if="item.type === 'text'" v-bind:style="item.attributes" @click="setSelectedObject(item, index)">{{item.content}}</label>
                    <img class="photo" v-bind:class="{'object-selected': item.selected === true}" :src="config.BACKEND_URL + item.content" v-if="item.type === 'photo'" :style="item.attributes" @click="setSelectedObject(item, index)">
                  </span>
                </span>
                <span class="object-settings" v-if="selected !== null">
                  <division v-if="selected !== null && selected.type === 'division'" :object="selected" :index="selectedIndex"></division>
                  <photo v-if="selected !== null && selected.type === 'photo'" :object="selected" :index="selectedIndex"></photo>
                  <c-text v-if="selected !== null && selected.type === 'text'" :object="selected" :index="selectedIndex"></c-text>
                </span>
              </span>
            </span>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" @click="close()" v-if="saveFlag === 0 || saveFlag === 1">Close</button>
              <button type="button" class="btn btn-primary" @click="save()" v-if="saveFlag === 1">Save</button>
              <span class="loading-save" v-if="saveFlag === 2">
                <i class="fas fa-circle-o-notch fa-spin"></i> Saving...
              </span>
              <span class="loading-save" v-if="saveFlag === 3">
                Successfully Updated!
              </span>
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
  min-height: 400px;
  overflow-y: hidden;
}
.tools{
  width: 5%;
  float: left;
  min-height: 400px;
  overflow-y: hidden;
  border-right: solid 1px #eee;
}
.preview{
  width: 95%;
  float: left;
  min-height: 400px;
  overflow-y: hidden;
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
.loading-save{
  line-height: 35px;
  color: #22b173;
  float: left;
  height: 35px;
}
.loading-save i{
  font-size: 18px;
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
      selectedIndex: null,
      objects: null,
      saveFlag: 0
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
      this.$parent.retrieve(-1)
      $('#templateEditorModal').modal('hide')
    },
    addObject(type){
      this.saveFlag = 1
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
            lineHeight: '50px',
            textTransform: 'uppercase',
            transform: 'rotate(0deg)',
            opacity: 1,
            borderTop: '0px',
            borderBottom: '0px',
            borderLeft: '0px',
            borderRight: '0px',
            paddingLeft: '0px'
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
            zIndex: 1,
            transform: 'rotate(0deg)',
            opacity: 1,
            border: '0px'
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
            zIndex: 2,
            transform: 'rotate(0deg)',
            opacity: 1
          }
        }
      }
      this.objects.push(object)
      this.setSelectedObject(this.objects[this.objects.length - 1], this.objects.length - 1)
    },
    setSelectedObject(object, index){
      this.saveFlag = 1
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
      this.selectedIndex = index
    },
    unSelected(){
      this.saveFlag = 1
      this.objects[this.prevIndex].selected = false
      this.prevIndex = null
      this.selected = null
      this.selectedIndex = null
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
        objects: this.objects
      }
      this.saveFlag = 2
      this.APIRequest('objects/create', parameter).done(response => {
        this.saveFlag = 3
        if(response.data === true){
          this.retrieve()
        }
      })
    },
    removeObject(index){
      this.objects.splice(index, 1)
      this.prevIndex = null
      this.setSelectedObject(this.objects[0], 0)
    }
  }
}
</script>
