<?php 
/** Includes **/
    echo script_tag('js/part.js');
?>
<div id="part-create">
<?php echo form_open($formName) ?>    
    <div class="banner">
        <h2><?= $title ?></h2>            
    </div>
    <div id="part-form">        
        <div class="error"><?php echo validation_errors(); ?></div>
            <div class="grid_1 alpha">
                <p>
                    <label for="part_no">Part No.:</label>
                    <input type="text" id="part_no" name="part_no" maxlength="60"
                           value="<?= set_value('part_no', $part['part_no']) ?>"/>
                </p>
                <p>
                    <label for="hsn_code">HSN Code:</label>
                    <input type="text" id="hsn_code" name="hsn_code" maxlength="60"
                           value="<?= set_value('hsn_code', $part['hsn_code']) ?>"/>
                </p>
                <p>
                    <label for="part_name">Part Name:<span class="red">*</span></label>
                    <input type="text" id="part_name" name="part_name" maxlength="60"
                           value="<?= set_value('part_name', $part['part_name']) ?>"/>
                </p>
                <p>
                    <label for="quantity">Quantity:<span class="red">*</span></label>
                    <input type="text" id="quantity" name="quantity" maxlength="5"
                           value="<?= set_value('quantity', $part['quantity']) ?>"/>
                </p>
                <p>
                    <label for="dealer_price">Dealer Price:<span class="red">*</span></label>
                    <input type="text" id="dealer_price" name="dealer_price" maxlength="15"
                           value="<?= set_value('dealer_price', $part['dealer_price']) ?>"/>
                </p>
                <p>
                    <label for="mrp">MRP:<span class="red">*</span></label>
                    <input type="text" id="mrp" name="mrp" maxlength="15"
                           value="<?= set_value('mrp', $part['mrp']) ?>"/>
                </p>
                <p>
                    <label for="description">Description:</label>
                    <textarea id="notes" name="description" rows="5"><?= set_value('description', $part['description']) ?></textarea>
                </p>
                
            </div>        
        <div class="clear"></div>    
    </div>
    
    <div class="nextprev">
        <input type="submit" value="Save">
        <input type="button" onclick="window.location='/index.php/part'" value="Cancel">
    </div>
</form>


</div>
