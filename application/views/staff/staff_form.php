<?php 
/** Includes **/
    echo script_tag('js/staff.js');
?>
<div id="staff-create">
<?php echo form_open($formName) ?>    
    <div class="banner">
        <h2><?= $title ?></h2>            
    </div>
    <div id="staff-form">        
        <div class="error"><?php echo validation_errors(); ?></div>
            <div class="grid_1 alpha">
                <p>
                    <label for="name">Name:<span class="red">*</span></label>
                    <input type="text" id="purpose" name="name"
                           value="<?= set_value('name', $staff['name']) ?>"/>
                </p>
                <p>
                    <label for="contact">Contact:<span class="red">*</span></label>
                    <input type="text" id="contact" name="contact"
                           value="<?= set_value('contact', $staff['contact']) ?>"/>
                </p>
                <p>
                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email"
                           value="<?= set_value('email', $staff['email']) ?>"/>
                </p>
                <p>
                    <label for="salary">Salary:</label>
                    <?php echo form_input('salary', set_value('salary', $staff['salary']), 'id="salary"') ?>
                </p>
                <p>
                    <label for="role">Role:<span class="red">*</span></label>
                    <?php 
                        echo form_dropdown(
                                'role', 
                                $roles, 
                                (isset($_POST['role']) ? $_POST['role'] : $staff['role']),
                                'id="staff_role"'
                            ); 
                    ?>
                </p>
                
            </div>
            <div class="grid_2 beta">
                <p>
                    <label for="notes">Special Notes:</label>
                    <textarea id="notes" name="notes" rows="5"><?= set_value('notes', $staff['notes']) ?></textarea>
                </p>

            </div>        
        <div class="clear"></div>    
    </div>
    
    <div class="nextprev">
        <input type="submit" value="Save">
        <input type="button" onclick="window.location='/index.php/staff'" value="Cancel">
    </div>
</form>


</div>
