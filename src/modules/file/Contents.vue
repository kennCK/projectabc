<template>
  <div class="contents-wrapper"  v-if="data !== null">
    <div class="content-item" v-for="(item, index) in data" :key="index">
      <div class="item-content">
      </div>
      <div class="item-title">
        {{item.title}}
      </div>
    </div>
  </div>
  <dynamic-empty v-else :title="'No products yet!'" :action="'Please add new designs.'" :icon="'far fa-smile'" :iconColor="'text-primary'"></dynamic-empty>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
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
  margin-right: 10px;
}
.item-title{ 
  float: left;
  text-align: center;
  color: $primary;
  width: 100%;
  height: 50px;
  line-height: 50px;
}
.item-content{
  float: left;
  position: relative;
  width: 100%;
  height: 200px;
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
    margin-left: 15%;
    margin-bottom: 10px;
}
  .item-title{ 
    float: left;
    text-align: center;
    color: $primary;
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
  },
  data () {
    return {
      user: AUTH.user,
      data: null
    }
  },
  props: ['category'],
  components: {
    'dynamic-empty': require('components/increment/generic/empty/EmptyDynamicIcon.vue')
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
      if(parameter === '/editor/v2'){
        AUTH.mode = 1
      }
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
      })
    }
  }
}
</script>
