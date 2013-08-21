
<?php 
/** Includes **/
    echo script_tag('js/lib/datePicker/date.js');
    echo script_tag('js/lib/datePicker/jquery.datePicker.min.js');
    echo script_tag('js/jobsheet.js');
    echo script_tag('js/lib/md5-min.js');
    echo link_tag('js/lib/datePicker/datePicker.css');
    echo link_tag('css/datePicker.css');
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
                       placeholder="Enter Reg. Number or Name"/>
                <input type="submit" value="Go" id="search_btn" />
            </div>
        <?php echo form_close(); ?>
        <div class="clear"><?php echo $this->pagination->create_links(); ?></div>
        <table id="jobsheet-list" class="grid-list">
            <colgroup>
                <col width="13%"/>
                <col width="23%"/>
                <col width="17%"/>
                <col width="13%"/>
                <col width="14%"/>
                <col width="12%"/>
                <col width="8%"/>
            </colgroup>
            <thead>
                <th>Reg. No.</th>
                <th>Customer Name</th>
                <th>Contact</th>
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
                    <td><?php echo str_ireplace($keyword, "<span class='highlight'>{$keyword}</span>", $jobsheet['reg_no']) ?></td>
                    <td><?php echo str_ireplace($keyword, "<span class='highlight'>{$keyword}</span>", $jobsheet['name']) ?></td>
                    <td><?php echo $jobsheet['contact'] ?></td>
                    <td><?php echo date('M d, Y', strtotime($jobsheet['created_on'])) ?></td>
                    <td><?php echo date('M d, Y', strtotime($jobsheet['promised_date'])) ?></td>
                    <td>
                        <select class="jobsheet-status" rel="<?php echo $jobsheet['id'] ?>">
                            <option value="open" 
                                <?php echo ($jobsheet['status'] == 'open') ? 'Selected' : '' ?>>
                                Open</option>
                            <option value="complete" 
                                <?php echo ($jobsheet['status'] == 'complete') ? 'Selected' : '' ?>>
                                Complete</option>
                            <option value="close" 
                                <?php echo ($jobsheet['status'] == 'close') ? 'Selected' : '' ?>>
                                Close</option>
                            <option value="reopen"
                                <?php echo ($jobsheet['status'] == 'reopen') ? 'Selected' : '' ?>>
                                Reopen</option>
                        </select>
                    </td>
                    <td>
                        <img onclick="window.location='/index.php/jobsheet/edit/<?php echo $jobsheet['id'] ?>'" src="/css/images/edit.png">
                        <img class="jobsheet-delete-btn" rel="<?php echo $jobsheet['id'] ?>" src="/css/images/delete.png">
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
<div class="spacer"></div>
