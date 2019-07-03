<template>
  <div class="content-holder">
    <Sketch v-model="newColor" @input="pickColor()"></Sketch>
  </div>
</template>
<style lang="scss" scoped>
@import "~assets/style/colors.scss";
.content-holder{
  position: absolute;
  top: 45px;
  left: 40%;
  min-height: 50px;
  overflow-y: hidden;
  width: 225px;
}
</style>
<script>
import { Sketch } from 'vue-color'
export default{
  data () {
    return {
      newColor: '#ffffff'
    }
  },
  components: {
    Sketch
  },
  methods: {
    pickColor(){
      this.$emit('selectedColor', this.newColor.hex)
    }
  }
}
</script>
