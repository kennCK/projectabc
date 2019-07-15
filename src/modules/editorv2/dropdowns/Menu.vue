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
  z-index: 20;
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
      }],
      template: GLOBAL.template
    }
  },
  methods: {
    select(item, index) {
      if(item.subMenu.length > 0){
        this.show(index)
        return
      }
      this.$emit('closed', item)
      switch(item.payload){
        case 'new_template':
          if(this.template.contents === null){
            this.addTemplate()
            this.template.leftPane.title = 'Pages'
            this.template.leftPane.index = 3
            this.template.overlay.title = null
          } else {
            this.template.prompts = {
              title: 'Unsave Template',
              message: 'You have unsave work. Are you sure you want to disregard this changes?',
              btn: {
                yes: 'Yes',
                no: 'No'
              }
            }
            $('#promptMessage').modal('show')
          }
          break
        case 'marketplace_template':
          this.template.selectedTopMenu = 'Marketplace'
          this.template.leftPane.title = 'Marketplace'
          this.template.leftPane.index = 1
          this.template.overlay.title = null
          break
        case 'designer':
          this.template.selectedTopMenu = 'Designers'
          this.template.leftPane.title = 'Designers'
          this.template.leftPane.index = 0
          this.template.overlay.title = null
          break
        case 'printing':
          this.template.selectedTopMenu = 'Printing'
          this.template.leftPane.title = 'Printing'
          this.template.leftPane.index = 2
          this.template.overlay.title = null
          break
      }
    },
    addTemplate(){
      let height = 300
      let width = 500
      this.template.title = 'This is a test'
      this.template.category = 'Tarpaulin'
      this.template.status = 'personal'
      this.template.purchased = null
      this.template.optionFlag = false
      this.template.contents = {
        style: {
          height: height + 'px',
          width: width + 'px',
          background: '#ffffff'
        },
        pages: [],
        plugins: [],
        selected_page: null,
        selected_plugin: null
      }
      this.template.setting.page = {
        height: height,
        width: width
      }
      this.template.setting.zoom = {
        height: height,
        width: width
      }
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
