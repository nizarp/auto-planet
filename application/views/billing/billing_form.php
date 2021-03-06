<?php 
/** Includes **/
    echo script_tag('js/billing.js');
    echo script_tag('js/lib/datePicker/date.js');
    echo script_tag('js/lib/datePicker/jquery.datePicker.min.js');
    echo link_tag('js/lib/datePicker/datePicker.css');
    echo link_tag('css/datePicker.css');
?>
<div id="billing-create">
<?php echo form_open($formName) ?>    
    <div class="banner">
        <h2><?= $title ?></h2>            
    </div>
    <?php echo form_hidden('jobsheet_id', $jobsheet['id']) ?>
    <div id="billing-form">        
        <div class="error"><?php echo validation_errors(); ?></div>
        <div id="section-to-print">
            <div id="print_head">Auto Planet - Bill</div>
            <p><h3>Jobsheet Details:</h3></p>
            <div id="bill-details">        
            <div class="grid_1 alpha">
                <p>
                    <label>Jobsheet No.:</label>
                    <?= $jobsheet['id'] ?>
                </p>
                <p>
                    <label>Customer Name:</label>
                    <?= $jobsheet['name'] ?>
                </p>
                <p>
                    <label>Reg. No.:</label>
                    <?= $jobsheet['reg_no'] ?>
                </p>
                <p>
                    <label>Chassis No.:</label>
                    <?= $jobsheet['chassis_no'] ?>
                </p>
                <div>
                    <label for="payment_mode">Payment Mode:</label>
                <div id="payment_wrapper">
                    <?php 
                        echo form_dropdown(
                            'payment_mode', 
                            $paymentModes, 
                            (isset($_POST['payment_mode']) ? $_POST['payment_mode'] : $bill['payment_mode']),
                            'id="payment_mode"'
                        );
                    ?>
                </div>
                </div>                
            </div>
            <div class="grid_2 beta">
                <p>
                    <label>Bill Date:</label>   
                    <?= date('d/m/Y') ?>
                    <?php echo form_hidden('bill_date', date('Y-m-d')) ?>
                </p>
                <p>
                    <label>Contact:</label>
                    <?= $jobsheet['contact'] ?>
                </p>
                <p>
                    <label>Address</label>
                    <div class="address-div"><?= nl2br($jobsheet['address']) ?></div>
                </p>
            </div>
            </div>
        <div class="clear"></div>    
        
        <p><h3>Labour Details:</h3></p>
        <div id="bill-labour-details">            
            <?php if(isset($jobsheet['labour_charges'])) { ?>
                <?php 
                    $i = 1; 
                    $labourTotal = 0;
                    $taxTotal = 0;
                ?>
                <div id="bill-labour-item">
                    <div class="bill-charges-desc border-bottom"><strong>Job Description</strong></div>
                    <div class="bill-charges-amount border-bottom"><strong>Charge</strong></div>
                    <div class="bill-charges-amount border-bottom">
                        <strong>Tax </strong>(<?= round($labourTax * 100,2) ?>%)
                    </div>
                    <div class="bill-charges-amount border-bottom"><strong>Total</strong></div>
                </div>
                <?php foreach ($jobsheet['labour_charges'] as $labourCharge) { ?>
                    <div id="bill-labour-item">
                        <div class="bill-charges-desc">
                            <?php echo $jobtypes[$labourCharge['job_type']]. ' - '. $labourCharge['description'] ?>
                        </div>
                        <div class="bill-charges-amount"><?= number_format($labourCharge['amount'],2) ?></div>
                        <div class="bill-charges-amount">
                            <?= number_format(round($labourCharge['amount']*$labourTax, 2),2) ?>
                        </div>
                        <div class="bill-charges-amount">
                            <?php 
                                echo number_format(
                                    round(
                                        ($labourCharge['amount']*$labourTax) + $labourCharge['amount'], 
                                         2
                                    ), 
                                    2
                                ); 
                            ?>
                        </div>
                    </div>
                    <? 
                    echo form_hidden(
                            "bill_charges[$i][description]",
                            $jobtypes[$labourCharge['job_type']]. ' - '. $labourCharge['description']
                    );

                    echo form_hidden(
                            "bill_charges[$i][amount]",
                            $labourCharge['amount']
                        );

                    echo form_hidden(
                            "bill_charges[$i][tax]",
                            round($labourCharge['amount']*$labourTax, 2)
                        );
                    
                    $total = round(($labourCharge['amount']*$labourTax) + $labourCharge['amount'], 2);
                    echo form_hidden(
                            "bill_charges[$i][total]",
                            $total
                        );

                    $i++;
                    $labourTotal+= $total;
                    $taxTotal+= round($labourCharge['amount']*$labourTax, 2);
                    ?>
                <?php } ?>
                <div id="bill-labour-item">
                    <div class="bill-charges-desc">&nbsp;</div>
                    <div class="bill-charges-amount">&nbsp;</div>
                    <div class="bill-charges-amount border-top"><strong>Total:</strong></div>
                    <div class="bill-charges-amount border-top"><?= number_format($labourTotal, 2) ?></div>
                </div>
                <input type="hidden" value="<?= $labourTotal ?>" id="labour_total" />
            <?php } ?>
        </div>
        
        <p><h3>Parts Description:</h3></p>
        <div id="bill-parts-details">            
            <?php if(isset($jobsheet['jobsheet_parts'])) { ?>
                <?php $i = 1; ?>
                <?php $partsTotal = 0; ?>
                <div id="bill-labour-item">
                    <div class="bill-parts-item border-bottom"><strong>Item Description</strong></div>
                    <div class="bill-charges-amount border-bottom"><strong>Rate</strong></div>
                    <div class="bill-charges-amount border-bottom">
                        <strong>Tax </strong>(<?= round($partsTax * 100,2) ?>%)
                    </div>
                    <div class="bill-charges-amount border-bottom"><strong>Quantity</strong></div>
                    <div class="bill-charges-amount border-bottom"><strong>Total</strong></div>
                </div>
                <?php foreach ($jobsheet['jobsheet_parts'] as $jobsheetPart) { ?>
                    <div id="bill-labour-item">
                        <div class="bill-parts-item"><?= $parts[$jobsheetPart['part_id']]['name'] ?></div>
                        <div class="bill-charges-amount">
                            <?= number_format($parts[$jobsheetPart['part_id']]['mrp'],2) ?>
                        </div>
                        <div class="bill-charges-amount">
                            <?= number_format(round($parts[$jobsheetPart['part_id']]['mrp'] * $partsTax, 2), 2) ?>
                        </div>
                        <div class="bill-charges-amount"><?= $jobsheetPart['qty'] ?></div>
                        <div class="bill-charges-amount">
                            <?php
                            echo number_format(
                                round(
                                    (
                                        ($parts[$jobsheetPart['part_id']]['mrp'] * $partsTax) 
                                        + $parts[$jobsheetPart['part_id']]['mrp']
                                    ) * $jobsheetPart['qty'],
                                    2
                                ), 
                                2
                            );
                            ?>
                        </div>
                    </div>
                    <? 
                    echo form_hidden(
                            "bill_parts[$i][part_name]",
                            $parts[$jobsheetPart['part_id']]['name']
                    );

                    echo form_hidden(
                            "bill_parts[$i][rate]",
                            $parts[$jobsheetPart['part_id']]['mrp']
                        );

                    echo form_hidden(
                            "bill_parts[$i][tax]",
                            round($parts[$jobsheetPart['part_id']]['mrp'] * $partsTax, 2)
                        );
                    
                    echo form_hidden(
                            "bill_parts[$i][quantity]",
                            $jobsheetPart['qty']
                        );
                    
                    $total = round((($parts[$jobsheetPart['part_id']]['mrp'] * $partsTax) 
                                + $parts[$jobsheetPart['part_id']]['mrp']) * $jobsheetPart['qty'], 2);
                    echo form_hidden(
                            "bill_parts[$i][total]",
                            $total
                        );

                    $i++;
                    $partsTotal+= $total;
                    ?>
                <?php } ?>
                <div id="bill-labour-item">
                    <div class="bill-parts-item">&nbsp;</div>
                    <div class="bill-charges-amount">&nbsp;</div>
                    <div class="bill-charges-amount">&nbsp;</div>
                    <div class="bill-charges-amount border-top"><strong>Total:</strong></div>
                    <div class="bill-charges-amount border-top"><?= number_format($partsTotal, 2) ?></div>
                </div>
                <input type="hidden" value="<?= $partsTotal ?>" id="parts_total" />
            <?php } ?>
        </div>
        
        <div>
            <strong>Round Off: </strong>
            <?php 
                echo form_input(
                    'round_off',
                    ceil($taxTotal),
                    'id="round_off" placeholder="'.ceil($taxTotal).'"'
                ); 
            ?>
        </div>
        <div class="clear"></div>
        
        <div style="display:inline-block">
            <div class="grand-total">Grand Total: 
                <span id="grand_total_span"><?= number_format(floor($labourTotal+$partsTotal)) ?></span>
            /-</div>
            <input type="hidden" name="grand_total" id="grand_total" 
                   value="<?= floor($labourTotal+$partsTotal)?>" />
        </div>
        </div>        
    </div>        
        
    <div class="nextprev">
        <input type="button" value="Preview Print" onClick="window.print();">
        <input type="submit" value="Save &amp; Print" onClick="window.print();">
        <input type="button" onclick="window.location='/index.php/billing'" value="Cancel">
    </div>
</form>
</div>
