<?php
$config = array(
    'jobsheet_form' => array(
        array(
              'field'   => 'name', 
              'label'   => 'Name', 
              'rules'   => 'required|alpha_space'
           ),
        array(
              'field'   => 'contact', 
              'label'   => 'Contact', 
              'rules'   => 'required|numeric|min_length[6]'
           ),
        array(
              'field'   => 'promised_date', 
              'label'   => 'Promised Date', 
              'rules'   => 'required'
           ),
        array(
              'field'   => 'estimated_amount', 
              'label'   => 'Estimated Amount', 
              'rules'   => 'numeric'
           ),
        array(
              'field'   => 'mileage', 
              'label'   => 'Mileage', 
              'rules'   => 'required|numeric'
           ),
        array(
              'field'   => 'reg_no', 
              'label'   => 'Registration Number', 
              'rules'   => 'required|registration_check|min_length[5]'
           )        
    ),
    'expense_form' => array(
        array(
              'field'   => 'purpose', 
              'label'   => 'Purpose', 
              'rules'   => 'required'
           ),
        array(
              'field'   => 'amount', 
              'label'   => 'Amount', 
              'rules'   => 'required|numeric'
           )
    ),
    'staff_form' => array(
        array(
              'field'   => 'name', 
              'label'   => 'Name', 
              'rules'   => 'required|alpha_space'
           ),
        array(
              'field'   => 'contact', 
              'label'   => 'Contact', 
              'rules'   => 'required|numeric|min_length[6]'
           ),
        array(
              'field'   => 'email', 
              'label'   => 'Email', 
              'rules'   => 'valid_email'
           ),
        array(
              'field'   => 'salary', 
              'label'   => 'Salary', 
              'rules'   => 'numeric'
           )        
    ),
    'wage_form' => array(
        array(
              'field'   => 'staff', 
              'label'   => 'Staff', 
              'rules'   => 'required'
           ),
        array(
              'field'   => 'amount', 
              'label'   => 'Amount', 
              'rules'   => 'required|numeric'
           )
    ),
    'part_form' => array(
        array(
              'field'   => 'part_name', 
              'label'   => 'Part Name', 
              'rules'   => 'required'
           ),
        array(
              'field'   => 'quantity', 
              'label'   => 'Quantity', 
              'rules'   => 'required|numeric'
           ),
        array(
              'field'   => 'dealer_price', 
              'label'   => 'Dealer Price', 
              'rules'   => 'required|numeric'
           ),
        array(
              'field'   => 'mrp', 
              'label'   => 'MRP', 
              'rules'   => 'required|numeric'
           )
    )
);
?>
