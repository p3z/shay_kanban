<?php
/**
 * Plugin Name: Shay Kanban
 * Description: A simple plugin to manage Kanban boards in WordPress.
 * Version: 1.0
 * Author: Shay Pottle
 */

// Register Kanban Boards custom post type
function kanban_boards_post_type() {
    $labels = array(
        'name'               => _x( 'Kanban Boards', 'post type general name', 'shay-kanban-boards' ),
        'singular_name'      => _x( 'Kanban Board', 'post type singular name', 'shay-kanban-boards' ),
        'menu_name'          => _x( 'Kanban Boards', 'admin menu', 'shay-kanban-boards' ),
        'name_admin_bar'     => _x( 'Kanban Board', 'add new on admin bar', 'shay-kanban-boards' ),
        'add_new'            => _x( 'Add New', 'kanban board', 'shay-kanban-boards' ),
        'add_new_item'       => __( 'Add New Kanban Board', 'shay-kanban-boards' ),
        'new_item'           => __( 'New Kanban Board', 'shay-kanban-boards' ),
        'edit_item'          => __( 'Edit Kanban Board', 'shay-kanban-boards' ),
        'view_item'          => __( 'View Kanban Board', 'shay-kanban-boards' ),
        'all_items'          => __( 'All Kanban Boards', 'shay-kanban-boards' ),
        'search_items'       => __( 'Search Kanban Boards', 'shay-kanban-boards' ),
        'not_found'          => __( 'No Kanban Boards found', 'shay-kanban-boards' ),
        'not_found_in_trash' => __( 'No Kanban Boards found in trash', 'shay-kanban-boards' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'shay-kanban-boards' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    );

    register_post_type( 'shay-kanban-boards', $args );
}

add_action( 'init', 'kanban_boards_post_type' );


define("VIEWS_DIR", plugin_dir_path(__FILE__) . 'views/');


// Add admin menu for managing Kanban Boards
function kanban_boards_menu() {
    add_menu_page( 'Kanban Boards', 'Kanban Boards', 'manage_options', 'kanban_boards_list', 'kanban_boards_list_page' );
    add_submenu_page( 'kanban_boards_list', 'Add New Kanban Board', 'Add New', 'manage_options', 'kanban_boards_add_new', 'kanban_boards_add_new_page' );
    add_submenu_page( null, 'Edit Kanban Board', '', 'manage_options', 'kanban_boards_edit', 'kanban_boards_edit_page' ); // Hidden submenu for editing
}
add_action( 'admin_menu', 'kanban_boards_menu' );

function kanban_boards_list_page() {
    // Display the list of Kanban Boards
    require_once(VIEWS_DIR . 'kanban-list.php');
}

function kanban_boards_add_new_page() {
    // Display the form for adding a new Kanban Board
    require_once(VIEWS_DIR . 'new-kanban.php');
}

function kanban_boards_edit_page() {
    // Display the form for editing a Kanban Board
    require_once(VIEWS_DIR . 'single-kanban.php');
}

function kanban_boards_view_settings(){
        // Display settings page
        require_once(VIEWS_DIR . 'settings.php');
}
