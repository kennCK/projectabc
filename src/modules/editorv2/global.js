import Vue from 'vue'
import AUTH from 'src/services/auth'
export default {
  template: {
    contents: null,
    title: null,
    edit_flag: false,
    status: 0,
    category: null,
    purchased: null,
    zoom: 100,
    setting: {
      page: {
        width: null,
        height: null
      },
      zoom: {
        width: null,
        height: null
      }
    },
    selectedTopMenu: null,
    activePageIndex: null,
    activeLayerIndex: null,
    activeObjectIndex: null,
    objectSettings: null,
    leftPane: {
      title: 'Pages',
      index: 2
    },
    overlay: {
      title: null,
      description: null,
      payload: null,
      payload_value: null
    },
    prompts: {
      title: null,
      message: null,
      btn: {
        yes: null,
        no: null
      }
    },
    optionFlag: true
  },
  addTemplate(template){
    this.template = template
  },
  addPage(){
    let newPage = {
      style: this.template.contents.style,
      title: 'Page',
      eye: true,
      layers: [],
      selected_layer: null,
      edit_flag: false,
      locked: false
    }
    this.template.contents.pages.push(newPage)
  },
  addLayer(){
    let layer = {
      title: 'Layer ',
      edit_flag: false,
      style: {
        background: 'transparent',
        height: '100%',
        width: '100%',
        top: '0',
        left: '0',
        borderRadius: '0px',
        position: 'absolute'
      },
      eye: true,
      show: false,
      objects: [],
      selected_object: null,
      locked: false
    }
    this.template.contents.pages[this.template.activePageIndex].layers.push(layer)
  },
  addObject(type){
    let object = {
      title: type,
      type: 'object',
      style: null,
      id: null,
      content: null,
      eye: true,
      edit_flag: false
    }
    if(type === 'Square'){
      object.style = {
        background: '#ffffff',
        height: '100px',
        width: '100px',
        top: '0',
        left: '0',
        borderRadius: '0px',
        position: 'absolute',
        border: 'solid 1px #ddd'
      }
    }else{
      //
    }
    this.template.contents.pages[this.template.activePageIndex].layers[this.template.activeLayerIndex].objects.push(object)
  },
  zoomHandler(multiplier){
    this.zoom = multiplier
    if(this.template.setting.page.width !== null && this.template.setting.page.height !== null){
      this.template.setting.zoom.width = parseInt(this.template.setting.page.width * (multiplier / 100))
      this.template.setting.zoom.height = parseInt(this.template.setting.page.height * (multiplier / 100))
    }
  },
  save(){
    let vue = new Vue()
    let contents = {
      contents: this.template.contents,
      setting: this.template.setting,
      zoom: this.template.zoom,
      selectedTopMenu: this.template.selectedTopMenu,
      activePageIndex: this.template.activePageIndex,
      activeLayerIndex: this.template.activeLayerIndex,
      activeObjectIndex: this.template.activeObjectIndex
    }
    let stringContents = JSON.stringify(contents)
    let parameter = {
      account_id: AUTH.user.userID,
      title: this.template.title,
      contents: '' + stringContents + '',
      status: this.template.status,
      purchased: null,
      category: this.template.category
    }
    vue.APIRequest('templates/create', parameter).then(response => {
      console.log(response)
    })
  }
}
