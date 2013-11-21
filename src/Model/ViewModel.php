<?php

/**
 * ViewModel
 *
 * View Model
 *
 * @package    Flicker
 * @author     Aravind.B.Dev <aravind@abdev.in>
 * @link       http://www.abdev.com.au
 *
 */

class ViewModel
{
    
    /**
     * $data 
     *
     * @var array
     */
    
    public $data;
    
    /**
     * __construct
     * 
     * constrctor for view model
     *
     * @author Aravind B Dev
     * @access public 
     *
     */
    
    public function __construct()
    {
        $this->data = array();
    }
    
    /**
     * __set
     * 
     * set method for view model
     *
     * @author Aravind B Dev
     * @access public 
     *
     */
    
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }
    
    /**
     * __get
     * 
     * get method for view model
     *
     * @author Aravind B Dev
     * @access public 
     *
     */
    
    public function __get($name)
    {
        if (array_key_exists($name, $this->data))
        {
            return $this->data[$name];
        }
        return null;
    }
    
    /**
     * display
     * 
     * display the template file
     *
     * @author Aravind B Dev
     * @access public 
     *
     */

    public function display($name)
    {
	$path = './src/view/' . $name . '.php';

	if (file_exists($path) == false)
	{
            throw new Exception('Template not found in '. $path);
            return false;
	}

	// Load variables
	foreach ($this->data as $key => $value)
	{
            $$key = $value;
	}

	include ($path);  
    }
}