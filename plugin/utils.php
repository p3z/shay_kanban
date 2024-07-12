<?php

class MoneyUtils{
    
    public static function add_vat( $num ){
        return $num * 1.2;
    }
    
    public static function is_money( $amt ){
        return round($amt, 2);
    }

}// end class

class WpUtils{
    
    public static function get_user_role( $user_id ){
        
        $user = get_user_by('id', $user_id);
        
        if( !$user ){
            return NULL;
        }
        
        return $user->roles[0];
        
    }
    
    // Inside WpUtils because makes use of wp_checkdate
    public static function validate_date($date) {
        // Split the date into components
        $date_parts = explode('-', $date); // Assuming the date format is YYYY-MM-DD
    
        // Ensure we have three parts: year, month, day
        if (count($date_parts) !== 3) {
            return false;
        }
    
        list($year, $month, $day) = $date_parts;
    
        // Use wp_checkdate to validate the date
        return wp_checkdate($month, $day, $year, $date);
    }
    
}

class FileUtils{
    
    public static function is_valid_directory( $path ){
        return file_exists($path) && is_dir($path);
    }
    
    public static function get_file_extension( $file_path ){
        return strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
    }// end fn
    
    public static function check_file_exists( $folder_to_check, $file_name ){
        
        // Construct the pattern to match files containing the specific string
        $pattern = $folder_to_check . '/*' . $file_name . '*';
        $file_matches = glob( $pattern ); // Search for files matching the pattern
        
        return $file_matches;
        
    }// end fn
    
}

class StringUtils{
    
    public static function is_valid_str( $str ){
        return isset( $str ) && $str !== "";
    }
    
    public static function sanitize_number_string( $num_string ){
        $sanitized_str = sanitize_text_field( $num_string );
        return preg_replace('/[^0-9-]/', '', $sanitized_str);
    }
    
    public static function search_and_replace( $content, $variables = [] ){
        
        // Match all placeholders in the format {{{VAR_NAME}}}
        preg_match_all('/{{{(\w+)}}}/', $content, $matches);
    
        // Replace each placeholder with the corresponding value from the $variables array
        foreach ($matches[1] as $placeholder) {
            
            if (isset($variables[$placeholder])) {
                $content = str_replace('{{{' . $placeholder . '}}}', $variables[$placeholder], $content);
            }
        }
    
        return $content;
    } // end fn
    
    public static function truncate_text( $content, $max_chars, $use_ellipsis = false){
        
        if( strlen($content) > $max_chars ){
            
            $content = substr($content, 0,  $max_chars);
            
            if( $use_ellipsis ){
                $content = substr($content, 0, -3);
                $content .= "...";
            }
        }
        
        return $content;
    }// end fn
    
    public static function add_possessive_suffix($name) {
        if (substr($name, -1) === 's') {
            return $name . "'";
        } else {
            return $name . "'s";
        }
    }
    
}

class DateTimeUtils{
    
    public static function validate_time($time) {
        // Regular expression to match time formats HH:MM and HH:MM:SS
        $time_pattern = '/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/';
    
        // Check if the time matches the pattern
        if (!preg_match($time_pattern, $time)) {
            return false;
        }
    
        // Split the time into components
        $time_parts = explode(':', $time);
        $hour = (int) $time_parts[0];
        $minute = (int) $time_parts[1];
        $second = isset($time_parts[2]) ? (int) $time_parts[2] : 0;
    
        // Validate the hour, minute, and second ranges
        if ($hour < 0 || $hour > 23 || $minute < 0 || $minute > 59 || $second < 0 || $second > 59) {
            return false;
        }
    
        return true;
    }
    
    public static function get_date_time( ){
                    
            // $today1 = date("F j, Y, g:i a");                 // March 10, 2001, 5:16 pm
            // $today2 = date("m.d.y");                         // 03.10.01
            // $today4 = date("Ymd");                           // 20010310
            // $today5 = date('h-i-s, j-m-y, it is w Day');     // 05-16-18, 10-03-01, 1631 1618 6 Satpm01
            // $today6 = date('\i\t \i\s \t\h\e jS \d\a\y.');   // it is the 10th day.
            // $today7 = date("D M j G:i:s T Y");               // Sat Mar 10 17:16:18 MST 2001
            // $today8 = date('H:m:s \m \i\s\ \m\o\n\t\h');     // 17:03:18 m is month
            // $today9 = date("H:i:s");                         // 17:16:18
            // $today10 = date("Y-m-d H:i:s");
            // $today11 = date("Ymd_His");
            
            // echo $today11;
    }
    
}// end class

class UrlUtils{
    
    // Break a url into an array of its path segments
    public static function get_url_path_array( $url = NULL ){
         
        if( !is_null($url) ){ // Passed in a url
        
            $current_url = $url;
            
        } else { // Use current page
            global $wp;
            $current_url = esc_url(home_url($wp->request));
            
        }
        
        
        $parsed = parse_url($current_url);
        $path = $parsed['path'];
        
        // Remove first and last slashes of url
        $trimmed_url = trim( $path, "/" );
        
        // Convert to an array, broken into pieces along remaining slashes
        $path_parts = explode('/', $trimmed_url);
        
        return $path_parts;
        
    }
    
} // end class

