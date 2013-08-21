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
                    <label for="name">Name:<span class="red">*</span></label>
                    <input type="text" id="name" name="name"
                           value="<?= set_value('name', $part['name']) ?>"/>
                </p>
                <p>
                    <label for="dealer_price">Dealer Price:<span class="red">*</span></label>
                    <input type="text" id="dealer_price" name="dealer_price"
                           value="<?= set_value('dealer_price', $part['dealer_price']) ?>"/>
                </p>
                <p>
                    <label for="mrp">MRP:</label>
                    <input type="text" id="mrp" name="mrp"
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
