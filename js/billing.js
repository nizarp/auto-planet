$('document').ready(function() {
    
    $('.bill-delete-btn').click(function(){
        if(confirm('Are you sure you want to delete this Bill?')) {
            self.location = '/index.php/billing/delete/'+$(this).attr('rel');
        }
    });
    
    $('#create-bill-btn').click(function(){
        var jobsheet = $(this).parent().find('select').val();
        if(jobsheet == '') {
            $.prompt('Please select a Jobsheet');
        } else {
            self.location = '/index.php/billing/create/'+jobsheet;
        }
    });
    
});