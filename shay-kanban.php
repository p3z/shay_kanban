<?php
/**
 * Plugin Name: Shay Kanban
 * Description: A simple plugin to manage Kanban boards in WordPress.
 * Version: 1.02
 * Author: Shay Pottle
 */

if (!defined('ABSPATH')) {
    wp_die( 'Do not open this file directly.' );
}

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
        'not_found_in_trash' => __( 'No Kanban Boards found in trash', 'shay-kanban-boards' )
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => false,
        'show_in_menu'       => false,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'shay-kanban-boards' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'author', 'editor' ),
        'menu_icon' => 'dashicons-media-spreadsheet',
        //'menu_icon' => 'https://shaypottle.com/wp-content/uploads/2023/12/openai-icon.png'
    );

    register_post_type( 'shay-kanban-boards', $args );

    // Register custom fields
    register_post_meta( 'shay-kanban-boards', 'test-field', array(
        'type'         => 'text', // or 'textarea', 'checkbox', etc.
        'single'       => true,
        'show_in_rest' => true, // To make the field available in the block editor
    ));

    // Register custom fields
    register_post_meta( 'shay-kanban-boards', 'test-field-array', array(
        'type'         => 'text', // or 'textarea', 'checkbox', etc.
        'single'       => false,
        'show_in_rest' => true, // To make the field available in the block editor
    ));
}

add_action( 'init', 'kanban_boards_post_type' );


define("VIEWS_DIR", plugin_dir_path(__FILE__) . 'views/');


// Add admin menu for managing Kanban Boards
function kanban_boards_menu() {
    
    add_menu_page(
        'View all boards', // Page title
        'Shay Kanban',  // Menu title
        'manage_options',  // Capability required to access the menu
        'kanban_boards_list', // Callback function to display the menu page
        'kanban_boards_list_page', // Menu slug (unique identifier)
        'dashicons-admin-page' // Icon URL or Dashicon class for the menu icon
    );
    add_submenu_page( 'kanban_boards_list', 'Add New Kanban Board', 'Add New', 'manage_options', 'kanban_boards_add_new', 'kanban_boards_add_new_page' );
    add_submenu_page( 'kanban_boards_list', 'View settings', 'View settings', 'manage_options', 'kanban_boards_view_settings', 'kanban_boards_view_settings' );
    
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
        require_once(VIEWS_DIR . 'settings.php');
}
