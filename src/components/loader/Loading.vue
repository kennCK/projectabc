<template>
  <div>
    <div class="customModal" id="loading">
      <span class="loading">
        <i class="fas fa-circle-o-notch fa-spin"></i>
      </span>
    </div>
  </div>
</template>
<script>
</script>
<style scoped>
.customModal{
  position: fixed;
  background: rgb(254, 254, 254);
  background: rgba(254, 254, 254, 1);
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  width: 100%;
  z-index: 100000 !important;
  pointer-events: none;
  -webkit-transition: all 0.3s;
  -moz-transition: all 0.3s;
  transition: all 0.3s;
  text-align: center;
  display: none;
}
.customModal .loading{
  font-size: 50px;
  margin-top: 200px;
  height: 100px;
  float: left;
  width: 100%;
  text-align: center;
  color: #22b173;
  background: #fff;
  line-height: 100px;
  border-radius: 5px;
}
</style>
