<template>
  <div>
    <div v-bind:class="{'make-active': item !== null && item.active === true}" v-bind:style="{height: (parseInt(item.height) + 90) + 'px', width: (parseInt(item.width) + 1)  + 'px'}" class="item" v-if="item !== null">
      <span v-bind:class="{'make-active-header': item.active === true}" class="header">
        <b>
          {{item.title}}
        </b>
      </span>
      <span v-bind:style="{height: parseInt(item.height) + 'px', width: (parseInt(item.width) + 1)  + 'px'}" class="body">
        <span v-bind:style="{height: parseInt(item.height) + 'px', width: (parseInt(item.width) + 1)  + 'px'}" class="preview">
          <objects :objects="item.objects" v-if="item.objects !== null" :heightTemplate="parseInt(item.height)" :widthTemplate="parseInt(item.width)"></objects>
        </span>

        <ul v-if="item.active === true">
          <li @click="addToCart(item)">
            <label class="title">Add to Cart</label>
            <label class="price pull-right">PHP {{item.price}}</label>
          </li>
        </ul>
      </span>
    </div>
    <update></update>
    <editor></editor>
  </div>
</template>
<style scoped>
.item{
  float: left;
  border: solid 1px #ddd;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
  margin-right: 25px;
  margin-bottom: 25px;
}
.item:hover{
  cursor: pointer;
  border: solid 1px #22b173;
}
.make-active{
  border: solid 1px #22b173;
}
.header{
  width: 100%;
  float: left;
  height: 50px;
  text-align: center;
  line-height: 50px;
  border-bottom: solid 1px #ddd;
}
.make-active-header{
  background: #22b173;
  color: #fff;
}
.body{
  float: left;
  position: relative;
}
ul{
  padding: 0px;
  margin: 0px;
  width: 100%;
  float: left;
  z-index: 30;
  list-style: none;
  bottom: 0;
  height: 40px;
  background: #22b173;
  transition: 1s;
}
ul li{
  width: 100%;
  float: left;
  height: 40px;
  line-height: 40px;
  color: #fff;
}
ul li .title{
  padding-left: 10px;
}
ul li .price{
  padding-right: 10px;
}
ul li:hover, ul li .title:hover, ul li .price:hover{
  cursor: pointer;
  background: #028170;
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
    'objects': require('modules/object/Objects.vue')
  },
  props: ['item', 'index'],
  methods: {
    makeActive(){
      this.$parent.makeActive(this.index)
    },
    redirect(parameter){
      ROUTER.push(parameter)
    },
    show(item, id){
      for (var i = 0; i < this.$children.length; i++) {
        if(this.$children[i].$el.id === id){
          if(id === 'editor'){
            this.$children[i].item = item
            this.$children[i].retrieve()
            setTimeout(() => {
              $('#templateEditorModal').modal({
                backdrop: 'static',
                show: true,
                keyboard: false
              })
            }, 50)
          }else if(id === 'updateSettings'){
            this.$children[i].item = item
            setTimeout(() => {
              $('#updateTemplateModal').modal({
                backdrop: 'static',
                show: true,
                keyboard: false
              })
            }, 50)
          }
        }
      }
    },
    addToCart(item){
      let parameter = {
        account_id: this.user.userID,
        payload: 'template',
        payload_value: item.id,
        price: item.price,
        type: 'direct'
      }
      this.APIRequest('checkout_items/create', parameter).then(response => {
        if(response.data > 0){
          AUTH.checkAuthentication(null)
          this.$parent.retrieve()
        }
      })
    }
  }
}
</script>
