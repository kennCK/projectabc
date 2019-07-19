<template>
  <div>
    <div class="modal-body">
      <div class="form-group col-lg-12" style="float: left;">
        <label for="exampleInputEmail1">Title</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter title of template" v-model="newTemplate.title">
      </div>
      <div class="form-group col-lg-12" style="float: left;">
        <label for="exampleInputEmail1">Category</label>
        <select class="form-control" v-model="newTemplate.category">
          <option v-for="(item, index) in categories" :key="index" :value="item">{{item}}</option>
        </select>
      </div>
      <div class="form-group col-lg-6" style="float: left;">
        <label for="exampleInputEmail1">Width</label>
        <input type="number" class="form-control" v-model="newTemplate.width">
        <small id="emailHelp" class="form-text text-muted">Pixel</small>
      </div>
      <div class="form-group col-lg-6" style="float: left;">
        <label for="exampleInputEmail1">Height</label>
        <input type="number" class="form-control" v-model="newTemplate.height">
        <small id="emailHelp" class="form-text text-muted">Pixel</small>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" @click="hide()">{{global.template.contents.prompts.btn.no}}</button>
      <button type="button" class="btn btn-primary" @click="yes()">{{global.template.contents.prompts.btn.yes}}</button>
    </div>
  </div>
</template>
<style lang="scss" scoped>
@import "~assets/style/colors.scss";
.form-control{
  font-size: 11px !important;
}
</style>
<script>
import CONFIG from 'src/config.js'
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
import GLOBAL from 'src/modules/editorv2/global.js'
export default {
  data () {
    return {
      global: GLOBAL,
      categories: ['Tarpaulin', 'Tshirt'],
      newTemplate: {
        title: null,
        category: null,
        status: 'personal',
        purchased: null,
        width: null,
        height: null
      }
    }
  },
  methods: {
    hide(){
      $('#promptMessage').modal('hide')
    },
    yes(){
      if(GLOBAL.template.contents.prompts.payload === 'new_template'){
        this.addTemplate()
      }
    },
    addTemplate(){
      let height = this.newTemplate.height
      let width = this.newTemplate.width
      GLOBAL.template.contents.optionFlag = false
      GLOBAL.template.title = this.newTemplate.title
      GLOBAL.template.category = this.newTemplate.category
      GLOBAL.template.status = this.newTemplate.status
      GLOBAL.template.purchased = this.newTemplate.purchased
      GLOBAL.template.optionFlag = false
      GLOBAL.template.contents.content = {
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
      GLOBAL.template.contents.setting.page = {
        height: height,
        width: width
      }
      GLOBAL.template.contents.setting.zoom = {
        height: height,
        width: width
      }
      GLOBAL.saveSetting = false
      this.hide()
    }
  }
}
</script>
