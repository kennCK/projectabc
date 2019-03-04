<template>
  <div id="guideModal">
    <div class="modal fade" id="createGuideModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" v-if="item !== null">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Template Guide</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" class="text-white">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <span v-if="errorMessage !== null" class="text-danger text-center">
                <label><b>Opps! </b>{{errorMessage}}</label>
            </span>
            <br v-if="errorMessage !== null">
            <br>
            <div class="form-group">
              <label for="exampleInputEmail1">Guide</label>
              <textarea class="form-control" rows="20" v-model="text" v-if="item.guide === null"></textarea>
              <textarea class="form-control" rows="20" v-model="item.guide.text" v-if="item.guide !== null"></textarea>
            </div>

          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#createGuideModal">Cancel</button>
              <button type="button" class="btn btn-primary" @click="submit()" v-if="item.guide === null">Submit</button>
              <button type="button" class="btn btn-primary" @click="update()" v-if="item.guide !== null">Update</button>
          </div>
        </div>
      </div>
    </div>
  </div>
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
  },
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      text: null,
      item: null
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    submit(){
      if(this.validate()){
        let parameter = {
          account_id: this.user.userID,
          payload: 'template',
          payload_value: this.item.id,
          text: (this.item.guide) ? this.item.guide.text : this.text
        }
        this.APIRequest('guides/create', parameter).then(response => {
          if(response.data > 0){
            $('#createGuideModal').modal('hide')
            this.$parent.retrieve()
          }
        })
      }
    },
    validate(){
      if(this.guide !== null || this.guide !== ''){
        return true
      }
      return false
    },
    update(){
      if(this.validate()){
        let parameter = {
          id: this.item.guide.id,
          text: this.item.guide.text
        }
        this.APIRequest('guides/update', parameter).then(response => {
          if(response.data === true){
            $('#createGuideModal').modal('hide')
            this.$parent.retrieve(true)
          }
        })
      }
    }
  }
}
</script>
