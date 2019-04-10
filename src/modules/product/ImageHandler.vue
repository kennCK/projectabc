<template>
  <label class="pull-right">
    <button class="btn btn-primary pull-right" @click="showImages()">
      Select
    </button>
    <browse-images-modal></browse-images-modal>
  </label>
</template>
<style scoped>
</style>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
import CONFIG from '../../config.js'
import axios from 'axios'
export default {
  mounted(){
    AUTH.checkPlan()
    this.retrieve()
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      newImage: {
        product_id: null,
        url: null,
        status: null
      }
    }
  },
  props: ['item', 'status'],
  components: {
    'browse-images-modal': require('modules/image/BrowseModal.vue')
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    createPhoto(url){
      if(this.status === 'featured'){
        this.newImage.status = 'featured'
        if(this.item.featured === null){
          this.newImage.product_id = this.item.id
          this.createRequest(this.newImage)
        }else{
          this.item.featured[0].url = url
          this.updateRequest(this.item.featured[0])
        }
      }else if(this.status === 'images'){
        this.newImage.status = 'others'
        this.newImage.product_id = this.item.id
        this.createRequest(this.newImage)
      }
    },
    createRequest(parameter){
      this.APIRequest('product_images/create', parameter).then(response => {
        this.$parent.retrieve()
        this.reset()
      })
    },
    updateRequest(parameter){
      this.APIRequest('product_images/update', parameter).then(response => {
        this.$parent.retrieve()
        this.reset()
      })
    },
    manageImageUrl(url){
      this.createPhoto(url)
      this.hideImages()
    },
    reset(){
      this.newImage = {
        product_id: null,
        status: null,
        url: null
      }
      this.hideImages()
    },
    showImages(){
      $('#browseImagesModal').modal('show')
    },
    hideImages(){
      $('#browseImagesModal').modal('hide')
    }
  }
}
</script>
