$('document').ready(function() {    
    
    /** For datePicker **/
    var datePickerOpts = {
        createButton: false
    };
    
    var promisedDp = $('#expense_search_date').datePicker(datePickerOpts);
    var createdDp = $('#created_on').datePicker(datePickerOpts);
    $('#expense-search-date-btn').click(function(){ initDatePicker(promisedDp); });
    $('#created-date-btn').click(function(){ initDatePicker(createdDp); });
    
    $('.expense-delete-btn').click(function(){
        if(confirm('Are you sure you want to delete this Expense?')) {
            self.location = '/index.php/expense/delete/'+$(this).attr('rel');
        }
    });
    
    initDatePicker = function(dpObj){
    	dpObj.dpDisplay();
        this.blur();
        return false;
    }
    
});