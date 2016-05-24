jQuery(document).ready(function($){

    $('#selectall').click(function(event) {  //on click 
        if(this.checked) { // check select status
            $('.meta_entry').each(function() { //loop through each checkbox
                this.checked = true;                
            });
        }else{
            $('.meta_entry').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes                      
            });         
        }
    });
    
});