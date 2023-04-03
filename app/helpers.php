<?php
use App\Models\Category;
/*********
    print_r short function
*********/

if(!function_exists('p')) {
    function p($value) {
        echo '<pre>';
        print_r($value);
        echo '</pre>';
    }
}

/*******************************
 *
 * Add active class for current menu item
 *
 ***************************************************/
if(!function_exists('currentMenuItem')) {
    function currentMenuItem($currentUrl){
        // p($currentUrl); die;
        return request()->routeIs("*".$currentUrl."*") ? "class=current-menu-item" : '';
    }
}

/*******************************
 *
 * Get categories by ids
 *
 ***************************************************/
if(!function_exists('getCategories')) {
    function getCategories($ids){
        //p("Hello"); die;
        $categories = Category::whereIn('id', $ids)->get();
        $catName = [];
        foreach ($categories as $key => $cat) {
            array_push($catName, $cat->title);
        }
        //p($catName); die;
        return $catName;
    }
}

/*******************************
 *
 * Get instagram feed
 *
 ***************************************************/
if(!function_exists('getInstagram')) {
    function getInstagram(){
        $fields = "id,caption,media_type,media_url,permalink,thumbnail_url,timestamp,username";
        $token = config('services.instagram.instagram_token');
        $limit = 14;

        //$json_feed_url="https://graph.instagram.com/me/media?fields={$fields}&access_token={$token}&limit={$limit}";
        $json_feed_url="https://graph.instagram.com/me/media?fields={$fields}&access_token={$token}&limit={$limit}";
        $json_feed = @file_get_contents($json_feed_url);
        $contents = json_decode($json_feed, true, 512, JSON_BIGINT_AS_STRING);
        return $contents;
    }
}

if(!function_exists('seo_friendly_url')) {
    function seo_friendly_url($string){
        $string = str_replace(array('[\', \']'), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
        return strtolower(trim($string, '-'));
    }
}

if(!function_exists('cleaner')) { 
    function cleaner($url) {
        $url = strip_tags($url);
        $U = explode(' ',$url);
      
        $W =array();
        foreach ($U as $k => $u) {
          if (stristr($u,'http') || (count(explode('.',$u)) > 1)) {
            unset($U[$k]);
            return cleaner( implode(' ',$U));
          }
        }
        return implode(' ',$U);
      }
}

?>
