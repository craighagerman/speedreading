
function expandOverlay1() {

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


function expandOverlay(article_id) {

   var article = "<p>--</p>"

   if (article_id=="") {
      document.getElementById("text").innerHTML="";
      return;
   } 
   if (window.XMLHttpRequest) {  // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
   }
   else  {  // code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
   }
   
   xmlhttp.onreadystatechange=function()  {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)  {
         document.getElementById("text").innerHTML=xmlhttp.responseText;
      }
   }
   article = xmlhttp.responseText;
   xmlhttp.open("GET","viewArticle.php?q="+article_id,true);
   xmlhttp.send();


    // create overlay and append to page
    var overlay = document.createElement("div");
    overlay.setAttribute("id","overlay");
    overlay.setAttribute("class", "overlay");
    document.body.appendChild(overlay);
    overlay.onclick=restore;

    var h = document.createElement("H1");
    var t=document.createTextNode(article_id);
    h.setAttribute("id","header");
    h.setAttribute("class","overlayheader");
    h.appendChild(t);
    document.body.appendChild(h);

    

    var text = document.createElement("text");
    text.setAttribute("id","text");
    text.innerHTML = article;
    text.setAttribute("class","overlaytext");
    document.body.appendChild(text);

   


}



// restore page to normal
function restore() {
   document.body.removeChild(document.getElementById("overlay"));
   document.body.removeChild(document.getElementById("header"));
   document.body.removeChild(document.getElementById("text"));
}





function goBack() {
   history.back();
}

function showAlert() {
   alert("Hello! I am an alert box!");
}


function goToGoogle( ) {
   location.href = "http://news.google.ca";
}




