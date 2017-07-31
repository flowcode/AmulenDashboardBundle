$(document).ready(function(){


  // $("#sortable-images").disableSelection();

  var step = 10;

  $(".slider-container > .slider-left").click(function () {
    $("#sortable-images").css({left: "+=" + step});
  });

  /* Image scroll speed */
  var speed = 30;

  /* Endless Scrolling Left */
  var mouseDownFlag = false;
  $(".slider-container > .slider-left").mousedown(function (event) {
    mouseDownFlag = true;
    endlessScrollingLeft();
  });
  $(".slider-container > .slider-left").mouseup(function (event) {
    mouseDownFlag = false;
  });
  var endlessScrollingLeft = function () {
    if (mouseDownFlag) {
      $("#sortable-images").css({left: "+=" + step});
      setTimeout(endlessScrollingLeft, speed);
    }
  }

  /* Endless Scrolling Right */
  var mouseUpFlag = false;
  $(".slider-container > .slider-right").mousedown(function (event) {
    mouseUpFlag = true;
    endlessScrollingRight();
  });
  $(".slider-container > .slider-right").mouseup(function (event) {
    mouseUpFlag = false;
  });
  var endlessScrollingRight = function () {
    if (mouseUpFlag) {
      $("#sortable-images").css({left: "-=" + step});
      setTimeout(endlessScrollingRight, speed);
    }
  }
  $(".slider-container > .slider-left").mousedown(function () {
    $("#sortable-images").css({left: "+=" + step});
  });
  $(".slider-container > .slider-right").click(function () {
    $("#sortable-images").css({left: "-=" + step});
  });


});