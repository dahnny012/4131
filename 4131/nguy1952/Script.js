var current= {
  parent:undefined,
node:undefined};
var PICTURE = 3;
var bodyFlag = false;

function map(){
  var client = new XMLHttpRequest();
  function createMapNode(node,name,coordinates){
     var mapOptions = {
          center: { lat: coordinates.lat, lng: coordinates.lng},
          zoom: 8
        };
      
        var mapNode=  document.createElement("div");
        mapNode.class =  "map";
        mapNode.id = "map_"+name;
        var map = new google.maps.Map(mapNode,
            mapOptions);
        return mapNode;
  }

  this.mapNodes = (function() {
    client.open('GET', 'location.txt');
    client.onreadystatechange = function() {
    var points = JSON.parse(client.responseText);
    var nodes = {};
    for(var shop in points) {
      
        // get response createNode
          // Load into a buffer
      console.log(points[shop]);
    }
  };})();
}

map.prototype.showMap=function(name){
  
}

function showPicture(name){
  // deletes current
  // makes new pic
  if(name != current.parent){
    removeCurrent();
    bodyFlag = false;
    var path = "images/"+name+".jpg";
    console.log("button");
    var divNode = createImgNode(path,name);
    $(name).appendChild(divNode);
    current = {
      parent:name,
      node: divNode
    }
    addDivEvent();
  }else{
    // same button
      removeCurrent();
  }
}

// create the node we want
function createImgNode(src,alt){
  var div = document.createElement("div");
  div.className = "pictureWrapper";
  var img = new Image();
  img.src = src;
  img.className = "picture";
  if(alt != undefined)
    div.title = alt;
  div.appendChild(img);
  return div;
}


function $(id){
  return document.getElementById(id);
}

function removeDivEvent(){
  current.node.removeEventListener("click");
}

function addDivEvent(){
document.getElementsByTagName("div")[0]
    .addEventListener("click",function(){
        removeCurrent();
  });
}


function removeCurrent(){
  if(current.node !== undefined){
    removeDivEvent();
    $(current.parent).removeChild(current.node);
  }
  current= {
  parent:undefined,
node:undefined};
}