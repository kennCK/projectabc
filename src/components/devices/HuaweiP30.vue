<template>
  <div class="phone-wrapper">
    <label class="speaker"></label>
    <div class="phone-body">
      <HtmlContent :content="content"></HtmlContent>
    </div>
    <label class="home-swipe">
      <font-awesome-icon icon="caret-left" class="icon"></font-awesome-icon>
      <font-awesome-icon icon="circle" class="icon"></font-awesome-icon>
      <font-awesome-icon icon="square" class="icon"></font-awesome-icon>
    </label>
  </div>
</template>
<style lang="scss" scoped>
@import "~@/styles/colors.scss";
.phone-wrapper{
  width: 100%;
  height: 100%;
  float: left;
  border-radius: 20px;
  background: black;
  position: relative;
}

.phone-body{
  width: 96%;
  height: 97%;
  margin: 2%;
  background:white;
  border-radius: 20px;
  padding-top: 25px;
}
.speaker{
  background: black;
  height: 25px;
  width: 10%;
  margin-left: 45%;
  position: absolute;
  border-bottom-left-radius: 25px;
  border-bottom-right-radius: 25px;
}
.home-swipe{
  height: 35px;
  width: 96%;
  margin-left: 2%;
  margin-right: 2%;
  bottom: 0px;
  background: white;
  border-top: solid 1px $hover;
  position: absolute;
  border-bottom-left-radius: 20px;
  border-bottom-right-radius: 20px;
  text-align: center;
}
.home-swipe .icon{
  font-size: 16px;
  width: 20%;
  margin-top: 10px;
}
</style>
<script>
import HtmlContent from '@/components/devices/Content.vue'
export default {
  props: ['content'],
  components: {
    HtmlContent
  }
}
</script>
