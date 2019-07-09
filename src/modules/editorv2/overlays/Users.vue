<template>
  <div class="users-wrapper">
    <span class="user-item" v-for="(item, index) in users" :key="index">
      <span class="image" v-if="item.profile !== null">
        <img :src="config.BACKEND_URL + item.profile">
      </span>
      <span class="image" v-if="item.profile === null">
        <i class="fas fa-user-circle text-primary"></i>
      </span>
      <label class="title">
        <b>{{item.username}}</b>
      </label>
      <i class="fas fa-circle pull-right"  style="padding-right: 5px; line-height: 30px;" v-bind:class="{'text-primary': item.status === true}"></i>
    </span>
  </div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.users-wrapper{
  width: 100%;
  float: left;
  min-height: 50px;
  overflow-y: hidden;
}

.user-item{
  width: 100%;
  float: left;
  height: 30px;
  line-height: 30px;
}

.user-item:hover{
  cursor: pointer;
  color: $primary;
  border-bottom: solid 1px #ccc;
}

.user-item .title:hover{
  cursor: pointer;
}

.user-item .image{
  float: left;
}

.user-item .image img{
  width: 30px;
  height: 30px;
  border-radius: 50%;
  padding: 0px 5px;
}

.user-item .image i{
  font-size: 16px;
  float: left;
  line-height: 30px;
  padding: 0px 5px;
}

.user-item .title{
  float: left;
}

</style>
<script>
import CONFIG from 'src/config.js'
export default {
  data () {
    return{
      users: [{
        username: 'Kennette',
        profile: null,
        status: true
      }, {
        username: 'Kennette1',
        profile: null,
        status: true
      }, {
        username: 'Kennette3',
        profile: null,
        status: true
      }],
      config: CONFIG
    }
  }
}
</script>
