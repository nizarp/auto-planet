<?php 
/** Includes **/
    echo script_tag('js/jobsheet.js');
    echo script_tag('js/lib/datePicker/date.js');
    echo script_tag('js/lib/datePicker/jquery.datePicker.min.js');
    echo script_tag('js/lib/jquery-ui-1.10.3/js/jquery-ui-1.10.3.custom.min.js');
    echo script_tag('js/autocomplete.js');
    echo link_tag('js/lib/datePicker/datePicker.css');
    echo link_tag('css/datePicker.css');
    echo link_tag('js/lib/jquery-ui-1.10.3/css/smoothness/jquery-ui-1.10.3.custom.min.css');
?>
<div id="jobsheet-create">
<?php echo form_open($formName) ?>
    <div class="banner">
        <h2><?= $title ?></h2>            
    </div>
    <div id="jobsheet-form">        
        <div class="error"><?php echo validation_errors(); ?></div>
        <p><h3>Jobsheet Details:</h3></p>
            <div class="grid_1 alpha">
                <p>
                    <label for="name">Name:<span class="red">*</span></label>
                    <input type="text" id="name" name="name"
                           value="<?= set_value('name', $jobsheet['name']) ?>"/>
                </p>
                <p>
                    <label for="name">Contact:<span class="red">*</span></label>
                    <input type="text" id="contact" name="contact"
                           value="<?= set_value('contact', $jobsheet['contact']) ?>"/>
                </p>
                <p>
                    <label for="address">Address:</label>
                    <textarea id="address" name="address" rows="5"><?= set_value('address', $jobsheet['address']) ?></textarea>
                </p>
                <p>
                    <label for="created_on">Jobsheet Date:<span class="red">*</span></label>   
                    <input type="text" id="created_on" name="created_on" class="dp-applied" 
                           placeholder="__ /__ /____" readonly="readonly"
                           value="<?= set_value('created_on', $jobsheet['created_on']) ?>"/>
                    <span id="created-date-btn" class="cal-input"></span>
                </p>
                <p>
                    <label for="promised_date">Promised Date:<span class="red">*</span></label>
                    <input type="text" id="promised_date" name="promised_date" class="dp-applied" 
                           placeholder="__ /__ /____" readonly="readonly"
                           value="<?= set_value('promised_date', $jobsheet['promised_date']) ?>"/>
                    <span id="promised-date-btn" class="cal-input"></span>
                </p>
                <p>
                    <label for="estimated_amount">Estimated Amount:</label>
                    <input type="text" id="estimated_amount" name="estimated_amount"
                           value="<?= set_value('estimated_amount', $jobsheet['estimated_amount']) ?>"/>
                </p>                
            </div>
            <div class="grid_2 beta">                
                <p>
                    <label for="mileage">Mileage:<span class="red">*</span></label>
                    <input type="text" id="mileage" name="mileage"
                           value="<?= set_value('mileage', $jobsheet['mileage']) ?>"/>
                </p>
                <p>
                    <label for="reg_no">Reg No:<span class="red">*</span></label>
                    <input type="text" id="reg_no" name="reg_no"
                           value="<?= set_value('reg_no', $jobsheet['reg_no']) ?>"/>
                    <span class="small grey">(KL-10-A-1234)</span>
                </p>
                <p>
                    <label for="chassis_no">Chassis No:</label>
                    <input type="text" id="chassis_no" name="chassis_no"
                           value="<?= set_value('chassis_no', $jobsheet['chassis_no']) ?>"/>
                </p>
                <p>
                    <label for="engine_no">Engine No:</label>
                    <input type="text" id="engine_no" name="engine_no"
                           value="<?= set_value('engine_no', $jobsheet['engine_no']) ?>"/>
                </p>
                <p>
                    <label for="notes">Special Notes:</label>
                    <textarea id="notes" name="notes" rows="9"><?= set_value('notes', $jobsheet['notes']) ?></textarea>
                </p>
            </div>        
        <div class="clear"></div>

    <div id="labour-details">
        <p></p>
        <h3>Labour Details:</h3>
        <a id="addNewLabour">[Add New Labour]</a>
        <div height="5px;">&nbsp;</div>
        <input type="hidden" id="count" value="<?php 
        echo (isset($jobsheet['labour_charges'])) ? count($jobsheet['labour_charges']) : 0; ?>"/>
        <?php if(isset($jobsheet['labour_charges'])) { ?>
            <?php $i = 1; ?>
            <?php foreach ($jobsheet['labour_charges'] as $labourCharge) { ?>                
                <p>
                    <? 
                    echo form_dropdown(
                            "labour_charges[$i][job_type]",
                            $jobtypes,
                            $labourCharge['job_type']
                        );                                
                     
                    echo form_dropdown(
                            "labour_charges[$i][staff]",
                            $staffs,
                            $labourCharge['staff']
                        );            
                    
                    echo form_input(
                            "labour_charges[$i][amount]",
                            $labourCharge['amount'],
                            'placeholder="Amount"'
                        );
                    $i++;
                    ?>
                    <img onClick="$(this).parent().remove();" class="item-delete-btn" src="/css/images/x.gif">
                </p>
            <?php } ?>
        <?php } ?>
    </div>
    
    <div id="parts-details">
        <p></p>
        <h3>Parts Used:</h3>
        <a id="addNewParts">[Add New Parts]</a>
        <div height="5px;">&nbsp;</div>
        <input type="hidden" id="part_count" value="<?php 
        echo (isset($jobsheet['jobsheet_parts'])) ? count($jobsheet['jobsheet_parts']) : 0; ?>"/>
        <?php if(isset($jobsheet['jobsheet_parts'])) { ?>
            <?php $i = 1; ?>
            <?php foreach ($jobsheet['jobsheet_parts'] as $part) { ?>
                <div class="clear"></div>
                <p class="ui-widget">
                    <? 
                    echo form_dropdown(
                            "jobsheet_parts[$i][part_id]",
                            $parts,
                            $part['part_id'],
                            'class="combobox"'
                        );                    
                    echo form_input(
                            "jobsheet_parts[$i][qty]",
                            $part['qty'],
                            'placeholder="Quantity"'
                        );
                    $i++;
                    ?>
                    <img onClick="$(this).parent().remove();" class="item-delete-btn" src="/css/images/x.gif">
                </p>
                <div class="clear"></div>
            <?php } ?>
        <?php } ?>
    </div>
    
    </div>    
    <div class="nextprev">
        <input type="submit" value="Save">
        <input type="button" onclick="window.location='/index.php/jobsheet'" value="Cancel">
    </div>
</form>
</div>

<div id="labour_template" style="display:none;">
    <p>
        <? 
        echo form_dropdown(
                'labour_charges[%count%][job_type]',
                $jobtypes
            );                                

        echo form_dropdown(
                'labour_charges[%count%][staff]',
                $staffs
            );            

        echo form_input(
                'labour_charges[%count%][amount]',
                '',
                'placeholder="Amount"'
            );
        ?>
        <img class="item-delete-btn" onClick="$(this).parent().remove();" src="/css/images/x.gif">
    </p>
</div>
<div id="part_template" style="display:none;">
    <div class="clear"></div>
    <p class="ui-widget">        
        <? 
        echo form_dropdown(
                "jobsheet_parts[%count%][part_id]",
                $parts,
                '',
                'class="combobox-%count%"'
            );                    
        echo form_input(
                "jobsheet_parts[%count%][qty]",
                '',
                'placeholder="Quantity"'
            );
        ?>
        <img class="item-delete-btn" onClick="$(this).parent().remove();" src="/css/images/x.gif">
    </p>
    <div class="clear"></div>
</div>