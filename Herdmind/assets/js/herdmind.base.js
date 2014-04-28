(function(window, $, undefined) {

  var HeaderKeys = Object.keys(window.Header);

  var applyHeader = function() {
    var color = window.Header[HeaderKeys[headerI]];

    $himg = $("<div>").addClass("header-image").css({
      "background-image": "url("+HeaderKeys[headerI]+")"
    });

    if($(".header-image").length) {
      $(".header-image").animate({
        opacity: 0
      }, 300, "linear", function() {
        this.parentElement.removeChild(this);
      });
      $(".scroll-container .top-bar").animate({
        "background-color": color
      }, 300, "linear");
    } else {
      $(".scroll-container .top-bar").css({
        "background-color": color
      });
    }
    var ch = $(".header-canvas")[0];
    ch.insertBefore($himg[0], ch.children[0]);
  }

  var headerI = 0;
  applyHeader();

  var headerCh = $(".header-chevron");
  $(headerCh.get(0)).click(function() {
    headerI -= 1;
    if(headerI < 0) headerI = HeaderKeys.length - 1;
  applyHeader();
  });
  $(headerCh.get(1)).click(function() {
    headerI += 1;
    if(headerI >= HeaderKeys.length) headerI = 0;
    applyHeader();
  });
  //fix blub
  var $blub = $("nav .blub"), blubUl = $blub.find("ul")[0], $blubUl = $(blubUl);
  var blubWidth = 300 * blubUl.children.length;
  blubUl.style.width = blubWidth + "px";
  blubUl.style.display = "block";
  blubUl.style.marginLeft = "0px";

  if(blubUl.children.length > 3) {
    var $blubChev = $blub.find(".blub-chevron");
    $($blubChev.get(0)).click(function() {
      if(parseInt(blubUl.style.marginLeft) < 0) {
        var idx = Math.abs(parseInt(blubUl.style.marginLeft) + 300) / 300;
        var height = Math.max(Math.max($(blubUl.children[idx]).height(), $(blubUl.children[idx + 1]).height()), $(blubUl.children[idx + 1]).height());
        $blubUl.animate({
          "margin-left": 0 - idx * 300 + "px",
          "height": height
        }, 100, "linear");
      }
    });

    $($blubChev.get(1)).click(function() {
      if(parseInt(blubUl.style.marginLeft) > 0 - blubWidth + 900) {
        var idx = Math.abs(parseInt(blubUl.style.marginLeft) - 300) / 300;
        var height = Math.max(Math.max($(blubUl.children[idx]).height(), $(blubUl.children[idx + 1]).height()), $(blubUl.children[idx + 1]).height());
        $blubUl.animate({
          "margin-left": 0 - idx * 300 + "px",
          "height": height
        }, 100, "linear");
      }
    });
  }
})(window, jQuery);
