
function expandOverlay() {

    // create overlay and append to page
    var overlay = document.createElement("div");
    overlay.setAttribute("id","overlay");
    overlay.setAttribute("class", "overlay");
    document.body.appendChild(overlay);
    overlay.onclick=restore;

    var orsino = "<p> If music be the food of love, play on </p>"

    var text = document.createElement("text");
    text.setAttribute("id","text");
    text.innerHTML = orsino;
    text.setAttribute("class","overlaytext");
    document.body.appendChild(text);
}


function expandOverlay(title, article) {

    // create overlay and append to page
    var overlay = document.createElement("div");
    overlay.setAttribute("id","overlay");
    overlay.setAttribute("class", "overlay");
    document.body.appendChild(overlay);
    overlay.onclick=restore;

    var orsino = "<p> If music be the food of love, play on </p>"

    var text = document.createElement("text");
    text.setAttribute("id","text");
    text.innerHTML = orsino;
    text.setAttribute("class","overlaytext");
    document.body.appendChild(text);
}



// restore page to normal
function restore() {
 document.body.removeChild(document.getElementById("overlay"));
 document.body.removeChild(document.getElementById("text"));
}




function myFunction() {
   history.back()
//   alert("Hello! I am an alert box!");
}


function showUser(str) {
    if (str=="") {
      document.getElementById("txtHint").innerHTML="";
      return;
    } 
    if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
    }
    else { // code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET","getuser.php?q="+str,true);
    xmlhttp.send();
}
