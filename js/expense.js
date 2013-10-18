$('document').ready(function() {    
    
    /** For datePicker **/
    var datePickerOpts = {
        createButton: false
    };
    
    var startDp = $('#expense_search_start_date').datePicker(datePickerOpts);
    var endDp = $('#expense_search_end_date').datePicker(datePickerOpts);
    var createdDp = $('#created_on').datePicker(datePickerOpts);
    $('#expense-search-start-date-btn').click(function(){ initDatePicker(startDp); });
    $('#expense-search-end-date-btn').click(function(){ initDatePicker(endDp); });
    $('#created-date-btn').click(function(){ initDatePicker(createdDp); });
    
    $('.expense-delete-btn').click(function(){
        if(confirm('Are you sure you want to delete this Expense?')) {
            //self.location = '/index.php/expense/delete/'+$(this).attr('rel');
            $.get('/index.php/expense/delete/'+$(this).attr('rel'), function(response){
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