<template>
	<div class="page-container-holder" v-if="template.contents.content !== null" id="page-container-holder">
    <div class="page-holder" v-bind:id="'page'">
			
      <div class="page-container" :style="{height: template.contents.setting.zoom.height + template.contents.setting.units, width: template.contents.setting.zoom.width + template.contents.setting.units, background: template.contents.content.style.background}">
				
        <div v-bind:style="helper.style(layer.style, zoom, template.contents.setting, 0)" v-for="(layer, layerIndex) in template.contents.content.pages[0].layers" :key="layerIndex">
					<div v-bind:style="helper.style(object.style, zoom, template.contents.setting, 1)" class="object" v-bind:class="{'selected-object': objectIndex === layer.selected_object}" v-for="(object, objectIndex) in layer.objects" :key="objectIndex">
            

            <label v-bind:style="helper.style(object.style, zoom, template.contents.setting, 2)" v-if="object.type === 'text' && object.edit_flag === false">
              {{object.content}}
            </label>

            <!-- <textarea v-bind:style="helper.style(object.style, zoom, template.contents.setting, 2)" v-if="object.type === 'text' && object.edit_flag === true" v-model="object.content" class="input"></textarea> -->

            <img v-bind:style="helper.style(object.style, zoom, template.contents.setting, 2)" v-if="object.type === 'image'" :src="config.BACKEND_URL + object.content"/>

            <div v-bind:style="helper.style(object.style, zoom, template.contents.setting, 2)" v-if="notDiv.indexOf(object.type) < 0">
            </div>

          </div>
				</div>
			</div>
		</div>
	</div>
</template>
<style scoped lang="scss">
@import "~assets/style/colors.scss";
.page-container-holder{
	width: 100%;
	float: left;
	height: 100%;
  overflow-y: hidden;
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
	// cursor: move;
  position: relative;
  border: none !important;
}

.resize{
  position: absolute;
  background: white;
}

.resize-edge{
  position: absolute;
}

.resize-top-left{
  border: solid 1px #4285F4 !important;
  cursor: nw-resize;
}

.resize-top-right{
  border: solid 1px #4285F4 !important;
  cursor: ne-resize;
}

.resize-bottom-left{
  border: solid 1px #4285F4 !important;
  cursor: sw-resize;
}

.resize-bottom-right{
  border: solid 1px #4285F4 !important;
  cursor: se-resize;
}

.re-left{
  border-left: solid 1px #4285F4 !important;
  cursor: w-resize;
}

.re-top{
  border-top: solid 1px #4285F4 !important;
  cursor: s-resize;
}

.re-right{
  border-right: solid 1px #4285F4 !important;
  cursor: w-resize;
}

.re-bottom{
  border-bottom: solid 1px #4285F4 !important;
  cursor: s-resize;
}

.object:active {
  // cursor: move;
}
.selected-object{
	// border: solid 1px #4285F4 !important;
}

.input{
  border: none;
  background: transparent;
  resize: none;
  overflow-y: hidden;
}
</style>
<script>
import GLOBAL from 'src/modules/editorv2/global.js'
import HELPER from 'src/modules/editorv2/helper.js'
import CONFIG from 'src/config.js'

export default{
  mounted(){
    this.template.contents.setting.zoom.width = parseInt(this.template.contents.setting.page.width * (this.zoom / 100))
    this.template.contents.setting.zoom.height = parseInt(this.template.contents.setting.page.height * (this.zoom / 100))
  },
  data(){
    return {
      global: GLOBAL,
      config: CONFIG,
      posX: null,
      posY: null,
      notDiv: ['text', 'image'],
      position: {
        top: null,
        left: null,
        charTop: null,
        charLeft: null,
        width: null,
        height: null,
        resize: null
      },
      helper: HELPER,
      dragFlag: false
    }
  },
  props: ['template', 'zoom', 'width'],
  methods: {
  }
}
</script>