function set_ids_on_headings($html) {
    $dom = new DOMDocument();
    $dom->loadHTML($html);

    $headings = $dom->getElementsByTagName('h1');
    foreach ($headings as $heading) {
        $content = $heading->nodeValue;
        $id = str_replace(' ', '_', strtolower($content));
        $heading->setAttribute('id', $id);
    }

    $headings = $dom->getElementsByTagName('h2');
    foreach ($headings as $heading) {
        $content = $heading->nodeValue;
        $id = str_replace(' ', '_', strtolower($content));
        $heading->setAttribute('id', $id);
    }

    $headings = $dom->getElementsByTagName('h3');
    foreach ($headings as $heading) {
        $content = $heading->nodeValue;
        $id = str_replace(' ', '_', strtolower($content));
        $heading->setAttribute('id', $id);
    }
    
    $headings = $dom->getElementsByTagName('h4');
    foreach ($headings as $heading) {
        $content = $heading->nodeValue;
        $id = str_replace(' ', '_', strtolower($content));
        $heading->setAttribute('id', $id);
    }
    
    $headings = $dom->getElementsByTagName('h5');
    foreach ($headings as $heading) {
        $content = $heading->nodeValue;
        $id = str_replace(' ', '_', strtolower($content));
        $heading->setAttribute('id', $id);
    }

    $headings = $dom->getElementsByTagName('h6');
    foreach ($headings as $heading) {
        $content = $heading->nodeValue;
        $id = str_replace(' ', '_', strtolower($content));
        $heading->setAttribute('id', $id);
    }
    
    return $dom->saveHTML();
}

function html_to_navigation($html) {
    $dom = new DOMDocument();
    $dom->loadHTML($html);

    $sections = [];
    $currentSection = null;

    foreach ($dom->getElementsByTagName('*') as $element) {
        if ($element->tagName == 'h1') {
            $currentSection = trim($element->nodeValue);
            $sections[$currentSection] = [];
        } elseif ($element->tagName == 'h2' || $element->tagName == 'h3' || $element->tagName == 'h4' || $element->tagName == 'h5' || $element->tagName == 'h6') {
            if ($currentSection !== null) {
                $sections[$currentSection][] = trim($element->nodeValue);
            }
        }
    }

    return $sections;
}

function truncate_string($input_string, $max_length, $use_ellipsis = true) {
    // Check if the string is shorter than or equal to the specified length
    if (strlen($input_string) <= $max_length) {
        return $input_string; // Return the original string
    } else {
        // Truncate the string to the specified length
        $truncated_string = substr($input_string, 0, $max_length);
        
        if( $use_ellipsis ){
            $truncated_string .= "...";
        }
        
        return $truncated_string;
    }
}

function get_menu_id_by_slug( $slug ) {
    $menus = get_terms( 'nav_menu' ); 

    foreach ( $menus as $menu ) {
        if( $slug === $menu->slug ) {
            return $menu->term_id;
        }
    }
    return false;
}

// Outputs categories as a simple array where any children are nested beneath a sub array called 'children' 
function get_simple_category_list(){

    $categories = get_categories();
    $simple_categories_list = [];

    foreach ($categories as $category) {
       
       
        // If item has children
        if($category->category_parent !== "0"){
            
            $simple_categories_list[$category->category_parent]['children'][] = [
                'slug' => $category->slug,
                'name' => $category->cat_name,
                'count' => $category->category_count
            ];
            
        } else {
            
             $simple_categories_list[$category->ID] = [
                'slug' => $category->slug,
                'name' => $category->cat_name,
                'count' => $category->category_count
            ];
        }
        
    } // end loop
    
    return $simple_categories_list;

}

// Outputs menu items as a simple array where any children are nested beneath a sub array called 'children' 
function get_simple_menu_by_id( $menu_id ){
    $header_menu_items = wp_get_nav_menu_items($menu_id);
    $menu_items = [];
    
    if( $header_menu_items === false){
       return [];
    }
    
    foreach ($header_menu_items as $menu_item) {
       
       
        // If item has children
        if($menu_item->menu_item_parent !== "0"){
            
            $menu_items[$menu_item->menu_item_parent]['children'][] = [
                'url' => $menu_item->url,
                'title' => $menu_item->title
            ];
            
        } else {
            
             $menu_items[$menu_item->ID] = [
                'url' => $menu_item->url,
                'title' => $menu_item->title
            ];
        }
        
    } // end loop
    
    return $menu_items;
} // end fn

function dd($data, $use_pre = true, $type="json"){

    if($use_pre){
        echo "<pre>";
    }
    
    switch($type){

        case "json":
            $data = json_encode($data);
            //if( !headers_sent() ){
                header_remove('Content-Type');
                header('Content-Type: application/json');
            //}
            
            echo $data;
            break;
        case "print":
            print_r($data);
            break;

        default:
            var_dump($data);

    } // end switch
    

    if($use_pre){
        echo "</pre>";
        echo "<br>";
    }
    
    die();
}// end fn

