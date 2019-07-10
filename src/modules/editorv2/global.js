export default {
  template: null,
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
    this.template.contents.pages[this.activePageIndex].layers.push(layer)
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
    this.template.contents.pages[this.activePageIndex].layers[this.activeLayerIndex].objects.push(object)
  }
}
