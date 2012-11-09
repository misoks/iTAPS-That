$(document).ready(function () {
   $.localScroll();
}); 

$(function() {
    var fixadent = $("#report-menu"), pos = fixadent.offset();
    $(window).scroll(function() {
        if($(this).scrollTop() > (pos.top + 5)) { 
            fixadent.removeClass('absolute'); 
            fixadent.addClass('fixed'); 
        }
        else if($(this).scrollTop() <= pos.top && fixadent.hasClass('fixed')){ 
            fixadent.removeClass('fixed'); 
            fixadent.addClass('absolute'); 
        }
    })
});