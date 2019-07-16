import Vue from 'vue'
import AUTH from 'src/services/auth'
export default {
  template: {
    contents: {
      content: null,
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
      prompts: null,
      optionFlag: true
    },
    title: null,
    edit_flag: false,
    status: 0,
    category: null,
    purchased: null
  },
  addPrompts(title, message, btn){
    this.template.contents.prompts = {
      title: title,
      message: message,
      btn: btn // yes and no object
    }
  },
  addTemplate(template){
    this.template = template
  },
  addPage(){
    let newPage = {
      style: this.template.contents.content.style,
      title: 'Page',
      eye: true,
      layers: [],
      selected_layer: null,
      edit_flag: false,
      locked: false
    }
    this.template.contents.content.pages.push(newPage)
    let active = this.template.contents.content.pages.length - 1
    this.template.contents.activePageIndex = active
    this.template.contents.content.selected_page = active
    this.addLayer()
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
    let activePageIndex = this.template.contents.activePageIndex
    this.template.contents.content.pages[activePageIndex].layers.push(layer)
    let length = this.template.contents.content.pages[activePageIndex].layers - 1
    this.template.contents.content.pages[activePageIndex].selected_layer = length
    this.template.contents.activeLayerIndex = length
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
    let activePageIndex = this.template.contents.activePageIndex
    let activeLayerIndex = this.template.contents.activeLayerIndex
    this.template.contents.content.pages[activePageIndex].layers[activeLayerIndex].objects.push(object)
  },
  zoomHandler(multiplier){
    this.zoom = multiplier
    if(this.template.contents.setting.page.width !== null && this.template.contents.setting.page.height !== null){
      this.template.contents.setting.zoom.width = parseInt(this.template.contents.setting.page.width * (multiplier / 100))
      this.template.contents.setting.zoom.height = parseInt(this.template.contents.setting.page.height * (multiplier / 100))
    }
  },
  save(){
    let vue = new Vue()
    let stringContents = JSON.stringify(this.template.contents)
    let parameter = {
      account_id: AUTH.user.userID,
      title: this.template.title,
      contents: '' + stringContents + '',
      status: this.template.status,
      purchased: this.template.purchased,
      category: this.template.category
    }
    vue.APIRequest('templates/create', parameter).then(response => {
      console.log(response)
    })
  },
  retrieve(condition){
    let parameter = {
      condition: condition
    }
    let vue = new Vue()
    vue.APIRequest('templates/retrieve', parameter).then(response => {
      if(response.data.length > 0){
        this.template = response.data[0]
      }
    })
  }
}
