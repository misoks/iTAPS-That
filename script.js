function tally(){
    num_checked = $("input:checkbox:checked").length;
    alert(num_checked);
    $('#total_checked button').replaceWith(num_checked);
}

//Mapping table contents
function table_map(table_id) {
    var columns = $('#'+table_id+' thead th').map(function() {
        // This assumes that your headings are suitable to be used as
        //  JavaScript object keys. If the headings contain characters 
        //  that would be invalid, such as spaces or dashes, you should
        //  use a regex here to strip those characters out.
        return $(this).text();
    });
    
    var tableObject = $('#'+table_id+' tbody tr').map(function(i) {
        var row = {};
     
        // Find all of the table cells on this row.
        $(this).find('td').each(function(i) {
        // Determine the cell's column name by comparing its index
        //  within the row with the columns list we built previously.
        var rowName = columns[i];
        
        // Add a new property to the row object, using this cell's
        //  column name as the key and the cell's text as the value.
        row[rowName] = $(this).text();
      });
      
         alert(row['Course'] + ' - ' + row['Credits']);

        // Finally, return the row's object representation, to be included
        //  in the array that $.map() ultimately returns.
        return row;
     
        // Don't forget .get() to convert the jQuery set to a regular array.
    }).get();
    
    $.map() = [];
}