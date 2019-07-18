<template>
	<div class="holder">
		<div class="editor-layers">
			<ul>
        <li class="hidden text-center" v-if="contents.leftPane.index > 0">
          <i class="fas fa-chevron-left" @click="contents.leftPane.index--, makeActive(layerTabs[contents.leftPane.index])"></i>
        </li>
				<li class="shown" v-bind:class="{'active': layerTabs[contents.leftPane.index] === contents.leftPane.title}" @click="makeActive(layerTabs[contents.leftPane.index])">{{layerTabs[contents.leftPane.index]}}</li>
        <li class="shown" v-bind:class="{'active': layerTabs[contents.leftPane.index + 1] === contents.leftPane.title}" @click="makeActive(layerTabs[contents.leftPane.index + 1])">{{layerTabs[contents.leftPane.index + 1]}}</li>
        <li class="hidden text-center" v-bind:style="{width: (contents.leftPane.index === 0) ? '20%' : '10%'}" @click="contents.leftPane.index++, makeActive(layerTabs[contents.leftPane.index])" v-if="contents.leftPane.index < (layerTabs.length - 1)">
          <i class="fas fa-chevron-right"></i>
        </li>
			</ul>
			<div class="option-contents">
        <marketplace v-if="contents.leftPane.title === 'Marketplace'"></marketplace>
        <users v-if="contents.leftPane.title === 'Designers'"></users>
				<editor-layers v-if="contents.leftPane.title === 'Layers'"></editor-layers>
				<editor-assets v-if="contents.leftPane.title === 'Assets'"></editor-assets>
				<editor-pages v-if="contents.leftPane.title === 'Pages'"></editor-pages>
			</div>
		</div>
		<div class="editor-body">
			<page></page>
		</div>
		<div class="editor-settings">
      <draggable v-model="settings" ghost-class="ghost" @end="onEnd" style="width: 100%;">
        <transition-group type="transition" name="flip-list" style="width: 100%;">
          <span v-for="(item, index) in settings" :key="item.id" class="settings sortable"><b class="text-primary">{{item.title}}</b>
            <i class="fa fa-chevron-down pull-right" v-if="item.show === false" @click="item.show = true"></i>
            <i class="fa fa-chevron-up pull-right" v-if="item.show === true" @click="item.show = false"></i>
            <span class="option-holder" v-if="item.show === true">
              <settings-text v-if="item.title === 'Text'"></settings-text>
              <settings-color :position="{right: '13%', top: '0%'}" v-if="item.title === 'Color'"></settings-color>
              <settings-settings v-if="item.title === 'Settings'" :property="contents.objectSettings"></settings-settings>
              <settings-stroke v-if="item.title === 'Stroke'"></settings-stroke>
              <settings-shadow v-if="item.title === 'Shadow'"></settings-shadow>
            </span>
          </span>
        </transition-group>
      </draggable>
<!-- 			<ul>
				<li v-for="(item, index) in settings" :key="index"><b class="text-primary">{{item.title}}</b>
					<i class="fa fa-chevron-down pull-right" v-if="item.show === false" @click="item.show = true"></i>
					<i class="fa fa-chevron-up pull-right" v-if="item.show === true" @click="item.show = false"></i>
					<span class="option-holder" v-if="item.show === true">
						<settings-text v-if="item.title === 'Text'"></settings-text>
						<settings-color :position="{right: '13%', top: '0%'}" v-if="item.title === 'Color'"></settings-color>
						<settings-settings v-if="item.title === 'Settings'" :property="contents.objectSettings"></settings-settings>
						<settings-stroke v-if="item.title === 'Stroke'"></settings-stroke>
						<settings-shadow v-if="item.title === 'Shadow'"></settings-shadow>
					</span>
				</li>
			</ul> -->
		</div>
	</div>
