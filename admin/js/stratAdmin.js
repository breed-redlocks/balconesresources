$(document).ready(function(){
	// Add calendar to DatePicker
    $("#datepicker").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#datepicker2").datepicker({ dateFormat: 'yy-mm-dd' });
    
    // Generate Block fields
    $('#btnAddResearchTitle').click(function() {
                var num     = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
                var newNum  = new Number(num + 1);      // the numeric ID of the new input field being added
 
                // create the new element via clone(), and manipulate it's ID using newNum value
                var newElem = $('#input' + num).clone().attr('id', 'input' + newNum);
 
                // manipulate the block/id values of the input inside the new element
                newElem.children(':first').attr('id', 'researchTitle' + newNum).attr('name', 'researchTitle' + newNum );
 
                // insert the new element after the last "duplicatable" input field
                $('#input' + num).after(newElem);
 
                // enable the "remove" button
                $('#btnDel').attr('disabled','');
 
                // business rule: you can only add 5 names
                if (newNum == 15)
                    $('#btnAdd').attr('disabled','disabled');
            });
 
            $('#btnDelResearchTitle').click(function() {
                var num = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
                $('#input' + num).remove();     // remove the last element
 
                // enable the "add" button
                $('#btnAdd').attr('disabled','');
 
                // if only one element remains, disable the "remove" button
                if (num-1 == 1)
                    $('#btnDel').attr('disabled','disabled');
            });
 
            $('#btnDel').attr('disabled','disabled');
  });