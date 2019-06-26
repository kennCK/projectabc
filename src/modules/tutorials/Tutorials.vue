<template>
  <div>
    <h1>Conditional</h1>
    <span v-if="flag === false">False</span>
    <span v-else>True</span>
    <h1>Inputs</h1>
    <h2>{{message}}</h2>
    <input type="text" class="form-control" placeholder="Type here..." v-model="message">
    <button class="btn btn-primary" style="margin-top: 10px;" v-on:click="save()">Save</button>
    <h1>Saved Message</h1>
    <h2>{{savedMessage}}</h2>
    <custom-input :message="message" @changeMessage="message = $event"></custom-input>
    <h1 class="text-primary">Add Names</h1>
    <div class="form-group">
      <input type="text" class="form-control col-lg-6" placeholder="First Name" v-model="firstName">
      <br>
      <input type="text" class="form-control col-lg-6" placeholder="Last Name" v-model="lastName">
      <button class="btn btn-primary" style="margin-top: 10px;" v-on:click="addName()">Save Name</button>
    </div>
    <custom-table :list="names" ></custom-table>
  </div>
</template>
<style scoped>
.form-control{
  height: 50px !important;
}
</style>
<script>
export default{
  data(){
    return{
      flag: true,
      message: null,
      savedMessage: null,
      firstName: null,
      lastName: null,
      names: [],
      activeIndex: null
    }
  },
  components: {
    'custom-input': require('modules/tutorials/Input.vue'),
    'custom-table': require('modules/tutorials/Table.vue')
  },
  methods: {
    save(){
      this.savedMessage = this.message
    },
    addName(){
      let object = {
        first_name: this.firstName,
        last_name: this.lastName
      }
      this.names.push(object)
      this.firstName = null
      this.lastName = null
    }
  }
}
</script>

