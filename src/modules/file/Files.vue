<template>
  <div class="files-wrapper">
    <button class="btn btn-primary pull-right" @click="redirect('/templates')"><i class="fa fa-plus"></i> Add Template</button>
    <generic-filter :category="category" @changeSortEvent="retrieve($event)"></generic-filter>
      <div class="container-files" v-if="categoryParameter === null">
       <ul v-for="(item, index) in folders" :key="index" class="folder">
        <li id="file-list" @click="redirect('/files/' + item.title, item.title)"><i id="file" class="fas fa-folder"></i> <span id="filename">{{item. title}}</span></li>
        </ul>
      </div>
    <div v-else class="container-files">
      <li><span @click="redirect('/files')">File Management </span><i class="fas fa-angle-right"></i> {{selectedFolder}}</li>
      <category-contents :category="categoryParameter"></category-contents>
    </div>
  </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.files-wrapper{
  width:100%;
  height: auto;
  float: left;
  margin-bottom: 15px;
}
.container-files{
  float: left;
  width: 100%;
}
li{
  list-style: none;
}
span{
  cursor: pointer;
}
ul{
  list-style: none;
  margin: 0px;
  padding: 0px;
}
ul li{
  height: 50px;
  line-height: 50px;
  padding-left: 10px;
}
ul li:hover{
  cursor: pointer;
  background: $secondary;
  color: white;
}
ul li i{
  font-size: 24px;
  color: $primary;
}
@media (max-width: 991px){
}
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
    this.retrieve({'title': 'asc'}, {value: null, column: 'title'})
    console.log(this.categoryParameter)
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      category: [{
        title: 'Personnal',
        sorting: [{
          title: 'Title ascending',
          payload: 'title',
          payload_value: 'asc'
        }, {
          title: 'Title descending',
          payload: 'title',
          payload_value: 'desc'
        }]
      }, {
        title: 'Customers',
        sorting: [{
          title: 'Title ascending',
          payload: 'title',
          payload_value: 'asc'
        }, {
          title: 'Title descending',
          payload: 'title',
          payload_value: 'desc'
        }, {
          title: 'Description ascending',
          payload: 'description',
          payload_value: 'asc'
        }, {
          title: 'Description descending',
          payload: 'description',
          payload_value: 'desc'
        }]
      }],
      folders: [{
        title: 'T-shirts'
      }, {
        title: 'Mugs'
      }, {
        title: 'I.Ds'
      }, {
        title: 'Cellphones'
      }, {
        title: 'Tarpaulin'
      }, {
        title: 'temp'
      }, {
        title: 'Temp2'
      }, {
        title: 'Temp3'
      }, {
        title: 'Temp4'
      }, {
        title: 'Temp5'
      }, {
        title: 'Temp6'
      }, {
        title: 'Temp7'
      }, {
        title: 'Temp8'
      }, {
        title: 'Temp9'
      }],
      selectedFolder: null,
      categoryParameter: this.$route.params.category ? this.$route.params.category : null
    }
  },
  components: {
    'dynamic-empty': require('components/increment/generic/empty/EmptyDynamicIcon.vue'),
    'category-contents': require('modules/file/Contents.vue'),
    'generic-filter': require('components/increment/ecommerce/marketplace/Filter.vue')
  },
  watch: {
    '$route.params.category': function(){
      if(this.$route.params.category){
        this.categoryParameter = this.$route.params.category
      }else{
        this.categoryParameter = null
      }
    }
  },
  methods: {
    redirect(parameter, folderName){
      this.selectedFolder = folderName
      ROUTER.push(parameter)
      if(parameter === 'editor/v2'){
        AUTH.mode = 1
      }
    },
    retrieve(sort){
      let parameter = {
        condition: [{
          value: 'saved',
          column: 'status',
          clause: '='
        }],
        sort: sort,
        account_id: this.user.userID
      }
      $('#loading').css({display: 'block'})
      this.APIRequest('products/retrieve', parameter).then(response => {
        $('#loading').css({display: 'none'})
        if(response.data.length > 0){
          this.data = response.data
        }
      })
    }
  }
}
</script>
