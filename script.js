// this function returns the number of checkboxes 
// that are checked in a form
// pass in the name of the form as 'formname'
// pass in the name of the checkbox group as 'groupname'
 
FUNCTION countCheckboxes(formname, groupname){
   VAR totalChecked= 0;
   VAR max = formname.ckbox.length;
 
   FOR (VAR idx = 0; idx < max; idx++) {
      IF (EVAL("document." + formname + "." + groupname + "[" + idx + "].checked") == TRUE) {
      totalChecked+= 1;
   }
}
 
  RETURN totalChecked;
}
 