<template>
	<div class="body">
		<landing-banner></landing-banner>
    <landing-steps></landing-steps>
    <landing-bizmarketplace></landing-bizmarketplace>
    <landing-mc></landing-mc>
    <landing-features></landing-features>
	</div>
</template>
<script>
import ROUTER from '../../router'
import AUTH from '../../services/auth'
export default {
  components: {
    'landing-banner': require('modules/home/Landing/Banner.vue'),
    'landing-bizmarketplace': require('modules/home/Landing/BizMarketplace.vue'),
    'landing-steps': require('modules/home/Landing/Steps.vue'),
    'landing-features': require('modules/home/Landing/Features.vue'),
    'landing-mc': require('modules/home/Landing/MessageAndComment.vue')
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
