
<?php 
/** Includes **/
    echo script_tag('js/lib/datePicker/date.js');
    echo script_tag('js/lib/datePicker/jquery.datePicker.min.js');
    echo script_tag('js/wage.js');
    echo link_tag('js/lib/datePicker/datePicker.css');
    echo link_tag('css/datePicker.css');
?>

    <div id="home-page">
        <div class="banner">
            <h2>Wages</h2>
            <div class="banner-buttons">
                <a href="/index.php/wage/create" class="btn-grn">Add Wage</a>
            </div>
        </div>
        <?php echo form_open('wage/search'); ?>
            <div id="wage-search">
                <?php 
                    echo form_dropdown(
                        'search', 
                        $staffs, 
                        (isset($_GET['search']) ? $_GET['search'] : ''),
                        'id="staff-dropdown"'
                    ); 
                ?>
                &nbsp;<input type="submit" value="Go" id="search_btn" />
            </div>
        <?php echo form_close(); ?>
        <div class="clear"><?php echo $this->pagination->create_links(); ?></div>
        <table id="wage-list" class="grid-list">
            <colgroup>
                <col width="20%"/>
                <col width="11%"/>
                <col width="11%"/>
                <col width="50%"/>
                <col width="8%"/>
            </colgroup>
            <thead>
                <th>Staff</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Description</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <?php
                    $alternate = false;
                ?>
                <?php foreach ($wages as $wage): ?>
                <?php $alternate = !$alternate; ?>
                <tr <?php echo ($alternate)?'class="row"':'' ?>>
                    <td><?php echo $staffs[$wage['staff']] ?></td>
                    <td><?php echo $wage['amount'] ?></td>
                    <td><?php echo date('M d, Y', strtotime($wage['created_on'])) ?></td>
                    <td><?php echo character_limiter($wage['description'], 60) ?></td>
                    <td>
                        <img onclick="window.location='/index.php/wage/edit/<?php echo $wage['id'] ?>'" 
                             src="/css/images/edit.png">
                        <img class="wage-delete-btn" rel="<?php echo $wage['id'] ?>" 
                             src="/css/images/delete.png">
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
<div class="spacer"></div>
