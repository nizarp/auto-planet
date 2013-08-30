
<?php 
/** Includes **/
    echo script_tag('js/part.js');
    echo script_tag('js/lib/jquery.jeditable.mini.js');
?>

    <div id="home-page">
        <div class="banner">
            <h2>Parts</h2>
            <div class="banner-buttons">
                <a href="/index.php/part/create" class="btn-grn">Add Parts</a>
            </div>
        </div>
        <?php echo form_open('part/search'); ?>
            <div id="part-search">
                <input type="text" name="search" value="<?php echo $keyword; ?>" 
                       placeholder="Enter Name or Part ID"/>
                <input type="submit" value="Search" id="search_btn" />
            </div>
        <?php echo form_close(); ?>
        <div class="clear"><?php echo $this->pagination->create_links(); ?></div>
        <table id="part-list" class="grid-list">
            <colgroup>
                <col width="10%"/>
                <col width="60%"/>
                <col width="10%"/>
                <col width="10%"/>
                <col width="10%"/>
            </colgroup>
            <thead>
                <th>Part ID</th>
                <th>Name</th>
                <th>MRP</th>
                <th>Quantity</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <?php
                    $alternate = false;
                ?>
                <?php foreach ($parts as $part): ?>
                <?php $alternate = !$alternate; ?>
                <tr title="<?php echo $part['description'] ?>" <?php echo ($alternate)?'class="row"':'' ?>>
                    <td><?php echo $part['id'] ?></td>
                    <td><?php echo $part['name'] ?></td>
                    <td><?php echo $part['mrp'] ?></td>
                    <td class="edit_area" id="<?php echo $part['id']; ?>"><?php echo ($part['quantity']) ? $part['quantity'] : 0 ?></td>
                    <td>
                        <?php if($username == 'admin'): ?>
                        <img onclick="window.location='/index.php/part/edit/<?php echo $part['id'] ?>'" 
                             src="/css/images/edit.png">  
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
<div class="spacer"></div>
