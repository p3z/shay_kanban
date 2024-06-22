<?php

function create_new_kanban(){
    
    //echo "Creating new board";
    
    //pws_dd($_POST);
    
    
    $new_post = array(
        'post_title' => $_POST['kanban_name'],
        'post_type' => 'shay-kanban-boards',
        'post_status' => 'publish'
    );

    // Insert the post into the database
    $post_id = wp_insert_post( $new_post );
    
    wp_redirect(admin_url('admin.php?page=kanban_boards_list'));
    exit();

    // Only let shay use this controller for testing purposes
    // <!--if( get_current_user_id() !== 1 ){-->
    // <!--    wp_redirect( home_url() );-->
    // <!--}-->
    
    //header('Content-Type: application/json');
    
    // Additional info needed that's not currently part of the form
    
 
} // end fn 
add_action('admin_post_create_new_kanban', 'create_new_kanban');
add_action('admin_post_nopriv_create_new_kanban', 'create_new_kanban');


?>