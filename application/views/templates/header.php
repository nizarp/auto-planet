<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
   <title><?php echo $title ?></title>
   <?php echo link_tag('css/main.css'); ?>
   <?php echo script_tag('js/lib/jquery-1.6.2.min.js'); ?>
 </head>
 <body>
     <?php $userData = $this->session->userdata('logged_in'); ?>
     <div id="page">
         <div class="page-header">
            <h1 class="logo"><a href="/">Auto Planet</a></h1>
            <ul>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/home" 
                       <?php echo ($tab == 'Jobsheet') ? 'class="menu-active"' : '' ?> >Jobsheets</a></li>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/billing"
                       <?php echo ($tab == 'Billing') ? 'class="menu-active"' : '' ?> >Billing</a></li>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/expense"
                       <?php echo ($tab == 'Expense') ? 'class="menu-active"' : '' ?> >Expenses</a></li>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/wage" 
                       <?php echo ($tab == 'Wage') ? 'class="menu-active"' : '' ?> >Wages</a></li>
                <? if($userData['username'] == 'admin'): ?>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/staff"
                       <?php echo ($tab == 'Staff') ? 'class="menu-active"' : '' ?> >Staffs</a></li>
                <? endif; ?>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/part"
                       <?php echo ($tab == 'Part') ? 'class="menu-active"' : '' ?> >Parts</a></li>
                <li><a tabindex="-1" href="<?php echo base_url(); ?>index.php/home/logout">Logout</a></li>
            </ul>
        </div>
        <div class="content"> 