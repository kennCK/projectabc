<template>
  <div class="attributes-holder">
    <div class="error text-danger" v-if="errorMessage !== null">{{errorMessage}}</div>
    <div class="form-group">
      <label for="exampleInputEmail1" style="font-weight: 600;">Variations</label>
      <div>
        <select class="form-control form-control-custom" style="width: 45%; float: left;" v-model="newAttribute.payload">
          <option value="color">Color</option>
          <option value="size">Size</option>
        </select>
        <input type="text" class="form-control form-control-custom" style="float: left; width: 40%; margin-left: 10px;" placeholder="Type attribute value here..." v-model="newAttribute.payload_value" @keyup.enter="create()">
        <button class="btn btn-primary form-control-custom" style="margin-left: 10px;" @click="create()"><i class="fa fa-plus"></i></button>
      </div>
    </div>
    <div class="attributes-content" v-if="item.size !== null">
      <label class="title">Size</label>
      <div class="attribute-item" v-for="itemSize, indexSize in item.size">
        <input type="text" class="form-control form-control-custom" style="float: left; width: 80%;" placeholder="Type variation value here..." v-model="itemSize.payload_value" @keyup.enter="update(itemSize)">
        <button class="btn btn-primary form-control-custom" style="margin-left: 10px;" @click="update(itemSize)">
          <i class="fa fa-sync"></i>
        </button>
        <button class="btn btn-danger form-control-custom" style="margin-left: 10px;" @click="deleteItem(itemSize)">
          <i class="fa fa-trash"></i>
        </button>
      </div>
    </div>
    <div class="attributes-content" v-if="item.color !==  null">
      <label class="title">Color</label>
      <div class="attribute-item" v-for="itemColor, indexColor in item.color">
        <input type="text" class="form-control form-control-custom" style="float: left; width: 80%;" placeholder="Type variation value here..." v-model="itemColor.payload_value" @keyup.enter="update(itemColor)">
        <button class="btn btn-primary form-control-custom" style="margin-left: 10px;" @click="update(itemColor)">
          <i class="fa fa-sync"></i>
        </button>
        <button class="btn btn-danger form-control-custom" style="margin-left: 10px;" @click="deleteItem(itemColor)">
          <i class="fa fa-trash"></i>
        </button>
      </div>
    </div>
  </div>
</template>
<style scoped>
.attributes-holder{
  width: 100%;
  float: left;
  min-height: 100px;
  overflow-y: hidden;
}
.error{
  width: 100%;
  float: left;
  line-height: 50px;
}
.attributes-content{
  width: 100%;
  float: left;
  min-height: 50px;
  overflow-y: hidden;
}
.attributes-content .title{
  height: 50px;
  width: 100%;
  float: left;
  font-weight: 600;
  line-height: 50px;
}
.attribute-item{
  width: 100%;
  float: left;
  height: 50px;
  margin-bottom: 15px;
}
.form-control-custom{
  height: 50px !important;
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
  props: ['item'],
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      newAttribute: {
        product_id: this.item.id,
        payload: null,
        payload_value: null
      }
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    create(){
      if(this.newAttribute.payload_value !== null && this.newAttribute.payload_value !== ''){
        this.APIRequest('product_attributes/create', this.newAttribute).then(response => {
          if(response.data > 0){
            this.newAttribute.payload_value = null
            this.errorMessage = null
            this.$parent.retrieve()
          }
        })
      }else{
        this.errorMessage = 'Fill up the required fields.'
      }
    },
    deleteItem(item){
      let parameter = {
        id: item.id
      }
      this.APIRequest('product_attributes/delete', parameter).then(response => {
        this.$parent.retrieve()
      })
    },
    update(item){
      if(item.payload_value !== null && item.payload_value !== ''){
        this.APIRequest('product_attributes/update', item).then(response => {
          if(response.data === true){
            this.errorMessage = null
            this.$parent.retrieve()
          }
        })
      }else{
        this.errorMessage = 'Fill up the required fields.'
      }
    }
  }
}
</script>
