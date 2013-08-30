
<?php 
/** Includes **/
    echo script_tag('js/billing.js');
    echo script_tag('js/lib/jquery_impromptu/jquery-impromptu.js');
    echo link_tag('js/lib/jquery_impromptu/jquery-impromptu.css');
?>

    <div id="home-page">
        <div class="banner">
            <h2>Bills</h2>            
        </div>
        <div id="create-bill">
            <?php 
                echo form_dropdown('jobsheets', $jobsheets);
            ?>
            <input type="button" id="create-bill-btn" value="Create Bill">
        </div>
        <?php echo form_open('billing/search'); ?>
            <div id="billing-search">
                <input type="text" name="search" value="<?php echo $keyword; ?>" 
                       title="Enter Bill No./ Jobsheet No./ Reg. No./ Customer Name/ Chassis No."
                       placeholder="Enter Keyword"/>
                <input type="submit" value="Search" id="search_btn" />
            </div>
        <?php echo form_close(); ?>
        <div class="clear"><?php echo $this->pagination->create_links(); ?></div>
        <table id="bill-list" class="grid-list">
            <colgroup>
                <col width="12%"/>
                <col width="12%"/>
                <col width="15%"/>
                <col width="25%"/>
                <col width="13%"/>
                <col width="15%"/>
                <col width="8%"/>
            </colgroup>
            <thead>
                <th>Bill No.</th>
                <th>Jobsheet No.</th>
                <th>Reg No.</th>
                <th>Customer Name</th>
                <th>Total Amount</th>
                <th>Date</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <?php
                    $alternate = false;
                ?>
                <?php foreach ($bills as $bill): ?>
                <?php $alternate = !$alternate; ?>
                <tr <?php echo ($alternate)?'class="row"':'' ?>>
                    <td><?php echo $bill['id'] ?></td>
                    <td><?php echo $bill['jobsheet_id'] ?></td>
                    <td><?php echo $bill['reg_no'] ?></td>
                    <td><?php echo $bill['name'] ?></td>
                    <td><?php echo $bill['grand_total'] ?></td>
                    <td><?php echo date('M d, Y', strtotime($bill['bill_date'])) ?></td>
                    <td>                        
                        <?php if($username == 'admin'): ?>
                        <img class="bill-delete-btn" rel="<?php echo $bill['id'] ?>" 
                             src="/css/images/delete.png">
                        <? endif; ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
<div class="total-rollup">Total: <?= number_format($total,2) ?></div>
<div class="spacer"></div>
