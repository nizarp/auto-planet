
<?php 
/** Includes **/
    echo script_tag('js/lib/datePicker/date.js');
    echo script_tag('js/lib/datePicker/jquery.datePicker.min.js');
    echo script_tag('js/expense.js');
    echo link_tag('js/lib/datePicker/datePicker.css');
    echo link_tag('css/datePicker.css');
?>

    <div id="home-page">
        <div class="banner">
            <h2>Expenses</h2>
            <div class="banner-buttons">
                <a href="/index.php/expense/create" class="btn-grn">Create Expense</a>
            </div>
        </div>
        <?php
            $dates = explode('__', $keyword);
            $startDate = (isset($dates[0])) ? $dates[0] : '';
            $endDate = (isset($dates[1])) ? $dates[1] : '';
        ?>
        <?php echo form_open('expense/search'); ?>
            <div id="expense-search">
                <div class="expense-start-date">
                <strong>Date: </strong>
                <input type="text" name="start_date" id="expense_search_start_date" 
                       value="<?php echo ($startDate !='') ? date('d/m/Y', strtotime($startDate)) : ''; ?>" 
                       placeholder="__/ __/ ____"/>
                <span id="expense-search-start-date-btn" class="cal-input"></span>
                </div>
                <div class="expense-date-separator">To</div>
                <div class="expense-end-date">
                <input type="text" name="end_date" id="expense_search_end_date" 
                       value="<?php echo ($endDate !='') ? date('d/m/Y', strtotime($endDate)) : ''; ?>" 
                       placeholder="__/ __/ ____"/>
                <span id="expense-search-end-date-btn" class="cal-input"></span>&nbsp;&nbsp;&nbsp;
                <input type="submit" value="Search" id="search_btn" />
                </div>
            </div>
        <?php echo form_close(); ?>
        <div class="clear"><?php echo $this->pagination->create_links(); ?></div>
        <table id="expense-list" class="grid-list">
            <colgroup>
                <col width="57%"/>
                <col width="20%"/>
                <col width="15%"/>
                <col width="8%"/>
            </colgroup>
            <thead>
                <th>Purpose</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <?php
                    $alternate = false;
                ?>
                <?php foreach ($expenses as $expense): ?>
                <?php $alternate = !$alternate; ?>
                <tr <?php echo ($alternate)?'class="row"':'' ?>>
                    <td><?php echo $expense['purpose'] ?></td>
                    <td><?php echo $expense['amount'] ?></td>
                    <td><?php echo date('M d, Y', strtotime($expense['created_on'])) ?></td>
                    <td>
                        <img onclick="window.location='/index.php/expense/edit/<?php echo $expense['id'] ?>'" 
                             src="/css/images/edit.png">&nbsp;
                        <?php if($username == 'admin'): ?>
                        <img class="expense-delete-btn" rel="<?php echo $expense['id'] ?>" 
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
