$('document').ready(function() {    
    
    /** For datePicker **/
    var datePickerOpts = {
        createButton: false
    };
    
    var createdDp = $('#created_on').datePicker(datePickerOpts);
    $('#created-date-btn').click(function(){ initDatePicker(createdDp); });
    
    $('.wage-delete-btn').click(function(){
        if(confirm('Are you sure you want to delete this Wage?')) {
            self.location = '/index.php/wage/delete/'+$(this).attr('rel');
        }
    });
    
    initDatePicker = function(dpObj){
    	dpObj.dpDisplay();
        this.blur();
        return false;
    }
    
});