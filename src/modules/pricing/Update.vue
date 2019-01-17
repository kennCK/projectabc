<template>
  <div id="updatePricings">
    <div class="modal fade" id="updatePricingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" v-if="item !== null">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <h5 class="modal-title" id="exampleModalLabel">Update Price</h5>
            <button type="button" class="close" @click="close()" aria-label="Close">
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
              <label for="exampleInputEmail1">Product</label>
              <input type="text" class="form-control" placeholder="Type title here..." v-model="item.product.title" disabled>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Minimum # of Print</label>
              <input type="text" class="form-control" placeholder="Type minimum here..." v-model="item.minimum">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Maximum # of Print</label>
              <input type="text" class="form-control" placeholder="Type maximum here..." v-model="item.maximum">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Price</label>
              <input type="text" class="form-control" placeholder="PHP 0.00" v-model="item.price">
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger pull-left" @click="deleteItem()">Delete</button>
              <button type="button" class="btn btn-primary" @click="update()">Update</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.featured-image{
  width: 100%;
  float: left;
  height: 200px;
  margin-bottom: 10px;
}

.featured-image .options{
  width: 100%;
  float: left;
  text-align: center;
  height: 200px;
  border: solid 1px #ddd;
  overflow-y: hidden;
}
.options input{
  display: none;
}
.options:hover{
  cursor: pointer;
}
.options i{
  font-size: 40px;
  width: 100%;
  float: left;
  margin-top: 75px;
}

.options label{
  width: 100%;
  float: left;
}
.options img{
  width: 100%;
  float: left;
  height: auto;
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
  data(){
    return {
      user: AUTH.user,
      config: CONFIG,
      errorMessage: null,
      item: null
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    },
    update(){
      if(this.validate()){
        this.APIRequest('pricings/update', this.item).then(response => {
          if(response.data > 0){
            $('#updatePricingModal').modal('hide')
            this.$parent.retrieve()
          }
        })
      }
    },
    validate(){
      let i = this.item
      if(i.minimum !== null || i.minimum !== '' || i.maximum !== null || i.maximum !== '' || i.price !== null || i.price !== ''){
        return true
      }
      return false
    },
    close(){
      this.item = null
      $('#updatePricingModal').modal('hide')
    },
    modal(){
      $('#updatePricingModal').modal('show')
    },
    deleteItem(){
      if(this.item !== null){
        let parameter = {
          id: this.item.id
        }
        this.APIRequest('pricings/delete', this.item).then(response => {
          $('#updatePricingModal').modal('hide')
          this.$parent.retrieve()
        })
      }
    }
  }
}
</script>
