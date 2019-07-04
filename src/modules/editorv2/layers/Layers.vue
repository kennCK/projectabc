<template>
  <div class="layer-holder">
    <ul class="layer-wrapper">
      <li class="layer-item">
        <i class="fas fa-plus pull-right" @click="add()"></i>
        <i class="fa fa-trash text-danger pull-right"></i>
        <i class="fa fa-clone text-primary pull-right"></i>
      </li>
      <li class="layer-item" v-for="(item, index) in page.layers" :key="index" v-bind:class="{'active': page.selected_layer === index}" @click="page.selected_layer = index">

        <i class="fa" v-bind:class="{'fa-eye': item.eye === true,  'fa-eye-slash': item.eye === false}" @click="item.eye = !item.eye"></i>
        
        <i class="fas" v-bind:class="{'fa-unlock': item.locked === false,  'fa-lock': item.locked === true}" @click="item.locked = !item.locked"></i>
        

        <span v-if="item.edit_flag === false" @dblclick="item.edit_flag = true">{{item.title + (index + 1)}}</span>
        
        <input type="text" v-model="item.title" v-if="item.edit_flag === true" @keyup.enter="item.edit_flag = false"> 

        <i class="fas fa-chevron-down pull-right" v-if="item.show === false && item.objects.length > 0" @click="item.show = true"></i>
        
        <i class="fas fa-chevron-up pull-right" v-if="item.show === true && item.objects.length > 0" @click="item.show = false"></i>

        <ul v-if="item.type === 'frame' && item.show === true">
          <li v-for="(lItem, lIndex) in item.objects" :key="lIndex">
            <i class="fa fa-image" v-if="lItem.type === 'image'"></i>
            <i class="fa fa-square" v-if="lItem.type === 'object'"></i>
            <i class="fa fa-paragraph" v-if="lItem.type === 'text'"></i>
            <span v-if="lItem.edit_flag === false" @dblclick="lItem.edit_flag = true">{{lItem.title}}</span>
            <input type="text" v-model="lItem.title"  v-if="lItem.edit_flag === true" @keyup.enter="lItem.edit_flag = false">
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

  .active{
    background: $gray;
    color: white;
  }
</style>
<script>
export default {
  data () {
    return {
    }
  },
  props: ['page'],
  methods: {
    add(){
      let layer = {
        title: 'Layer ',
        edit_flag: false,
        style: this.page.style,
        eye: false,
        show: false,
        objects: [],
        selected_object: null,
        locked: false
      }
      this.page.layers.push(layer)
    }
  }
}
</script>
