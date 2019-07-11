import Vue from 'vue'
import AUTH from 'src/services/auth'
export default {
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
  addTemplate(template){
    this.template = template
  },
  addPage(){
    let newPage = {
      style: this.contents.style,
      title: 'Page',
      eye: true,
      layers: [],
      selected_layer: null,
      edit_flag: false,
      locked: false
    }
    this.contents.pages.push(newPage)
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
    this.contents.pages[this.activePageIndex].layers.push(layer)
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
    this.contents.pages[this.activePageIndex].layers[this.activeLayerIndex].objects.push(object)
  },
  zoomHandler(multiplier){
    this.zoom = multiplier
    if(this.setting.page.width !== null && this.setting.page.height !== null){
      this.setting.zoom.width = parseInt(this.setting.page.width * (multiplier / 100))
      this.setting.zoom.height = parseInt(this.setting.page.height * (multiplier / 100))
    }
  },
  save(){
    let vue = new Vue()
    let contents = {
      contents: this.contents,
      setting: this.setting,
      zoom: this.zoom,
      selectedTopMenu: this.selectedTopMenu,
      activePageIndex: this.activePageIndex,
      activeLayerIndex: this.activeLayerIndex,
      activeObjectIndex: this.activeObjectIndex
    }
    let stringContents = JSON.stringify(contents)
    let parameter = {
      account_id: AUTH.user.userID,
      title: this.title,
      contents: '' + stringContents + '',
      status: this.status,
      purchased: null,
      category: this.category
    }
    vue.APIRequest('templates/create', parameter).then(response => {
      console.log(response)
    })
  }
}
