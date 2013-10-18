$('document').ready(function() {
    
    $('.bill-delete-btn').click(function(){
        if(confirm('Are you sure you want to delete this Bill?')) {
            //self.location = '/index.php/billing/delete/'+$(this).attr('rel');
            $.get('/index.php/billing/delete/'+$(this).attr('rel'), function(response){
                if(response) {
                    location.reload();
                } else {
                    alert('Could not delete record!');
                }
            });
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
    
    $('#round_off').keyup(function(){
        if(!isNaN($(this).val())) {
            $(this).removeAttr('style');
            var labourTotal = parseFloat($('#labour_total').val());
            var partsTotal = parseFloat($('#parts_total').val());
            var roundOff = ($(this).val() != '') ? parseFloat($(this).val()) : 0;
            console.log($('#grand_total').text());
            $('#grand_total_span').text(formatNumber(Math.floor(labourTotal + partsTotal - roundOff)));
            $('#grand_total').val(Math.floor(labourTotal + partsTotal - roundOff));
            
        } else {
            $(this).css('border-color', 'red');
        }
        
    });
    
    $('#round_off').trigger('keyup');
    
});

function formatNumber(n) {
    if(n=='0') return '0';
    return n.toString().replace(/^0/,'').replace(/,/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}