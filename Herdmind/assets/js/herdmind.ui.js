//ALL of this is taken over by jQuery.
//This is first-chance DOM colorising.
//This is loaded before jQuery and processed without the jQuery helpers for two reasons
//1. The delay between when jQuery is loaded and it's actually done parsing can be noticed
//2. if jQuery breaks, this will always work
(function(window, Header) {
  if("querySelectorAll" in document || "getElementsByClassName" in document) {
    var helper = function(query) {
      if("querySelectorAll" in document) {
        return document.querySelectorAll(query);
      } else {
        return document.getElementsByClassName(query);
      }
    }

    var postpins = helper(".postpin");
    for(var index = 0; index < postpins.length; ++index) {
      var postpin = postpins[index];
      if("dataset" in postpin) {
        color = postpin.dataset.color;
      } else {
        color = postpin.getAttribute("data-color");
      }

      color = color || "#333";

      postpin.children[0].style.borderColor = //>
      postpin.children[1].style.borderColor = //>
      postpin.children[0].style.background = color;

      delete color;
      delete postpin;
    }

    delete postpins;

    var HeaderKey = Object.keys(window.Header)[0];
    var color = window.Header[HeaderKey];

    var himg = document.createElement("div");
    himg.className = "header-image";
    himg.style.backgroundImage = "url("+HeaderKey+")";

    helper(".header-canvas")[0].appendChild(himg);
    helper(".top-bar")[0].style.backgroundColor = color;

    delete color;
    delete HeaderKey;
    delete himg;

    var blubUl = helper(".blub")[0].getElementsByTagName("ul")[0];
    var blubWidth = 300 * blubUl.children.length;
    blubUl.style.width = blubWidth + "px";
    blubUl.style.display = "block";
    blubUl.style.marginLeft = "0px";

    delete blubUl;
    delete blubWidth;
    delete helper;
  } else {
    window.JQUERY_STEPIN = true;
    return;
  }

})(window, window.Header);

