<template>
	<div class="holder">
		<div class="editor-layers">
			<ul>
				<li v-for="(item, index) in layerTabs" :key="index" v-bind:class="{'active': item === activeTab}" @click="activeTab = item">{{item}}</li>
			</ul>
			<div class="option-contents">
				<editor-layers v-if="activeTab === 'Layers'"></editor-layers>
				<editor-assets v-if="activeTab === 'Assets'"></editor-assets>
				<editor-pages v-if="activeTab === 'Pages'"></editor-pages>
			</div>
		</div>
		<div class="editor-body" v-bind:style="{'background': color}">
		</div>
		<div class="editor-settings">
			<ul>
				<li v-for="(item, index) in settings" :key="index" v-bind:class="{'active': item === activeSetting}" @click="activeSetting = item">{{item}}</li>
			</ul>
		</div>
	</div>
</template>
<style scoped lang="scss">
	@import "~assets/style/colors.scss";
	.holder{
		width: 100%;
		height: 100%;
	}
	.editor-layers{
		width: 12%;
		float: left;
		height: 100%;
	}
	ul{
		list-style: none;
		padding: 0px;
		margin: 0px;
		border-bottom: solid 1px $gray;
		border-right: solid 1px $gray;
		height: 40px;
	}
	ul li{
		width: 32%;
		float: left;
		height: 40px;
		margin-left: 1%;
		line-height: 40px;
		font-size: 11px;
		color: $gray;
		text-align: center;
	}

	ul li:hover{
		cursor: pointer;
		color: black;
	}
	.active{
		color: black;
	}

	.option-contents{
		width: 100%;
		float: left;
		height: calc(100% - 10px);
		border-right: solid 1px $gray;
	}
	.editor-body{
		width: 76%;
		float: left;
		height: 100%;
	}
	.editor-settings{
		width: 12%;
		float: left;
		height: 100%;
		border-left: solid 1px $gray;
	}
</style>
<script>
export default{
  data () {
    return {
      layerTabs: ['Pages', 'Layers', 'Assets'],
      settings: ['Settings'],
      activeTab: 'Layers',
      activeSetting: 'Settings'
    }
  },
  props: ['color'],
  components: {
    'editor-layers': require('modules/editorv2/layers/Layers.vue'),
    'editor-assets': require('modules/editorv2/layers/Assets.vue'),
    'editor-pages': require('modules/editorv2/layers/Pages.vue')
  },
  methods: {
    select(item) {
      this.$emit('add', item)
    }
  }
}
</script>

