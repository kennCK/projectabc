<template>
	<div class="holder" v-if="global.template.contents.content !== null">
		<div class="page-holder" v-for="(page, pageIndex) in global.template.contents.content.pages" :key="pageIndex">
			<div class="page-container" :style="{height: global.template.contents.setting.zoom.height + 'px', width: global.template.contents.setting.zoom.width + 'px'}">
				<div v-bind:style="layer.style" v-for="(layer, layerIndex) in page.layers" :key="layerIndex">
					<div v-bind:style="object.style" class="object" v-bind:class="{'selected-object': objectIndex === layer.selected_object}" v-for="(object, objectIndex) in layer.objects" :key="objectIndex" @click="selectObject(objectIndex, layer, object)" draggable="true" v-on:dragstart="moveObject($event, object)" v-on:dragend="drag($event, object)" v-on:drag="drag($event, object)">
            <!-- Resize edge -->
            <span class="resize resize-top-left" style="left: 0; top: 0;" v-if="objectIndex === layer.selected_object" @mouseover="position.resize = 'bottom-left'"></span>
            <span class="resize resize-top-right" style="right: 0; top: 0;" v-if="objectIndex === layer.selected_object" @mouseover="position.resize = 'top-right'"></span>
            <span class="resize resize-bottom-left" style="left: 0; bottom: 0;" v-if="objectIndex === layer.selected_object" @mouseover="position.resize = 'bottom-left'"></span>
            <span class="resize resize-bottom-right" style="right: 0; bottom: 0;" v-if="objectIndex === layer.selected_object" @mouseover="position.resize = 'bottom-right'"></span>
          </div>
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
  position: relative;
}

.resize{
  width: 10px;
  height: 10px;
  position: absolute;
}

.resize-top-left{
  border-bottom: solid 1px #4285F4 !important;
  border-right: solid 1px #4285F4 !important;
  cursor: nw-resize;
}

.resize-top-right{
  border-bottom: solid 1px #4285F4 !important;
  border-left: solid 1px #4285F4 !important;
  cursor: ne-resize;
}

.resize-bottom-left{
  border-right: solid 1px #4285F4 !important;
  border-top: solid 1px #4285F4 !important;
  cursor: sw-resize;
}

.resize-bottom-right{
  border-left: solid 1px #4285F4 !important;
  border-top: solid 1px #4285F4 !important;
  cursor: se-resize;
}

.object:active {
  cursor: move;
}
.selected-object{
	border: solid 1px #4285F4 !important;
}
</style>
<script>
import GLOBAL from 'src/modules/editorv2/global.js'
export default{
  data () {
    return {
      global: GLOBAL,
      posX: null,
      posY: null,
      position: {
        top: null,
        left: null,
        charTop: null,
        charLeft: null,
        width: null,
        height: null,
        resize: null
      }
    }
  },
  methods: {
    selectObject(index, layer, object){
      layer.selected_object = index
      this.clickFlag = true
      GLOBAL.template.contents.selectedTopMenu = 'Object'
      GLOBAL.template.contents.activeObjectIndex = index
      GLOBAL.template.contents.objectSettings = object.style
    },
    moveObject(event, object){
      this.posX = event.x
      this.posY = event.y
      this.position.top = object.style.top
      this.position.left = object.style.left
      if(String(this.position.top).indexOf('%') > -1){
        this.position.top = parseInt(this.position.top.substr(0, this.position.top.length - 1))
        this.position.charTop = '%'
      }
      if(String(this.position.top).indexOf('p') > -1){
        this.position.top = parseInt(this.position.top.substr(0, this.position.top.length - 2))
        this.position.charTop = 'px'
      }
      if(String(this.position.left).indexOf('%') > -1){
        this.position.left = parseInt(this.position.left.substr(0, this.position.left.length - 1))
        this.position.charLeft = '%'
      }
      if(String(this.position.left).indexOf('p') > -1){
        this.position.left = parseInt(this.position.left.substr(0, this.position.left.length - 2))
        this.position.charLeft = 'px'
      }
    },
    changePosition(x, y, object){
      this.position.top = parseInt(this.position.top)
      this.position.left = parseInt(this.position.left)
      object.style.top = (this.position.top + y) + 'px'
      object.style.left = (this.position.left + x) + 'px'
    },
    drag(event, object){
      let x = this.posX - event.x
      let y = this.posY - event.y
      this.changePosition(x * -1, y * -1, object)
    }
  }
}
</script>
