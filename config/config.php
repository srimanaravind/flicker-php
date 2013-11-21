<?php

/**
 * config
 *
 * @package    Flicker
 * @author     Aravind.B.Dev <aravind@abdev.in>
 * @link       http://www.abdev.com.au
 *
 */

// Include Library Files

/**
 * __autoload
 *
 * @author Aravind B Dev
 * @access public 
 * @param string  $class_name - Class name
 *
 */

function __autoload($class_name)
{
    $class_file_name = "./src/Controller/".$class_name.".php";
    if(! file_exists($class_file_name))
    {
        $class_file_name = "./src/Model/".$class_name.".php";
    }
    try
    {
        if(! file_exists($class_file_name))
        {
            throw new Exception ($class_file_name .' not found');
        }
        else
        {
            require_once($class_file_name);
        }
    }
    catch(Exception $e)
    {    
        echo $e->getMessage();
        die();
    }
}