<?php

/**
 * FlickerController
 *
 * Flicker Controller
 *
 * @package    Flicker
 * @author     Aravind.B.Dev <aravind@abdev.in>
 * @link       http://www.abdev.com.au
 *
 */

class FlickerController
{
    
    /**
     * indexAction
     *
     * @author Aravind B Dev
     * @access public 
     * @return ViewModel
     *
     */
    
    public function indexAction()
    {
        $viewModel = new ViewModel();
        
        // check if search string is present
        $search = (isset($_GET['search']) && $_GET['search']) ? trim($_GET['search']) : '';
        $page = (isset($_GET['page']) && $_GET['page']) ? $_GET['page'] : 1;
        $viewModel->search = $search;
        
        $images = array();
        
        if($search)
        {
            // if search string present
            try
            {
                // check if we can create a valid flicker model object
                $flicker = new FlickerModel();
            }
            catch (Exception $e)
            {
                echo $e->getMessage();
                die();
            }
            // set api key
            $flicker->api_key = '340aa607ac2d150d17fdca20882cf56a';
            // set number of results per page
            $flicker->per_page = '5';
            // set the page
            $flicker->page = $page;
            // set the search 
            $flicker->tags = $search;
            
            // set the image to return and its sizes
            // s	small square 75x75
            // q	large square 150x150
            // t	thumbnail, 100 on longest side
            // m	small, 240 on longest side
            // n	small, 320 on longest side
            // -	medium, 500 on longest side
            // z	medium 640, 640 on longest side
            // c	medium 800, 800 on longest side†
            // b	large, 1024 on longest side
            
            $flicker->setReturnImages(array('img_thumb' => 'q', 'img_main' => 'b'));
            // get the image list from flicker
            $images = $flicker->getImages();
        }
        
        $viewModel->images = $images;
        $viewModel->display('index');
    }
}