<?php 
/** Includes **/
    echo script_tag('js/expense.js');
    echo script_tag('js/lib/datePicker/date.js');
    echo script_tag('js/lib/datePicker/jquery.datePicker.min.js');
    echo link_tag('js/lib/datePicker/datePicker.css');
    echo link_tag('css/datePicker.css');
?>
<div id="expense-create">
<?php echo form_open($formName) ?>    
    <div class="banner">
        <h2><?= $title ?></h2>            
    </div>
    <div id="expense-form">        
        <div class="error"><?php echo validation_errors(); ?></div>
            <div class="grid_1 alpha">
                <p>
                    <label for="purpose">Purpose:<span class="red">*</span></label>
                    <input type="text" id="purpose" name="purpose"
                           value="<?= set_value('purpose', $expense['purpose']) ?>"/>
                </p>
                <p>
                    <label for="amount">Amount:<span class="red">*</span></label>
                    <input type="text" id="amount" name="amount"
                           value="<?= set_value('amount', $expense['amount']) ?>"/>
                </p>
                <p>
                    <label for="created_on">Date:</label>   
                    <input type="text" id="created_on" name="created_on" class="dp-applied" 
                           placeholder="__ /__ /____" readonly="readonly"
                           value="<?= set_value('created_on', $expense['created_on']) ?>"/>
                    <span id="created-date-btn" class="cal-input"></span>
                </p>                                
                
            </div>
            <div class="grid_2 beta">
                <p>
                    <label for="bill_no">Bill No.:</label>
                    <input type="text" id="bill_no" name="bill_no"
                           value="<?= set_value('bill_no', $expense['bill_no']) ?>"/>
                </p>
                <p>
                    <label for="notes">Special Notes:</label>
                    <textarea id="notes" name="notes" rows="5"><?= set_value('notes', $expense['notes']) ?></textarea>
                </p>

            </div>        
        <div class="clear"></div>    
    </div>
    
    <div class="nextprev">
        <input type="submit" value="Save">
        <input type="button" onclick="window.location='/index.php/expense'" value="Cancel">
    </div>
</form>


</div>
