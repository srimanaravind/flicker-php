<?php

/**
 * FlickerModel
 *
 * Flicker Model
 *
 * @package    Flicker
 * @author     Aravind.B.Dev <aravind@abdev.in>
 * @link       http://www.abdev.com.au
 *
 */

class FlickerModel
{
    
    /**
     * $url 
     *
     * @var url
     */
    
    private $url;
    
    /**
     * $data
     *
     * @var data
     */
    
    private $data;
    
    /**
     * $image_settings
     *
     * @var image settings
     */
    
    private $image_settings;
    
    /**
     * __construct
     * 
     * constructor for flicker model
     *
     * @author Aravind B Dev
     * @access public 
     *
     */
    
    public function __construct()
    {
        $this->image_settings = array();
        $this->url = 'http://api.flickr.com/services/rest/?method=flickr.photos.search&safe_search=1&format=json&nojsoncallback=?';
        if(! function_exists('curl_version'))
        {
            // if curl extension not exists, throw an exception
            throw new Exception('Please enable curl extnesion in php to continue');
        }
    }
    
    /**
     * __set
     * 
     * set method for flicker model
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
     * get method for flicker model
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
     * buildURL
     * 
     * build the flicker url
     *
     * @author Aravind B Dev
     * @access private 
     * @return string flicker api url
     *
     */
    
    private function buildURL()
    {
        $tmpURL = '';
        foreach($this->data as $setting => $data)
        {
            $tmpURL .= '&'.$setting.'='.urlencode($data);
        }
        return $this->url.$tmpURL;
    }
    
    /**
     * setReturnImages
     * 
     * pass the settings of return images, set the return variable name and flicker image type
     *
     * @author Aravind B Dev
     * @access public 
     *
     */
    
    public function setReturnImages(array $imgSettings)
    {
        $this->image_settings = $imgSettings;
    }
    
    /**
     * getImages
     * 
     * display the template file
     *
     * @author Aravind B Dev
     * @access public 
     * @return array Images
     *
     */

    public function getImages()
    {
        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $this->buildURL());

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        //execute post
        $images = json_decode(curl_exec($ch), TRUE);

        //close connection
        curl_close($ch);
        
        return $this->processImages($images);
    }
    
    /**
     * processImages
     * 
     * process the flicker images
     *
     * @author Aravind B Dev
     * @access private 
     * @param array $images Images from flicker api
     * @return array processed flicker images
     *
     */

    private function processImages($images)
    {
        $images = isset($images['photos']) ? $images['photos'] : array();
        
        if(isset($images['total']) && $images['total'])
        {
            // if there is images in search result
            if($images['page'] > 1)
            {
                // if viewing any other page than first page
                // add previous button
                $images['previous_page'] = $images['page'] - 1;
            }

            if($images['page'] < $images['pages'])
            {
                // add next button
                $images['next_page'] = $images['page'] + 1;
            }
            
            foreach($images['photo'] as &$photo)
            {
                $tmp_img = "http://farm" . $photo['farm'] . ".static.flickr.com/" . $photo['server'] . "/" . $photo['id'] . "_"  . $photo['secret'];
                if(!empty($this->image_settings))
                {
                    // if user passed images settings
                    // use that settings and return the images
                    foreach($this->image_settings as $key => $setting)
                    {
                        $photo[$key] = $tmp_img . "_".$setting.".jpg";
                    }
                }
                else
                {
                    // set default image
                    $photo['default_img'] = $tmp_img . "_q.jpg";
                }
            }
        }
        return $images;
    }
}