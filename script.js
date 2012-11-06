function tally(){
    num_checked = $("input:checkbox:checked").length;
    alert(num_checked);
    $('#total_checked button').replaceWith(num_checked);
}

function entered_courses(title) {
    var entered = new Array();
    entered[] = title;
    return entered;
}

function redirect(url) {
    location.href = url;
}