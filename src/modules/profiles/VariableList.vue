<template>
  <div>
    <div class="form-group">
      <label for="address">Variables</label>
      <div class="input-group">
        <span class="input-group-addon" id="addon-1">Variable</span>
        <input type="text" class="form-control" placeholder="*driver_license" aria-describedby="addon-1" v-model="payload">
        <span class="input-group-addon" id="addon-1">Value</span>
        <input type="text" class="form-control" placeholder="Number" aria-describedby="addon-1" v-model="payloadValue">
        <button class="btn btn-primary" style="margin-left: 5px;" @click="addGovernmentVariables()">Add</button>
      </div>
    </div>
    <div class="govList-item" v-if="data.variables.length > 0">
      <div class="d-flex justify-content-between" v-for="(item, index) in data.variables" :key="index">
        <div>
          {{item.payload}} || {{item.payload_value}}
        </div>
        <div>
          <button @click="deleteEntry(index)" type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
  .margin-top {
    margin-top: 2%;
  }

    .govList-item {
    background: #f4f4f4;
    padding: 5px;
    border-bottom: 1px #ccc solid;
    border-left: 1px #ccc solid;
    border-right: 1px #ccc solid;
  }
</style>

<script>
export default {
  name: 'GovList',
  props: ['data'],
  data(){
    return {
      payload: null,
      payloadValue: null
    }
  },
  methods: {
    addGovernmentVariables(){
      // validation here
      let temp = {
        payload: this.payload,
        payload_value: this.payloadValue
      }
      this.data.variables.push(temp)
      // clear entry
      this.payload = null
      this.payloadValue = null
      console.log(this.data.variables)
    },
    deleteEntry(index){
      if(this.data.variables.length > 0){
        this.data.variables.splice(index)
      }
    }
  }
}
</script>
