var current= {
  parent:undefined,
node:undefined};
var PICTURE = 3;
var bodyFlag = false;


// No longer using
function removeEvent(node){
  node.removeEventListener()
}

function addDivEvent(){
document.getElementsByTagName("div")[0]
    .addEventListener("click",function(){
        removeCurrent();
  });
}

function removeDivEvent(){
  current.node.removeEventListener("click");
}

function $(id){
  return document.getElementById(id);
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
