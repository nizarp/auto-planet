<?php
/**
 * My Custom validations
 */
class MY_Form_validation extends CI_Form_validation{    
    
    function __construct($config = array())
    {
        parent::__construct($config);
    }
    
    function registration_check($str)
    {
        if (! preg_match("/^([-a-z0-9])+$/i", $str))
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    function alpha_space($str)
    {
        if (! preg_match("/^([ a-z])+$/i", $str))
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
}
?>
