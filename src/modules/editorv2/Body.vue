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
				<li v-for="(item, index) in settings" :key="index">{{item.title}}
					<i class="fa fa-chevron-down pull-right" v-if="item.show === false" @click="item.show = true"></i>
					<i class="fa fa-chevron-up pull-right" v-if="item.show === true" @click="item.show = false"></i>
					<span class="option-holder" v-if="">
					</span>
				</li>
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
		border-right: solid 1px $gray;
		min-height: 40px;
		overflow-y: hidden;
	}
	
	.editor-layers ul{
		border-bottom: solid 1px $gray;
	}

	.editor-layers ul li{
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
		float: left;
		height: 100%;
	}

	.editor-settings{
		width: 12%;
		float: left;
		height: 100%;
		border-left: solid 1px $gray;
	}

	.editor-settings ul li{
		width: 100%;
		float: left;
		height: 30px;
		line-height: 30px;
		font-size: 11px;
		color: black;
		padding-left: 5px;
		border-bottom: solid 1px $gray;
	}
	.pull-right{
		padding-right: 5px;
		line-height: 30px;
	}

</style>
<script>
export default{
  data () {
    return {
      layerTabs: ['Pages', 'Layers', 'Assets'],
      activeTab: 'Layers',
      settings: [{
        title: 'Settings',
        show: true
      }, {
        title: 'Text',
        show: true
      }, {
        title: 'Color',
        show: true
      }]
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

