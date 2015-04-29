document.addEventListener("DOMContentLoaded", function(event) {
    
    var editNodes = document.getElementsByClassName("edit");
    var deleteNodes = document.getElementsByClassName("delete");
    var modNodes = document.getElementsByClassName("modButton");
    var cancelNodes = document.getElementsByClassName("cancel");
    var map = ["name","url","type","address","phone","ratings","hours"];
    var BUTTON = "btn-floating red accent-4 mod modButton";
    
    addListeners(modNodes,"click",function(e){
        var target = e.target;
        var parent = target.parentNode.parentNode.
                            parentNode.parentNode;
        var modifications =parent.getElementsByClassName("mod");
        var size = map.length;
        var data = {};
        for(var i=0; i<size; i++){
            data[map[i]] = modifications[i].value;
        }
        data["command"] = "edit";
        httpRequest(data);
    });
    
    addListeners(cancelNodes,"click",function(e){
        var target = e.target;
        var parent = target.parentNode.parentNode;
        editOff(parent);
    });
    
    addListeners(editNodes,"click",function(e){
        var target = e.target;
        var parent = target.parentNode.parentNode;
        editOn(parent);
    })
    
    addListeners(deleteNodes,"click",function(e){
        var target = e.target;
        var parent = target.parentNode.parentNode.parentNode.parentNode;
        var name = parent.getElementsByClassName("name")[0].textContent;
        console.log(name);
        httpRequest({command:"delete",name:name});
    })
        
    function addListeners(arr,event,fn){
        var length = arr.length
        for(var i=0; i<length; i++){
            arr[i].addEventListener(event,fn)
        }
    }
    
    function httpRequest(data){
        var xhr = new XMLHttpRequest();
        xhr.open('POST', "restaurants_controller.php", true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function (res) {
            console.log(res.target.responseText);
            window.location = "restaurants_controller.php"
        }
        var buffer = makePost(data);
        xhr.send(buffer);
    }
    function makePost(data){
        var buffer = "";
        for(var key in data){
            if(buffer !=""){
                buffer += "&";
            }
            buffer += key +"="+data[key].trim();
            console.log("key " + key);
            console.log(data[key]);
        }
        return buffer;
    }
    
    function editOn(parent){
        parent.getElementsByClassName("mod")[0].style.display = "inline";
        parent.getElementsByClassName("cancel")[0].style.display = "inline";
        parent.getElementsByClassName("edit")[0].style.display = "none";
        parent.getElementsByClassName("delete")[0].style.display = "none";
        inputOn(parent);
        
    }
    
    function editOff(parent){
        parent.getElementsByClassName("mod")[0].style.display = "none";
        parent.getElementsByClassName("cancel")[0].style.display = "none";
        parent.getElementsByClassName("edit")[0].style.display = "inline";
        parent.getElementsByClassName("delete")[0].style.display = "inline";
        inputOff(parent);
    }
    
    function inputOn(parent){
        var nextParent = parent.parentNode;
        var defaultNodes =nextParent.getElementsByClassName("default");
        var modNodes = nextParent.getElementsByClassName("mod");
        var size = defaultNodes.length;
        for(var i=0; i<size; i++){
            defaultNodes[i].style.display = "none";
        }
        size = modNodes.length;
        for(var i=0; i<size; i++){
            var node = modNodes[i];
            if(node.className === BUTTON){
                node.style.display = "inline";
            }else{
                node.style.display = "block";
            }
        }
    }
    
    function inputOff(parent){
        var nextParent = parent.parentNode.parentNode;
        var defaultNodes =nextParent.getElementsByClassName("default");
        var modNodes = nextParent.getElementsByClassName("mod");
        var size = defaultNodes.length;
        for(var i=0; i<size; i++){
            defaultNodes[i].style.display = "inline";
        }
        size = modNodes.length;
        for(var i=0; i<size; i++){
            modNodes[i].style.display = "none";
        }
    }
});

function resetDB(){
	var xhr = new XMLHttpRequest();
	xhr.open('GET', "resetDB.php", true);
	xhr.onload = function (res) {
		window.location = "restaurants_controller.php"
	}
	xhr.send();
}

function fillAddValid(){
    var form = $("#add_new").find("input");
    var size =form.length - 1;
    var values = {
        name:"restaurant",
        type:"type",
        url:"https://example.com",
        ratings:4,
        phone:"123-456-7890"
    }

    for (var i = 0; i <size; i++) {
        var input = $(form[i]);
        input.val(values[input[0].name]);
    }
    
    form = $("#add_new").find("textarea");
    size =form.length;
    values = {
        address:"123 fake street",
        hours:"M-F 10pm - 11PM"
    }

    for (var i = 0; i <size; i++) {
        input = $(form[i]);
        input.val(values[input[0].name]);
    }
    
}
