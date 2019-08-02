<template>
  <div class="contents-wrapper" v-if="data !== null">
    <div :class="`content-item ${listStyle}`" v-for="(template, index) in templates" :key="index" @click="redirect('/editor/v2/' + template.code)">
      <div class="item-content">
        <thumbnail :template="template" :zoom="50"></thumbnail>
      </div>
      <div class="item-title">
        {{template.title}}
      </div>
    </div>
  </div>
  <dynamic-empty v-else :title="'No products yet!'" :action="'Please add new designs.'" :icon="'far fa-smile'" :iconColor="'text-primary'"></dynamic-empty>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.list-style {
  width: 35% !important;
  margin-right: 100% !important;
  height: 300px !important;
}
.four-columns{
  width: 21% !important;
  height: 300px !important;
}
.three-columns{
  width: 29% !important;
  height: 300px !important;
}
.two-columns{
  width: 46% !important;
  height: 300px !important;
}
.contents-wrapper{
  width: 100%;
  height: auto;
  float: left;
  margin-bottom: 15px;
  margin-top: 25px;
}
.content-item{
  border: 1px solid $gray;
  float: left;
  width: 25%;
  min-height: 50px;
  overflow-y: hidden;
  margin-right: 40px;
  margin-bottom: 40px;
}
.content-item:hover{
  cursor: pointer;
  border: solid 1px $gray;
  background: $gray;
  .item-title{
    background: white;
  }
}
.item-title{ 
  float: left;
  text-align: center;
  color: black;
  width: 100%;
  padding-top: 13px;
  min-height: 50px !important;
  border-top: solid 1px $gray;
}
.item-content{
  float: left;
  position: relative;
  width: 100%;
  height: 250px;
}
@media (max-width: 991px){
  .contents-wrapper{
    width: 180%;
    height: auto;
    float: left;
    margin-bottom: 15px;
    margin-top: 25px;
}
  .content-item{
    border: 1px solid $gray;
    float: left;
    width: 25%;
    min-height: 50px;
    overflow-y: hidden;
    margin-right: 50%;
    margin-left: 10%;
    margin-bottom: 10px;
}
  .item-title{ 
    float: left;
    text-align: center;
    color: black;
    width: 100%;
    height: 50px;
    line-height: 50px;
}
  .item-content{
    float: left;
    width: 100%;
    height: 200px;
    position: relative;
    min-height: 10px;
}

}
</style>
<script>
import AUTH from 'src/services/auth'
import ROUTER from '../../router'
import CONFIG from '../../config.js'
export default{
  mounted (){
    this.retrieve()
    console.log(this.listStyle)
  },
  data () {
    return {
      user: AUTH.user,
      data: null,
      templates: []
    }
  },
  props: ['category', 'listStyle'],
  components: {
    'dynamic-empty': require('components/increment/generic/empty/EmptyDynamicIcon.vue'),
    'generic-filter': require('components/increment/ecommerce/marketplace/Filter.vue'),
    'thumbnail': require('modules/editorv2/page/Thumbnail.vue')
  },
  methods: {
    redirect(parameter){
      if(parameter === '/editor/v2'){
        AUTH.mode = 1
      }
      ROUTER.push(parameter)
    },
    retrieve(){
      let parameter = {
        condition: [{
          value: this.user.userID,
          column: 'account_id',
          clause: '='
        }, {
          value: this.category,
          column: 'category',
          clause: '='
        }]
      }
      this.APIRequest('templates/retrieve', parameter).then(response => {
        if(response.data.length > 0){
          this.data = response.data
        }else{
          this.data = null
        }
        for(let i = 0; i < response.data.length; i++){
          this.templates.push({ ...this.data[i], contents: JSON.parse(this.data[i].contents) })
        }
        console.log(this.templates)
      })
    }
  }
}
</script>
