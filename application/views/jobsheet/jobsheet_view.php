
<?php 
/** Includes **/
    echo script_tag('js/lib/datePicker/date.js');
    echo script_tag('js/lib/datePicker/jquery.datePicker.min.js');
    echo script_tag('js/jobsheet.js');
    echo script_tag('js/lib/md5-min.js');
    echo script_tag('js/lib/jquery_impromptu/jquery-impromptu.js');
    echo link_tag('js/lib/datePicker/datePicker.css');
    echo link_tag('css/datePicker.css');
    echo link_tag('js/lib/jquery_impromptu/jquery-impromptu.css');
?>

    <div id="home-page">
        <div class="banner">
            <h2>Jobsheets</h2>
            <div class="banner-buttons">
                <a href="/index.php/jobsheet/create" class="btn-grn">Create Jobsheet</a>
            </div>
        </div>
        <?php echo form_open('jobsheet/search'); ?>
            <div id="jobsheet-search">
                <input type="text" name="search" value="<?php echo $keyword; ?>" 
                       title="Enter Jobsheet No./ Reg. No./ Customer Name/ Chassis No."
                       placeholder="Enter Keyword"/>
                <input type="submit" value="Search" id="search_btn" />
            </div>
        <?php echo form_close(); ?>
        <div class="clear"><?php echo $this->pagination->create_links(); ?></div>
        <table id="jobsheet-list" class="grid-list">
            <colgroup>
                <col width="15%"/>
                <col width="13%"/>
                <col width="25%"/>                
                <col width="13%"/>
                <col width="14%"/>
                <col width="12%"/>
                <col width="8%"/>
            </colgroup>
            <thead>
                <th>Jobsheet No.</th>
                <th>Reg. No.</th>
                <th>Customer Name</th>                
                <th>Booked Date</th>
                <th>Promised Date</th>
                <th>Status</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <?php
                    $alternate = false;
                ?>
                <?php foreach ($jobsheets as $jobsheet): ?>
                <?php $alternate = !$alternate; ?>
                <tr <?php echo ($alternate)?'class="row"':'' ?>>
                    <td>
                        <a href="/index.php/jobsheet/view/<?= $jobsheet['id'] ?>">
                            <?php 
                            echo str_ireplace($keyword, "<span class='highlight'>{$keyword}</span>", $jobsheet['id']) 
                            ?>
                        </a>
                    </td>
                    <td>
                        <?php 
                        echo str_ireplace($keyword, "<span class='highlight'>{$keyword}</span>", $jobsheet['reg_no']) 
                        ?>
                    </td>
                    <td><?php echo str_ireplace($keyword, "<span class='highlight'>{$keyword}</span>", $jobsheet['name']) ?></td>                    
                    <td><?php echo date('M d, Y', strtotime($jobsheet['created_on'])) ?></td>
                    <td><?php echo date('M d, Y', strtotime($jobsheet['promised_date'])) ?></td>
                    <td>
                        <?php
                        $statuses = array(
                            'open' => 'Open',
                            'complete' => 'Complete',
                            'close' => 'Close',
                            'reopen' => 'Reopen'
                        );                        
                        ?>
                        <select class="jobsheet-status" rel="<?= $jobsheet['id'] ?>" data="<?= $jobsheet['delivered_date'] ?>">
                            <?php foreach($statuses as $key => $val): ?>
                                <option value="<?= $key ?>"
                                    <?php echo ($jobsheet['status'] == $key) ? ' selected' : '' ?>>
                                    <?= $val ?></option>
                            <?php endforeach; ?>                            
                        </select>
                    </td>
                    <td>
                        <img rel="<?= $jobsheet['id'] ?>" class="jobsheet-edit-btn" src="/css/images/edit.png">
                        <?php if($username == 'admin'): ?>
                        <img class="jobsheet-delete-btn" rel="<?= $jobsheet['id'] ?>" src="/css/images/delete.png">
                        <? endif; ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
<div class="spacer"></div>
