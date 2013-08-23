<?php 
/** Includes **/
?>
<div id="jobsheet-create">
    <div class="banner">
        <h2><?= $title ?></h2>            
    </div>
    <div id="jobsheet-form">
        <p><h3>Jobsheet Details:</h3></p>
            <div class="grid_1 alpha">
                <p>
                    <strong>Name:</strong>
                    <?= $jobsheet['name'] ?>
                </p>
                <p>
                    <strong>Contact:</strong>
                    <?= $jobsheet['contact'] ?>
                </p>
                <p>
                    <strong>Address:</strong>
                    <?= (!empty($jobsheet['address']) ? nl2br($jobsheet['address']) : 'None') ?>
                </p>
                <p>
                    <strong>Jobsheet Date:</strong>   
                    <?= date('M d, Y', strtotime($jobsheet['created_on'])) ?>
                </p>
                <p>
                    <strong>Promised Date:</strong>
                    <?= date('M d, Y', strtotime($jobsheet['promised_date'])) ?>                    
                </p>
                <p>
                    <strong>Estimated Amount:</strong>
                    <?= (($jobsheet['estimated_amount'] === 0) ? number_format($jobsheet['estimated_amount'], 2) : 'None') ?>                    
                </p>                
            </div>
            <div class="grid_2 beta">                
                <p>
                    <strong>Mileage:</strong>
                    <?= number_format($jobsheet['mileage'], 2) ?>
                </p>
                <p>
                    <strong>Reg No:</strong>
                    <?= $jobsheet['reg_no'] ?>
                </p>
                <p>
                    <strong>Chassis No:</strong>
                    <?= ((!empty($jobsheet['chassis_no'])) ? $jobsheet['chassis_no'] : 'None')?>
                </p>
                <p>
                    <strong>Engine No:</strong>
                    <?= ((!empty($jobsheet['chassis_no'])) ? $jobsheet['engine_no'] : 'None') ?>
                </p>
                <p>
                    <strong>Special Notes:</strong>
                    <?= ((!empty($jobsheet['notes'])) ? nl2br($jobsheet['notes']) : 'None' ) ?>
                </p>
            </div>        
        <div class="clear"></div>

    <div id="labour-details">
        <p>&nbsp;</p>
        <h3>Labour Details:</h3>
        <div height="5px;">&nbsp;</div>
        <?php if(isset($jobsheet['labour_charges'])) { ?>
            <?php $i = 1; ?>
            
            <div class="summary-sno"><strong>&nbsp;</strong></div> 
            <div class="summary-jobtype"><strong>Jot Type</strong></div>
            <div class="summary-staff"><strong>Staff</strong></div>
            <div class="summary-amount"><strong>Amount</strong></div>
            <div class="clear"></div>
        
            <?php foreach ($jobsheet['labour_charges'] as $labourCharge) { ?>                
                <p>
                    <div class="summary-sno"><?= $i ?>.</div> 
                    <div class="summary-jobtype"><?= $jobtypes[$labourCharge['job_type']] ?></div>
                    <div class="summary-staff"><?= $staffs[$labourCharge['staff']] ?></div>
                    <div class="summary-amount"><?= number_format($labourCharge['amount'], 2) ?></div>
                    <? $i++; ?>
                </p>
                <div class="clear"></div>
            <?php } ?>
        <?php } ?>
    </div>
    <div id="parts-details">
        <p>&nbsp;</p>
        <h3>Parts Used:</h3>
        <div height="5px;">&nbsp;</div>
        <?php if(isset($jobsheet['jobsheet_parts'])) { ?>
            <?php $i = 1; ?>
        
            <div class="summary-sno">&nbsp;</div> 
            <div class="summary-part"><strong>Item</strong></div>
            <div class="summary-amount"><strong>Quantity</strong></div>
            <div class="clear"></div>
            
            <?php foreach ($jobsheet['jobsheet_parts'] as $part) { ?>        
                 <p>
                    <div class="summary-sno"><?= $i ?>.</div> 
                    <div class="summary-part"><?= $parts[$part['part_id']] ?></div>
                    <div class="summary-amount"><?= $part['qty'] ?></div>
                    <? $i++; ?>
                </p>
                <div class="clear"></div>
            <?php } ?>
        <?php } ?>
    </div>
    
    </div>    
    <div class="nextprev">
        <input type="button" onclick="window.location='/index.php/jobsheet'" value="Back">
    </div>
</div>
