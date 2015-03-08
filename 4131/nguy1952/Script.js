var current= {
  parent:undefined,
node:undefined};
var PICTURE = 3;
var bodyFlag = false;
var map = new Map();
var gMap;
function Map(){
  var _map = this;
  var client = new XMLHttpRequest();
  this.current = {name:"",node:undefined};
  // Load the json coordinates when window loads
  google.maps.event.addDomListener(window, 'load',loadJson);
  
  // Creates the google maps nodes
  this.createMapNode = function(name,coordinates){

    if(coordinates["mapNode"] != undefined){
      var mapNode = coordinates["mapNode"];
    }
    else{
    // Creating the options obj , center it on the location
    var latLng = new google.maps.LatLng(parseFloat(coordinates["lat"]),parseFloat(coordinates["long"]));
     var mapOptions = {
          center:latLng,
          zoom: 15
        };
        
        // Create the container
        var mapNode=  document.createElement("div");
        mapNode.id = "map_"+name;
        mapNode.className = "map";
        coordinates["mapNode"] = mapNode;
        
        // Create the map and set the marker on the restraunt pos.
        var gMap = new google.maps.Map(mapNode,
            mapOptions);
        coordinates["map"] = gMap;
        var marker = new google.maps.Marker({
            position: latLng,
            map: gMap,
            title: name
        });
        gMap.setZoom( gMap.getZoom() );
    }
        // Finally append on to the dom and make absolute
        mapNode.style.position = "absolute";
        $("#location_"+name).appendChild(mapNode);
        
        // Center and resize
        resize(coordinates["map"]);
  }
  
  
  function resize(gMap){
    var center = gMap.getCenter();
    google.maps.event.trigger(gMap, "resize");
    gMap.setCenter(center);
  };

  // AJAX Request to get lat,lng for each restarant, and place them in hashmap
  function loadJson(){
    console.log("json");
    client.open('GET', 'locations.txt');
    client.addEventListener("load", function(){
      _map.points = JSON.parse(client.responseText);
    }, false);
    client.send();
  };
  
  // Psuedo jquery
  function $(id){
    switch(id[0]){
      case "#":
        var tag = id.substr(1);
        return document.getElementById(tag);
      case ".":
        tag = id.substr(1);
        return document.getElementsByClassName(id);
      default:
        return document.getElementsByTagName(id);
    }
  }
}

Map.prototype.loadMap = function(name){
  if(this.current.name != name){
    this.deleteCurrent();
    this.createMapNode(name,map.points[name]);
    this.current.name = name;
    this.current.node = map.points[name]["mapNode"];
    console.log(this.current);
  }else{
    console.log("trying to delete");
    this.deleteCurrent();
  }
}

Map.prototype.deleteCurrent = function(){
  if(this.current.node !== undefined){
    $("location_"+this.current.name).removeChild(this.current.node);
      this.current.name = undefined;
      this.current.node = undefined;
  }
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