<template>
  <div>
    <div class="form-group">
      <label for="address">Variables</label><br/>
      <label class="text-danger" v-if="errorMessage !== null">{{errorMessage}}</label>
      <div class="input-group">
        <span class="input-group-addon" id="addon-1">Variable</span>
        <input type="text" class="form-control" placeholder="*driver_license" aria-describedby="addon-1" v-model="payload">
        <span class="input-group-addon" id="addon-1">Value</span>
        <input type="text" class="form-control" placeholder="Number" aria-describedby="addon-1" v-model="payloadValue">
        <button class="btn btn-primary" style="margin-left: 5px;" @click="addGovernmentVariables()">Add</button>
      </div>
    </div>
    <div class="govList-wrapper" v-if="data !== null">
      <div class="container">
        <div class="row govList-item" v-for="(item, index) in data.variables" :key="index" >
          <div class="col center-text">
            {{item.payload}}
          </div>
          <div class="col center-text">
            {{item.payload_value}}
          </div>
          <div class="col-auto">
            <button @click="deleteEntry(item.id)" type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
  .govList-wrapper {
    background: #f4f4f4;
    border-bottom: 1px #f2f2f2 solid;
    border-left: 1px #ccc solid;
    border-right: 1px #ccc solid;
    border-top: 1px #ccc solid;
    border-radius: 0.25em;
  }
  .govList-item {
    border-bottom: 1px #ccc solid;
    padding-top: 2%;
    padding-bottom: 2%;
  }
  .center-text {
    text-align: center;
    padding-top: 1%;
  }
</style>

<script>
export default {
  mounted(){
    this.initPayloadArray()
  },
  name: 'GovList',
  props: ['data'],
  data(){
    return {
      payload: null,
      payloadValue: null,
      errorMessage: null,
      payloadArray: []
    }
  },
  methods: {
    initPayloadArray(){
      this.payloadArray = []
      if(this.data !== null && this.data.variables !== null){
        for(let i = 0; i < this.data.variables.length; i++){
          this.payloadArray.push(this.data.variables[i].payload)
        }
      }
    },
    addGovernmentVariables(){
      if(this.validate()){
        this.errorMessage = null
        let temp = {
          profile_id: this.data.id,
          payload: this.payload,
          payload_value: this.payloadValue
        }
        this.APIRequest('profile_variables/create', temp).then(res => {
          this.retrieve()
        })
        this.data.variables.push(temp)
        this.payloadArray.push(this.payload)
        this.payload = null
        this.payloadValue = null
      }
    },
    deleteEntry(id){
      let parameter = {
        id: id
      }
      this.APIRequest('profile_variables/delete', parameter).then(res => {
        this.retrieve()
        this.initPayloadArray()
      })
    },
    validate(){
      if((this.payload === null || this.payload === '') || (this.payloadValue === null || this.payloadValue === '')){
        this.errorMessage = 'Please fill up all required fields.'
        return false
      }else if(this.payload === null){
        this.errorMessage = 'Pleasse fill up Variable field.'
        return false
      }else if(this.payloadValue === null){
        this.errorMessage = 'Please fill up Value filed'
        return false
      }else if(this.payloadArray.indexOf(this.payload) >= 0){
        this.errorMessage = 'Duplicate variable.'
        return false
      }
      return true
    },
    retrieve(){
      let parameter = {
        condition: [{
          value: this.data.id,
          column: 'profile_id',
          clause: '='
        }]
      }
      $('#loading').css({'display': 'block'})
      this.APIRequest('profile_variables/retrieve', parameter).then(response => {
        $('#loading').css({'display': 'none'})
        if(response.data.length > 0){
          this.data.variables = response.data
        }else{
          this.data.variables = null
        }
      })
    }
  }
}
</script>
