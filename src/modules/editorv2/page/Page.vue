<template>
	<div class="holder" v-if="global.template.contents.content !== null">
		<div class="page-holder" v-for="(page, pageIndex) in global.template.contents.content.pages" :key="pageIndex">
			<div class="page-container" :style="{height: global.template.contents.setting.zoom.height + 'px', width: global.template.contents.setting.zoom.width + 'px'}">
				<div v-bind:style="layer.style" v-for="(layer, layerIndex) in page.layers" :key="layerIndex">
					<div v-bind:style="object.style" class="object" v-bind:class="{'selected-object': objectIndex === layer.selected_object}" v-for="(object, objectIndex) in layer.objects" :key="objectIndex" @click="selectObject(objectIndex, layer, object)"></div>
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

.object{
	cursor: move;
}

.selected-object{
	border: solid 1px black !important;
}
</style>
<script>
import GLOBAL from 'src/modules/editorv2/global.js'
export default{
  data () {
    return {
      global: GLOBAL
    }
  },
  methods: {
    selectObject(index, layer, object){
      layer.selected_object = index
      this.clickFlag = true
      GLOBAL.template.contents.selectedTopMenu = 'Object'
      GLOBAL.template.contents.activeObjectIndex = index
      GLOBAL.template.contents.objectSettings = object.style
    }
  }
}
</script>
