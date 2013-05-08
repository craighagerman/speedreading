
var starttime = 0;
var cm = '';

function expandOverlay(article_id) {

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
   
   var json_object = {};
   xmlhttp.onreadystatechange=function()  {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)  {
         json_object = JSON.parse(xmlhttp.responseText);
         //document.getElementById("header").innerHTML = json_object.title;
         //document.getElementById("text").innerHTML = json_object.article;
         document.getElementById("srcontentblock").innerHTML = json_object.article;
         cm = json_object.courseid
      }
   }

   xmlhttp.open("GET","viewArticle.php?q="+article_id,true);
   xmlhttp.send();
   
   

   document.getElementById('start').style.visibility="hidden";
   document.getElementById('stop').style.visibility="visible";

   starttime = new Date().getTime();

    // create overlay and append to page
    /*
    var overlay = document.createElement("div");
    overlay.setAttribute("id","overlay");
    overlay.setAttribute("class", "overlay");
    document.body.appendChild(overlay);
    overlay.onclick=restore;
   */
    // added the article title
    /*
    var title = "Title";
    var h = document.createElement("H1");
    var t=document.createTextNode(title);
    h.setAttribute("id","header");
    h.setAttribute("class","overlayheader");
    h.appendChild(t);
    document.body.appendChild(h);
   */


    // add the article
    /*
    var mydiv = document.createElement("div");
    var content = document.createTextNode("Hi there and greetings!");
    mydiv.appendChild(content);
    mydiv.setAttribute("id","text2");    
    the_article = document.getElementById("text");
    //document.body.insertBefore(mydiv, the_article);
    document.body.appendChild(mydiv);
   */






    // add the article
    /*
    var article = "Article"
    var text = document.createElement("text");
    text.setAttribute("id","text");
    text.innerHTML = article;
    text.setAttribute("class","overlaytext");
    document.body.appendChild(text);
   */








   // add a stop button
   /*
    var button = document.createElement("div");
    button.setAttribute("id","divButton");
    button.setAttribute("class","redButton");
    
    var bt = document.createElement("P");
    bt.setAttribute("class","buttonText");
    bt.innerHTML = "Stop";    
    button.appendChild(bt);
    document.getElementById("text").appendChild(button);
    */
    //document.body.appendChild(button);
   

}





function getFinishTime() {
   finishtime = new Date().getTime();
   duration = (finishtime - starttime) / 1000.0;
   // reload the url of the current page:
   //    ~mod/speedreading/view.php?id=$coursemoduleid
   // the view.php page will detect the article has been viewed and display the questions
   // add the duration / time taken as a php parameter
   url = window.location.href + '&tt=' + duration;
   location.replace(url);
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




