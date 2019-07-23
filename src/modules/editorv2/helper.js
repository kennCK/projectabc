export default {
  style (style, zoom, setting) {
    // get height
    // get width
    // get position top / left
    // get border radius
    // get border
    // get the ratio of pageSize
    // return the style
    let tempStyle = style
    zoom = parseInt(zoom)
    tempStyle.height = parseInt(parseInt(style.height) * (zoom / 100)) + setting.units
    tempStyle.width = parseInt(parseInt(style.width) * (zoom / 100)) + setting.units
    tempStyle.top = parseInt(parseInt(style.top) * (zoom / 100)) + setting.units
    tempStyle.left = parseInt(parseInt(style.left) * (zoom / 100)) + setting.units
    tempStyle.borderRadius = parseInt(parseInt(style.borderRadius) * (zoom / 100)) + setting.units
    return tempStyle
  }
}
