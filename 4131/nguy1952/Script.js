var current= {
  parent:undefined,
node:undefined};
var PICTURE = 3;
var bodyFlag = false;
var map = new Map();
function Map(){
  var _map = this;
  var client = new XMLHttpRequest();
  google.maps.event.addDomListener(window, 'load',run);
  function createMapNode(name,coordinates){
    console.log("creating map node");
     var mapOptions = {
          center: { lat: parseFloat(coordinates["lat"]), lng: parseFloat(coordinates["long"])},
          zoom: 8
        };
        console.log(mapOptions);
        var mapNode=  document.createElement("div");
        mapNode.class =  "map";
        mapNode.id = "map_"+name;
        var map = new google.maps.Map(mapNode,
            mapOptions);
        coordinates["map"] = mapNode;
        console.log(coordinates);
        $("body")[0].appendChild(coordinates["map"]);
  }

  function run(fn) {
     loadJson(
     loadNodes);
  };
  
  function loadNodes(points) {
    console.log("load node");
    for(var shop in points) {
      //console.log(points[shop]);
      createMapNode(shop,points[shop]);
    }
    _map.points = points;
  }
  function loadJson(complete){
    console.log("load json");
    client.open('GET', 'locations.txt');
    client.addEventListener("load", function(){
      _map.points = JSON.parse(client.responseText);
      complete(_map.points);
    }, false);
    client.send();
  };
  function $(id){
    switch(id[0]){
      case "#":
        var tag = id.substr(1);
        return document.getElementById(tag);
      case ".":
      var tag = id.substr(1);
        return document.getElementsByClassName(id);
      default:
        return document.getElementsByTagName(id);
    }
  }
}

Map.prototype.showMap=function(name){
  
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


function str(data){
  return data.toString();
}