# mapbox-simple

This Wordpress plugin provides integration Mapbox maps

## Installation

Install like any other Wordpress plugin

## Configuration

The plugin has a standard wordpress configuration panel, where you should input your MapBox API key.


## Usage example:

```
[mapbox_map layers="gfdrr.map-wv1c9ry4,gfdrr.kathmandu-health" latitude="27.6934" longitude="85.3380" zoom="11" max_zoom="14"]
```

### Options + example values:
- __layers__ (mandatory) comma separated list of layer ids to show
- __latitude__ and __longitude__ (mandatory) (`27.6934`) coordinates of where to initially center the map
- __zoom__ (`10`) default zoom level
- __min_zoom__ (`10`) minimum zoom level
- __max_zoom__ (`14`) maximum zoom level
- __scroll_wheel_zoom__ (`false`) zooming in/out using mouse scroll is allowed