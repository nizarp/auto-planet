$('document').ready(function() {    
    
    /** For datePicker **/
    var datePickerOpts = {
        createButton: false
    };
    
    var promisedDp = $('#promised_date').datePicker(datePickerOpts);
    var createdDp = $('#created_on').datePicker(datePickerOpts);    
    $('#promised-date-btn').click(function(){ initDatePicker(promisedDp); });
    $('#created-date-btn').click(function(){ initDatePicker(createdDp); });
    
    $('.jobsheet-delete-btn').click(function(){
        if(confirm('Are you sure you want to delete this Jobsheet?')) {
            self.location = '/index.php/jobsheet/delete/'+$(this).attr('rel');
        }
    });

    $('.jobsheet-status').click(function () {
        previous = $(this).val();
    }).change(function(){
        if($(this).val() == 'reopen') {
            var password = prompt('Please enter Re-open Password');
            if(password != null) {
                if(hex_md5(password) == '5f4dcc3b5aa765d61d8327deb882cf99') {
                    changeStatus($(this).attr('rel'), $(this).val());
                } else {
                    $.prompt('Wrong Password!')
                    $(this).val(previous);
                }
            } else {
                $(this).val(previous);
            }
        } else {
            if($(this).val() == 'open') {
                $.prompt('You can not change a status to Open. Please use Reopen instead.');
                $(this).val(previous);
            } else {
                changeStatus($(this).attr('rel'), $(this).val());
            }
        }
    });
    
    changeStatus = function(id, status) 
    {
        var data = {'status' : status};        
        $.post('/index.php/jobsheet/update/'+id, {'data': data}, function(response){
            console.log(response);
        });
    }
    
    initDatePicker = function(dpObj){
    	dpObj.dpDisplay();
        this.blur();
        return false;
    }
    
    $('#addNewLabour').click(function(){
        var newCount = parseInt($('#count').val()) + 1;
        $(this).parent().append($('#labour_template').html().replace(/%count%/g, newCount));
        $('#count').val(newCount);
    });
    
    $('#addNewParts').click(function(){
        var newCount = parseInt($('#part_count').val()) + 1;
        $(this).parent().append($('#part_template').html().replace(/%count%/g, newCount));
        $('#part_count').val(newCount);
        
        $.each($('.combobox-'+newCount), function(){
            $(this).combobox();
        });
    });
    
});