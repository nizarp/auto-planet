$('document').ready(function() {    
    
    /** For datePicker **/
    var datePickerOpts = {
        createButton: false
    };
    
    var createdDp = $('#created_on').datePicker(datePickerOpts);
    $('#created-date-btn').click(function(){ initDatePicker(createdDp); });
    
    $('.wage-delete-btn').click(function(){
        if(confirm('Are you sure you want to delete this Wage?')) {
            $.get('/index.php/wage/delete/'+$(this).attr('rel'), function(response){
                if(response) {
                    location.reload();
                } else {
                    alert('Could not delete record!');
                }
            });
        }
    });
    
    initDatePicker = function(dpObj){
    	dpObj.dpDisplay();
        this.blur();
        return false;
    }
    
});