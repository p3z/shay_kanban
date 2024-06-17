<?php

$pages_needing_jquery = [];
$pages_needing_jkanban = ['kanban_boards_add_new'];

function skb_enqueues() {
    
    global $pages_needing_jquery, $pages_needing_jkanban;
    
    $current_page = $_GET['page'] ?? NULL;
    
    if( isset($current_page) ){
        
        if( in_array($current_page, $pages_needing_jquery) ){
            //wp_enqueue_script('jquery', plugins_url('assets/frontend/js/jquery.js', ['jquery'], '1.0', true);
        } // end $pages_needing_jquery check
        
        if( in_array($current_page, $pages_needing_jkanban) ){
            wp_enqueue_style('kanban', plugins_url('assets/kanban/jkanban.css', __FILE__ ), '1.0', 'all');
            wp_enqueue_script('kanban-js', plugins_url('assets/kanban/jkanban.js', __FILE__ ), '1.0', false);
        } // end $pages_needing_jkanban check
        
        /* STYLES */
        wp_enqueue_style('nucleo-icons', plugins_url('assets/css/nucleo-icons.css', __FILE__ ), '1.0', 'all');
        wp_enqueue_style('nucleo-svg', plugins_url('assets/css/nucleo-svg.css', __FILE__ ), '1.0', 'all');
        wp_enqueue_style('material-dashboard', plugins_url('assets/css/material-dashboard.css?v=3.1.0', __FILE__ ), '1.0', 'all');
        
        /* SCRIPTS */
        wp_enqueue_script('popper', plugins_url('assets/js/core/popper.min.js', __FILE__ ), '1.0', true);
        wp_enqueue_script('bootstrap', plugins_url('assets/js/core/bootstrap.min.js', __FILE__ ), '1.0', true);
        wp_enqueue_script('perfect-scrollbar', plugins_url('assets/js/plugins/perfect-scrollbar.min.js', __FILE__ ), '1.0', true);
        wp_enqueue_script('smooth-scrollbar', plugins_url('assets/js/plugins/smooth-scrollbar.min.js', __FILE__ ), '1.0', true);
        
        // Control Center for Material Dashboard: parallax effects, scripts for the example pages etc
        wp_enqueue_script('material-dashboard', plugins_url('assets/js/material-dashboard.min.js?v=3.1.0', __FILE__ ), '1.0', true);
        // Also houses the label animation for videos, don't delete
      
        wp_enqueue_script('pws_global', plugins_url('assets/js/pws_global.js', __FILE__ ), '1.0', true);
        
        
    } // end isset($current_page)
   
}

add_action('admin_enqueue_scripts', 'skb_enqueues');


?>