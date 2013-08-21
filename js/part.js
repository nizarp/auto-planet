$('document').ready(function() {    
       
    $('.part-delete-btn').click(function(){
        if(confirm('Are you sure you want to delete this Part?')) {
            self.location = '/index.php/part/delete/'+$(this).attr('rel');
        }
    });
    
    $('.edit_area').editable('/index.php/part/updatestock/', { 
         type      : 'text',
         indicator : 'Saving...',
         tooltip   : 'Click to edit...'
     });
    
});