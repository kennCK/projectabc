<template>
  <div class="menu-holder">
    <ul class="editor-menu">
      <li v-for="(item, index) in menus" :key="index" @click="select(item, index)">
        {{item.title}}
        <i class="fas fa-chevron-right pull-right" style="padding-right: 5px; line-height: 30px;" @click="show(index)" v-if="item.subMenu.length > 0"></i>
        <span class="menu-holder1" v-if="item.subMenu.length > 0 && item.show === true">
          <ul class="editor-menu">
            <li v-for="(subItem, subIndex) in item.subMenu" :key="subIndex" @click="select(subItem, index)">{{subItem.title}}</li>
          </ul>
        </span>
      </li>
    </ul>
  </div>
</template>
<style lang="scss" scoped>
@import "~assets/style/colors.scss";
.menu-holder{
  position: absolute;
  top: 45px;
  min-height: 50px;
  overflow-y: hidden;
  min-width: 50px;
  overflow-x: hidden;
}

.menu-holder1{
  position: absolute;
  min-height: 50px;
  overflow-y: hidden;
  width: 150px;
  left: 155px;
}

.editor-menu{
  padding: 0px;
  margin: 0px;
  width: 150px;
  float: left;
  background: gray;
  color: white;
  list-style: none;
}
.editor-menu li{
  width: 100%;
  float: left;
  height: 30px;
  line-height: 30px;
  padding-left: 10px;
  position: relative;
}
.editor-menu li:hover{
  color: $secondary;
  cursor: pointer;
}
</style>
<script>
import GLOBAL from 'src/modules/editorv2/global.js'
export default{
  data () {
    return {
      prevIndex: null,
      menus: [{
        title: 'Templates',
        payload: 'templates',
        show: false,
        subMenu: [{
          title: 'New Template',
          payload: 'new_template',
          subMenu: []
        }, {
          title: 'Marketplace',
          payload: 'marketplace_template',
          subMenu: []
        }]
      }, {
        title: 'Find Designer', subMenu: [], payload: 'designer'
      }, {
        title: 'Find Printing', subMenu: [], payload: 'printing'
      }, {
        title: 'Publish on marketplace', subMenu: [], payload: 'publish'
      }, {
        title: 'Export',
        payload: 'designer',
        show: false,
        subMenu: [{
          title: 'PNG',
          payload: 'export_png',
          subMenu: []
        }, {
          title: 'JPG',
          payload: 'export_jpg',
          subMenu: []
        }]
      }, {
        title: 'Print', subMenu: [], payload: 'print'
      }]
    }
  },
  methods: {
    select(item, index) {
      if(item.subMenu.length > 0){
        this.show(index)
        return
      }
      this.$emit('closed', item.title)
      switch(item.payload){
        case 'new_template':
          this.addTemplate()
          break
      }
    },
    addTemplate(){
      let newTemplate = {
        title: 'This is a test',
        type: 'Tarpaulin',
        edit_flag: false,
        contents: {
          style: {
            height: '300px',
            width: '500px',
            background: '#ffffff'
          },
          pages: [],
          plugins: [],
          selected_page: null,
          selected_plugin: null
        },
        purpose: 0,
        status: 0
      }
      GLOBAL.addTemplate(newTemplate)
    },
    show(index){
      if(this.prevIndex === null){
        this.prevIndex = index
        this.menus[index].show = true
      }else{
        this.menus[this.prevIndex].show = false
        if(this.prevIndex !== index){
          this.menus[index].show = true
          this.prevIndex = index
        }else{
          this.prevIndex = null
        }
      }
    }
  }
}
</script>
