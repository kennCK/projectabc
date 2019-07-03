<template>
  <div class="layer-holder">
    <ul class="layer-wrapper">
      <li class="layer-item" v-for="(item, index) in layers" :key="index">
        <i class="fa fa-image" v-if="item.type === 'image'"></i>
        <i class="fa fa-square" v-if="item.type === 'object'"></i>
        <i class="fa fa-paragraph" v-if="item.type === 'text'"></i>
        <i class="fas fa-dice-d6" v-if="item.type === 'frame'"></i>
        <span v-if="item.editFlag === false" @dblclick="item.editFlag = true">{{item.title}}</span>
        <input type="text" v-model="item.title" v-if="item.editFlag === true" @keyup.enter="item.editFlag = false"> 
        <i class="fas fa-chevron-down pull-right" v-if="item.type === 'frame' & item.show === false" @click="item.show = true"></i>
        <i class="fas fa-chevron-up pull-right" v-if="item.type === 'frame' & item.show === true" @click="item.show = false"></i>
        <ul v-if="item.type === 'frame' && item.show === true">
          <li v-for="(lItem, lIndex) in item.objects" :key="lIndex">
            <i class="fa fa-image" v-if="lItem.type === 'image'"></i>
            <i class="fa fa-square" v-if="lItem.type === 'object'"></i>
            <i class="fa fa-paragraph" v-if="lItem.type === 'text'"></i>
            <span v-if="lItem.editFlag === false" @dblclick="lItem.editFlag = true">{{lItem.title}}</span>
            <input type="text" v-model="lItem.title"  v-if="lItem.editFlag === true" @keyup.enter="lItem.editFlag = false">
          </li>
        </ul>
      </li>
    </ul>
  </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
  .layer-holder{
    width: 100%;
    float: left;
    min-height: 50px;
    overflow-y: hidden;
  }

  ul{
    width: 100%;
    float: left;
    min-height: 50px;
    padding: 0px;
    margin: 0px;
    overflow-y: hidden;
  }

  ul li{
    width: 100%;
    float: left;
    min-height: 30px;
    line-height: 30px;
    padding-left: 5px;
    color: black;
    overflow-y: hidden;
  }

  ul li i{
    color: black;
    padding-right: 5px;
  }

  ul li:hover{
    cursor: pointer;
    border-bottom: solid 1px $secondary;
  }

  input{
    border: none;
    height: 30px;
  }

  .pull-right{
    line-height: 30px;
  }
</style>
<script>
export default {
  data () {
    return {
      layers: [{
        title: 'test',
        editFlag: false,
        type: 'image',
        objects: []
      }, {
        title: 'background',
        editFlag: false,
        type: 'object',
        objects: []
      }, {
        title: 'title',
        editFlag: false,
        type: 'text',
        objects: []
      }, {
        title: 'title',
        editFlag: false,
        type: 'frame',
        show: false,
        objects: [{
          title: 'test',
          editFlag: false,
          type: 'image'
        }, {
          title: 'background',
          editFlag: false,
          type: 'object'
        }, {
          title: 'title',
          editFlag: false,
          type: 'text'
        }]
      }]
    }
  }
}
</script>
