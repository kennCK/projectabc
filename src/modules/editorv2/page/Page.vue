<template>
	<div class="holder">
		<div class="page-holder" v-for="(page, pageIndex) in template.contents.pages" :key="pageIndex">
			<div class="page-container" :style="page.style">
				<div v-bind:style="layer.style" v-for="(layer, layerIndex) in page.layers" :key="layerIndex">
					<div v-bind:style="object.style" v-for="(object, objectIndex) in layer.objects" :key="objectIndex"></div>
				</div>
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
	position: relative;
}
</style>
<script>
export default{
  props: ['template']
}
</script>
