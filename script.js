// this function returns the number of checkboxes 
// that are checked in a form
// pass in the name of the form as 'formname'
// pass in the name of the checkbox group as 'groupname'
 
function countCheckboxes(formname, groupname){
    var totalChecked = 0;
    var max = formname.ckbox.length;
 
    for (var idx = 0; idx < max; idx++) {
        if (eval("document." + formname + "." + groupname + "[" + idx + "].checked") == TRUE) {
        totalChecked+= 1;
        }
    }
    return totalChecked;
}
 