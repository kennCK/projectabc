<template>
  <div class="contents-wrapper"  v-if="data !== null">
    <div class="content-item" v-for="(item, index) in data" :key="index">
      {{item.title}}
    </div>
  </div>
  <dynamic-empty v-else :title="'No products yet!'" :action="'Please be back soon.'" :icon="'far fa-smile'" :iconColor="'text-primary'"></dynamic-empty>
</template>
<style scoped>
</style>
<script>
import AUTH from 'src/services/auth'
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
