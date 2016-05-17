<html>


<head>
  <meta charset="utf-8">
  <style>
    #base {
	  width: 100%;
	  height: 100%;
      background: #AAA;
      overflow: auto;
    }
  </style>
</head>

<body>
<div id="base">

<div id="map"> 
<img id="map_background" src="resources/background.jpg" style="position:absolute; left:0; top:0; width:100%;"/>
</div>

</div>

<script>
var mapScale = 1;
var mapPosition = { x : 0, y: 0};
var mapElement = document.getElementById('map_background');

function subscribeOnWheel(elem, handler) {
  if (elem.addEventListener) {
    if ('onwheel' in document) {
      // IE9+, FF17+
      elem.addEventListener("wheel", handler);
    } else if ('onmousewheel' in document) {
      // устаревший вариант события
      elem.addEventListener("mousewheel", handler);
    } else {
      // 3.5 <= Firefox < 17, более старое событие DOMMouseScroll пропустим
      elem.addEventListener("MozMousePixelScroll", handler);
    }
  } else { // IE8-
    text.attachEvent("onmousewheel", handler);
  }
}

function subscribeOnMouseMove(elem, handler) {
  elem.addEventListener("mousemove", handler);
}

function subscribeOnMouseDown(elem, handler) {
  elem.onmousedown = handler;
}

function subscribeOnMouseUp(elem, handler) {
  elem.onmouseup = handler;
}

var baseElement = document.getElementById('base');

subscribeOnWheel(baseElement, function(e) {
  e = e || window.event;
  var delta = e.deltaY || e.detail || e.wheelDelta;
  
  delta = -0.4 *  Math.sign(delta);
  
  mapScale += delta;
  if (mapScale < 1) {
    mapScale = 1;
  }
  
  mapElement.style.transform = mapElement.style.WebkitTransform = mapElement.style.MsTransform = 'scale('+mapScale+')';
  
  e.preventDefault ? e.preventDefault() : (e.returnValue = false);
});

var isMouseDown = false;
subscribeOnMouseDown(baseElement, function(e) {  
  isMouseDown = true;
});

subscribeOnMouseUp(baseElement, function(e) {
  isMouseDown = false;
});

var mousePosition = {};
subscribeOnMouseMove(baseElement, function(e) {
  e = e || window.event;
  
  if (typeof(mousePosition.x) != 'undefined') {
    if (true == isMouseDown) {
      mapPosition.x -= (mousePosition.x - e.clientX);
      mapPosition.y -= (mousePosition.y - e.clientY);
      
      mapElement.style.top = mapPosition.y;
      mapElement.style.left = mapPosition.x;
    }
  }
  
  mousePosition = {
    x : e.clientX,
    y : e.clientY
  };
  
  e.preventDefault ? e.preventDefault() : (e.returnValue = false);
});

</script>

</body>
</html>