function string_contains($haystack, $needle){

    $position = strpos($haystack, $needle);
    return $position !== false;

}// end fn

// Locates the needle in the haystack and returns the remaining string after it
function substring_extract($haystack, $needle) {

    $position = strpos($haystack, $needle);
    $remaining_text = "";

    if ($position !== false) {
        $remaining_text = substr($haystack, $position + strlen($needle));       
    }

    return $remaining_text;
       
}// end fn

function generate_rand_str($bytes){
    $salt = bin2hex(random_bytes($bytes)); // 16 bytes = 32 hexadecimal characters
    return $salt;
}

/*
* $data: string -> the data you want to hash
* $salt: string -> a randomly generated salt for this user only
*
*/
function pws_hash($data, $salt){
    $concat_str = $salt . $data . PEPPER; // Pepper is a global salt (ie it applies to all users)
    return hash('sha256', $concat_str);
}

function sanitise_string($string, $display_html = false, $strict = false){

    $sanitised_string = trim($string); // Remove whitespace
    

    if( $display_html ){

       if( $strict ){
            $sanitised_string = htmlentities($sanitised_string); // Convert all applicable characters to HTML entities (identical to htmlspecialchars() in all ways, except with htmlentities(), all characters which have HTML character entity equivalents are translated into these entities)
        } else {
            $sanitised_string = htmlspecialchars($sanitised_string); // Convert most popular special characters to HTML entities (If you require ALL HTML character entities to be translated, use htmlentities() instead.)
        }

    } else {

        // This string should NOT display html of any kind
        $sanitised_string = strip_tags($sanitised_string); // Remove html chars
        $sanitised_string = htmlspecialchars($sanitised_string);
    }
    

    // escapeshellcmd // Escape shell metacharacters

    return $sanitised_string;
} // end fn

function calculate_total_pages($total_results, $per_page = 10) {
    return ceil($total_results / $per_page);
}

// 
function paginate_results($arr, $per_page = 10, $current_page = 1) {
    $total_results = count($arr);
    $start_index = ($current_page - 1) * $per_page;
    $end_index = min($start_index + $per_page - 1, $total_results - 1);
  
    $paginated_results = array_slice($arr, $start_index, $per_page);

    //dd(["paginated results", $paginated_results]);

    return $paginated_results;
  }

function get_expiry_timestamp( $num_hours ){
    return time() + $num_hours * 60 * 60; // current timestamp + required number of hours (num_hours * 60m * 60s)
}



function update_file($path, $data, $overwrite = true) {

        $return = new stdClass();
        $return->file_path = $path;
        $method = "a";

        if($overwrite){
                $method = "w";
        }  
       

        try{
                $file = fopen($path, $method);
                fwrite($file, $data);
                fclose($file);
                $return->success = true;
                $return->message = "Data successfully written to file";
                
        } catch(Exception $e){
                $return->message = "Data failed to write to file. Error message: " . (string)$e;
                $return->success = false;
        }
        
        return $return;
} // end fn

function create_log($file_path, $data){
        $timestamp = date("Y-m-d h:i:sa");
        update_file($file_path, "\n\n", false);
        update_file($file_path, "=======================", false);
        update_file($file_path, " $timestamp ", false);
        update_file($file_path, "=======================", false);
        update_file($file_path, "\n\n", false);
        update_file($file_path, $data, false);
        update_file($file_path, "\n\n", false);
}


function spaces_to_underscores($string) {
    return preg_replace('/\s+/', '_', $string);
}


// Returns a logical 'row' of items from an flat array.
// $items_arr =-> array of items that you want to select from
// $items_per_row (int) -> the total qty of items in 
// $row_number -> which row you want returned
// if $row_number is greater than the number of rows possible, empty array is returned

// return is a 'row', ie a slice of items from the $items_arr of $items_per_row length
function get_row_items($items_arr, $items_per_row, $row_number) {
    // Calculate the start and end index for the specified row
    $start_index = ($row_number - 1) * $items_per_row;
    $end_index = $start_index + $items_per_row;
    
    // Slice the array to get the items for the specified row
    $row_items = array_slice($items_arr, $start_index, $items_per_row);
    
    return $row_items;
}

function is_password_strong($password) {
    // Check if password contains at least 1 uppercase letter
    if (!preg_match('/[A-Z]/', $password)) {
        return false;
    }

    // Check if password contains at least 1 lowercase letter
    if (!preg_match('/[a-z]/', $password)) {
        return false;
    }

    // Check if password contains at least 1 number
    if (!preg_match('/[0-9]/', $password)) {
        return false;
    }

    // Check if password contains at least 1 special character
    if (!preg_match('/[^A-Za-z0-9]/', $password)) {
        return false;
    }

    // If all criteria are met, return true
    return true;
}


?>