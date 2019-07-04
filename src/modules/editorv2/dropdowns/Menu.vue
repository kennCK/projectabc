<template>
  <div class="menu-holder">
    <ul class="editor-menu">
      <li v-for="(item, index) in menus" :key="index" @click="select(item)">{{item}}</li>
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
  width: 150px;
}
.editor-menu{
  padding: 0px;
  margin: 0px;
  width: 100%;
  float: left;
  height: auto;
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
      menus: ['Templates', 'Export as PNG', 'Export as JPG']
    }
  },
  methods: {
    select(item) {
      this.$emit('closed', item)
      switch(item){
        case 'Templates':
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
    }
  }
}
</script>