</template>
<style scoped lang="scss">
	@import "~assets/style/colors.scss";
	.holder{
		width: 100%;
		height: 100%;
    position: absolute;
	}
	
	.editor-layers{
		width: 12%;
		float: left;
		height: 100%;
		position: fixed;
	}
	
	ul{
		list-style: none;
		padding: 0px;
		margin: 0px;
		border-right: solid 1px $gray;
		min-height: 40px;
		overflow-y: hidden;
	}
	
	.editor-layers ul{
		border-bottom: solid 1px $gray;
	}

	.editor-layers li{
		float: left;
		height: 40px;
		line-height: 40px;
		font-size: 11px;
		color: $gray;
		text-align: center;
    list-style: none;
    padding: 0px;
    margin: 0px;
    border-right: solid 1px $gray;
	}

  .editor-layers ul .shown{
    width: 40%;
  }

  .editor-layers ul .hidden{
    width: 10%;
  }

	ul li:hover{
		cursor: pointer;
		color: black;
	}
	
	.active{
		color: black !important;
	}

	.option-contents{
		width: 100%;
		float: left;
		height: calc(100% - 10px);
		border-right: solid 1px $gray;
	}
	
	.editor-body{
		width: 76%;
		left: 12%;
		height: 100%;
		overflow: auto;
		position: fixed;
	}

	.editor-settings{
		width: 12%;
		right: 0px;
		height: 100%;
		border-left: solid 1px $gray;
		position: fixed;
	}

	.editor-settings ul li{
		width: 100%;
		float: left;
		min-height: 30px;
		line-height: 30px;
		font-size: 11px;
		color: black;
		padding-left: 5px;
		border-bottom: solid 1px $gray;
		overflow-y: hidden;
	}

  .editor-settings .settings{
    width: 100%;
    float: left;
    min-height: 30px;
    line-height: 30px;
    font-size: 11px;
    color: black;
    padding-left: 5px;
    border-bottom: solid 1px $gray;
    overflow-y: hidden;
  }
	.pull-right{
		padding-right: 5px;
		line-height: 30px;
	}

  .sortable{
    width: 100%;
    cursor: move;
    margin-bottom: 10px;
    overflow-x: hidden;
  }

  .editor-viewer .sortable-drag{
    opacity: 0;
  }

  .flip-list-move{
    transition: transform 0.5s;
  }
</style>
<script>
import GLOBAL from 'src/modules/editorv2/global.js'
import draggable from 'vuedraggable'
export default{
  data () {
    return {
      layerTabs: ['Designers', 'Marketplace', 'Printing', 'Pages', 'Layers', 'Assets'],
      settings: [{
        title: 'Color',
        show: false,
        id: 1
      }, {
        title: 'Settings',
        show: true,
        id: 2
      }, {
        title: 'Shadow',
        show: false,
        id: 3
      }, {
        title: 'Stroke',
        show: false,
        id: 4
      }, {
        title: 'Text',
        show: false,
        id: 5
      }],
      selectedPage: null,
      global: GLOBAL,
      contents: GLOBAL.template.contents,
      oldIndex: '',
      newIndex: ''
    }
  },
  components: {
    'editor-layers': require('modules/editorv2/layers/Layers.vue'),
    'editor-assets': require('modules/editorv2/layers/Assets.vue'),
    'editor-pages': require('modules/editorv2/layers/Pages.vue'),
    'settings-settings': require('modules/editorv2/settings/Settings.vue'),
    'settings-shadow': require('modules/editorv2/settings/Shadow.vue'),
    'settings-text': require('modules/editorv2/settings/Text.vue'),
    'settings-stroke': require('modules/editorv2/settings/Stroke.vue'),
    'settings-color': require('modules/editorv2/colors/Picker.vue'),
    'page': require('modules/editorv2/page/Page.vue'),
    'users': require('modules/editorv2/layers/Users.vue'),
    'marketplace': require('modules/editorv2/layers/Marketplace.vue'),
    draggable
  },
  methods: {
    select(item) {
      this.$emit('add', item)
    },
    makeActive(item){
      this.contents.leftPane.title = item
      this.contents.selectedTopMenu = item
      this.contents.overlay.title = null
    },
    removeIndex(index){
      this.settings.splice(index, 1)
    },
    onEnd: function(event){
      this.oldIndex = event.oldIndex
      this.newIndex = event.newIndex
    }
  }
}
</script>

