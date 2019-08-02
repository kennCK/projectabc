<template>
  <div class="profile-wrapper">
    <div class="header">
      {{global.template.contents.overlay.description}}
      <i class="fa fa-phone pull-right" @click="auth.triggerAudioCall(2, global.template.contents.overlay.payload_value)"></i>
      <i class="fas fa-envelope pull-right"  @click="redirect('/messenger/' + global.template.contents.overlay.description)"></i>
    </div>
    <div class="gallery" v-if="data !== null">
      <div class="gallery-item" v-for="(template, index) in templates" :key="index" @click="redirect('/editor/v2/' + template.code)">
        <span class="template-title"><center>{{`${template.category}/${template.title}`}}</center></span>
        <thumbnail :template="template" :zoom="parseInt((335 / parseInt(template.contents.setting.page.width)) * 100) - 5"></thumbnail>
      </div>
    </div>
    <dynamic-empty v-else :title="'No Designs yet!'" :icon="'far fa-smile'" :iconColor="'text-primary'"></dynamic-empty>
  </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.template-title center{
  margin: 5px;
  padding-top: 5px;
  border-top: solid 1px $gray;
}
.profile-wrapper{
  width: 100%;
  float: left;
  height: 100%;
  overflow: hidden;
}

.header{
  width: 100%;
  float: left;
  height: 30px;
  line-height: 30px;
  padding: 0px 10px;
}

.header .fa-phone{
  text-align: center;
  height: 26px;
  width: 26px;
  border-radius: 50%;
  text-align: center;
  background: $primary;
  color: white;
  font-size: 14px;
  line-height: 26px;
  margin-top: 2px;
}

.header .fa-envelope{
  text-align: center;
  height: 26px;
  width: 26px;
  border-radius: 50%;
  text-align: center;
  background: $warning;
  color: white;
  font-size: 14px;
  line-height: 26px;
  margin-top: 2px;
}

.gallery{
  width: 100%;
  height: calc(100% - 30px);
  overflow-y: auto;
}

.gallery-item{
  width: 100%;
  height: 200px;
  overflow: hidden;
  // border-top: solid 1px $gray;
}
.gallery-item:hover{
  cursor: pointer;
}
</style>
<script>
import GLOBAL from 'src/modules/editorv2/global.js'
import ROUTER from 'src/router'
import AUTH from 'src/services/auth'
export default {
  mounted(){
    this.retrieve()
  },
  watch: {
    'global.template.contents.overlay.payload_value': function(){
      this.retrieve()
    }
  },
  data() {
    return {
      global: GLOBAL,
      data: null,
      auth: AUTH,
      templates: []
    }
  },
  components: {
    'dynamic-empty': require('components/increment/generic/empty/EmptyDynamicIcon.vue'),
    'thumbnail': require('modules/editorv2/page/Thumbnail.vue')
  },
  methods: {
    redirect(params){
      this.auth.mode = 0
      ROUTER.push(params)
    },
    retrieve(){
      this.templates = []
      let parameter = {
        condition: [{
          column: 'account_id',
          value: this.global.template.contents.overlay.payload_value,
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
      })
    }
  }
}
</script>
