$('document').ready(function() {    
       
    $('.staff-delete-btn').click(function(){
        if(confirm('Are you sure you want to delete this Staff?')) {
            self.location = '/index.php/staff/delete/'+$(this).attr('rel');
        }
    });
    
});