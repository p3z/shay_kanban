<?php

$pages_needing_jquery = [];
$pages_needing_jkanban = ['kanban_boards_add_new'];

function skb_enqueues() {
    
    global $pages_needing_jquery, $pages_needing_jkanban;
    
    $current_page = $_GET['page'] ?? NULL;
    
    if( isset($current_page) ){
        
        if( in_array($current_page, $pages_needing_jquery) ){
            //wp_enqueue_script('jquery', VIEWS_DIR . 'assets/frontend/js/jquery.js', ['jquery'], '1.0', true);
        } // end $pages_needing_jquery check
        
        if( in_array($current_page, $pages_needing_jkanban) ){
            wp_enqueue_style('kanban', VIEWS_DIR . 'assets/backend/kanban/jkanban.css', [], '1.0', 'all');
            wp_enqueue_script('kanban-js', VIEWS_DIR . 'assets/backend/kanban/jkanban.js', [], '1.0', false);
        } // end $pages_needing_jkanban check
        
        /* STYLES */
        wp_enqueue_style('nucleo-icons', VIEWS_DIR . 'assets/backend/css/nucleo-icons.css', [], '1.0', 'all');
        wp_enqueue_style('nucleo-svg', VIEWS_DIR . 'assets/backend/css/nucleo-svg.css', [], '1.0', 'all');
        wp_enqueue_style('material-dashboard', VIEWS_DIR . 'assets/backend/css/material-dashboard.css?v=3.1.0', [], '1.0', 'all');
        
        /* SCRIPTS */
        wp_enqueue_script('popper', VIEWS_DIR . 'assets/backend/js/core/popper.min.js', [], '1.0', true);
        wp_enqueue_script('bootstrap', VIEWS_DIR . 'assets/backend/js/core/bootstrap.min.js', [], '1.0', true);
        wp_enqueue_script('perfect-scrollbar', VIEWS_DIR . 'assets/backend/js/plugins/perfect-scrollbar.min.js', [], '1.0', true);
        wp_enqueue_script('smooth-scrollbar', VIEWS_DIR . 'assets/backend/js/plugins/smooth-scrollbar.min.js', [], '1.0', true);
        
        // Control Center for Material Dashboard: parallax effects, scripts for the example pages etc
        wp_enqueue_script('material-dashboard', VIEWS_DIR . 'assets/backend/js/material-dashboard.min.js?v=3.1.0', [], '1.0', true);
        // Also houses the label animation for videos, don't delete
      
        wp_enqueue_script('pws_global', VIEWS_DIR . 'assets/global/js/pws_global.js', [], '1.0', true);
        
        
    } // end isset($current_page)
   
}

add_action('admin_enqueue_scripts', 'skb_enqueues');


?>