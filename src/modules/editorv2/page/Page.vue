<template>
	<div class="holder">
		<div class="page-holder" v-for="(item, index) in template.pages" :key="index">
			<div class="page-container" :style="item.style">
			</div>	
		</div>
	</div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.holder{
	width: 100%;
	float: left;
	height: 100%;
}

.page-holder{
	width: 100%;
	float: left;
	height: 100%;	
	display: flex;
	align-items: center;
}

.page-container{
	border: solid 1px $gray;
	margin-bottom: 20px;
	margin-left: auto;
	margin-right: auto;
}
</style>
<script>
export default{
  props: ['template']
}
</script>
