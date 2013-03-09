
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


