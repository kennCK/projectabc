<template>
  <div class="menu-holder">
    <ul>
      <li v-for="(item, index) in menus" :key="index" @click="select(item)">{{item}}</li>
    </ul>
  </div>
</template>
<style scoped>

</style>
<script>
export default{
  data () {
    return {
      menus: ['Templates', 'Image', 'Object']
    }
  },
  methods: {
    select(item) {
      this.$emit('add', item)
    }
  }
}
</script>