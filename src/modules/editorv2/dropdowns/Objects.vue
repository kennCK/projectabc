<template>
  <div class="menu-holder">
    <ul class="editor-menu">
      <li v-for="(item, index) in menus" :key="index" @click="select(item)">
        <i v-bind:class="item.icon"  class="text-white" style="padding-right: 10px;"></i>
        {{item.title}}
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
export default{
  data () {
    return {
      menus: [{
        title: 'Square',
        icon: 'fas fa-square'
      }, {
        title: 'Triangle',
        icon: 'fas fa-mountain'
      }, {
        title: 'Star',
        icon: 'fas fa-star'
      }]
    }
  },
  methods: {
    select(item) {
      this.$emit('objectEvent', item.icon)
    }
  }
}
</script>
