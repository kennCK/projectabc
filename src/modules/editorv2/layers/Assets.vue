<template>
  <div class="holder">
    <div class="filter">
      <i class="fa fa-search"></i>
      <input type="text" placeholder="Search" class="form-control">
    </div>
  </div>
</template>
<style scoped>
  .holder{
    width: 100%;
    float: left;
    min-height: 50px;
    overflow-y: hidden;
  }
  .filter{
    width: 100%;
    float: left;
    height: 40px;
    position: relative;
  }
  .filter i{
    position: absolute;
    top: 21%;
    z-index: 1;
    padding-left: 5px;
    font-size: 13px;
  }

  .filter .form-control{
    position: absolute;
    z-index: 0;
    font-size: 11px !important;
    padding-left: 20px;
    border: none;
  }
</style>
