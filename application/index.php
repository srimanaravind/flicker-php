<?php

/**
 * Flickr Photo Viewer
 *
 * @package    Flicker
 * @author     Aravind.B.Dev <aravind@abdev.in>
 * @link       http://www.abdev.com.au
 *
 */

// include init setting
include './config/config.php';

// call flicker controller
$flicker = new FlickerController();

// show index action of flicker controller
$flicker->indexAction();