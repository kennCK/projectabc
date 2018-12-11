<template>
	<div class="body">
		<landing-banner></landing-banner>
    <landing-steps></landing-steps>
    <landing-features></landing-features>
	</div>
</template>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
export default {
  components: {
    'landing-banner': require('modules/home/Landing/Banner.vue'),
    'landing-steps': require('modules/home/Landing/Steps.vue'),
    'landing-features': require('modules/home/Landing/Features.vue')
  },
  mounted(){
  },
  data(){
    return {
    }
  },
  methods: {
    redirect(parameter){
      ROUTER.push(parameter)
    }
  }
}
</script>
<style scoped>
.body{
	margin: 0px;
}
</style>
