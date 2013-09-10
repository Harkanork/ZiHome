function showPopup(popup) {
$("#"+popup).before('<a href="javascript:hidePopup(\''+popup+'\')"><div id="grayBack"></div></a>');
var popupH = $("#"+popup).height();
var popupW = $("#"+popup).width();
$("#"+popup).css("margin-top", "-" + (popupH / 2 + 40) + "px");
$("#"+popup).css("margin-left", "-" + popupW / 2 + "px");
$("#grayBack").css('opacity', 0).fadeTo(300, 0.5, function () { $("#"+popup).fadeIn(500); });
}
function hidePopup(popup) {
$("#grayBack").fadeOut('fast', function () { $(this).remove() });
$("#"+popup).fadeOut('fast', function () { $(this).hide() });
}
function affichDiv(popup) {
var popupH = $("#"+popup).height();
var popupW = $("#"+popup).width();
$("#"+popup).fadeIn(500);
}
function masqueDiv(popup) {
$("#"+popup).fadeOut('fast', function () { $(this).hide() });
}

