document.addEventListener("DOMContentLoaded", function(event) { 
  var submit = document.getElementById("submit");
  var userRegex = /[^A-z0-9]+/g;
  var userError = {
      user:false,
      pass:false,
      node:document.getElementById("msg"),
      print:function(){
          if(!this.user && !this.pass){
              if(this.node.textContent.trim() !== ""){
                  this.node.className += " red";
                  return;
              }
              this.node.textContent = "Please Sign in";
              this.node.className = this.node.className.replace("red","");
              return;
          }
          var error = [];
          if(this.user)
            error.push("Username");
          if(this.pass)
            error.push("Password");
          if(error.length > 1){
            var end = " are invalid.";
          }
          else{
            end = " is invalid."
          }
          error = error.join(" and ") + end;
          
          this.node.textContent = error;
          this.node.className += " red";
      }
  }
  userError.print();
  
  submit.addEventListener("click",function(e){
     var user = getModel("user");
     var password = getModel("password");
     if(user.search(userRegex) >=0 || user.length <= 0){
        userError.user = true;
        e.preventDefault();    
     }else{
         userError.user = false;
     }
     if(password.length < 6)
     {
         userError.pass = true;
         e.preventDefault();
     }else{
         userError.pass = false;
     }
     userError.print();
  });
  
  function getModel(id){
      return document.getElementById(id).value;
  }
  
});