<?php 
/** Includes **/
    echo script_tag('js/wage.js');
    echo script_tag('js/lib/datePicker/date.js');
    echo script_tag('js/lib/datePicker/jquery.datePicker.min.js');
    echo link_tag('js/lib/datePicker/datePicker.css');
    echo link_tag('css/datePicker.css');
?>
<div id="wage-create">
<?php echo form_open($formName) ?>    
    <div class="banner">
        <h2><?= $title ?></h2>            
    </div>
    <div id="wage-form">        
        <div class="error"><?php echo validation_errors(); ?></div>
            <div class="grid_1 alpha">
                <p>
                    <label for="purpose">Staff:<span class="red">*</span></label>
                    <?php 
                        echo form_dropdown(
                            'staff', 
                            $staffs, 
                            (isset($_POST['staff']) ? $_POST['staff'] : $wage['staff']),
                            'id="staff-dropdown"'
                        );
                    ?>
                </p>
                <p>
                    <label for="amount">Amount:<span class="red">*</span></label>
                    <input type="text" id="amount" name="amount"
                           value="<?= set_value('amount', $wage['amount']) ?>"/>
                </p>
                <p>
                    <label for="created_on">Date:</label>   
                    <input type="text" id="created_on" name="created_on" class="dp-applied" 
                           placeholder="__ /__ /____" readonly="readonly"
                           value="<?= set_value('created_on', $wage['created_on']) ?>"/>
                    <span id="created-date-btn" class="cal-input"></span>
                </p>        
                <p>
                    <label for="description">Description:</label>
                    <input type="text" id="description" name="description"
                           value="<?= set_value('description', $wage['description']) ?>"/>
                </p>
                
            </div>      
        <div class="clear"></div>    
    </div>
    
    <div class="nextprev">
        <input type="submit" value="Save">
        <input type="button" onclick="window.location='/index.php/wage'" value="Cancel">
    </div>
</form>


</div>
