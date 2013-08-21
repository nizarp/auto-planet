
<?php 
/** Includes **/
    echo script_tag('js/staff.js');
?>

    <div id="home-page">
        <div class="banner">
            <h2>Staffs</h2>
            <div class="banner-buttons">
                <a href="/index.php/staff/create" class="btn-grn">Create Staff</a>
            </div>
        </div>
        <?php echo form_open('staff/search'); ?>
            <div id="staff-search">
                <input type="text" name="search" value="<?php echo $keyword; ?>" 
                       placeholder="Enter Name"/>
                <input type="submit" value="Go" id="search_btn" />
            </div>
        <?php echo form_close(); ?>
        <div class="clear"><?php echo $this->pagination->create_links(); ?></div>
        <table id="staff-list" class="grid-list">
            <colgroup>
                <col width="40%"/>
                <col width="20%"/>
                <col width="20%"/>
                <col width="20%"/>
                <col width="10%"/>
            </colgroup>
            <thead>
                <th>Name</th>
                <th>Contact</th>
                <th>Role</th>
                <th>Added On</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <?php
                    $alternate = false;
                ?>
                <?php foreach ($staffs as $staff): ?>
                <?php $alternate = !$alternate; ?>
                <tr <?php echo ($alternate)?'class="row"':'' ?>>
                    <td><?php echo $staff['name'] ?></td>
                    <td><?php echo $staff['contact'] ?></td>
                    <td><?php echo $roles[$staff['role']] ?></td>
                    <td><?php echo date('M d, Y', strtotime($staff['created_on'])) ?></td>
                    <td>
                        <img onclick="window.location='/index.php/staff/edit/<?php echo $staff['id'] ?>'" 
                             src="/css/images/edit.png">
                        <img class="staff-delete-btn" rel="<?php echo $staff['id'] ?>" 
                             src="/css/images/delete.png">
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
<div class="spacer"></div>
