
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
         document.getElementById("srcontentblock").innerHTML = json_object.article;
         cm = json_object.courseid
      }
   }
   xmlhttp.open("GET","viewArticle.php?q="+article_id,true);
   xmlhttp.send();
   document.getElementById('start').style.visibility="hidden";
   document.getElementById('stop').style.visibility="visible";
   starttime = new Date().getTime();
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